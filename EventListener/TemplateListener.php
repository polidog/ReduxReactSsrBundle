<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/11/04
 */

namespace Polidog\ReduxReactSsrBundle\EventListener;


use Doctrine\Common\Annotations\Reader;
use Koriym\ReduxReactSsr\ReduxReactJsInterface;
use Polidog\ReduxReactSsrBundle\Annotations\SsrTemplate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Templating\EngineInterface;

class TemplateListener implements EventSubscriberInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ReduxReactJsInterface
     */
    private $reduxReactSsr;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var string
     */
    private $defaultTemplate;

    /**
     * TemplateListener constructor.
     * @param Reader $reader
     * @param ReduxReactJsInterface $reduxReactSsr
     * @param EngineInterface $templating
     * @param string $defaultTemplate
     */
    public function __construct(Reader $reader, ReduxReactJsInterface $reduxReactSsr, EngineInterface $templating, $defaultTemplate)
    {
        $this->reader = $reader;
        $this->reduxReactSsr = $reduxReactSsr;
        $this->templating = $templating;
        $this->defaultTemplate = $defaultTemplate;
    }

    public function onKernelController(FilterControllerEvent $event)
    {

        $request = $event->getRequest();
        $controller = $event->getController();

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        $template = $this->reader->getMethodAnnotation($method, SsrTemplate::class);

        // no @SsrTemplate present
        if (null === $template) {
            return;
        }

        if (null === $template->getTemplate()) {
            $template->setTemplate($this->defaultTemplate);
        }

        if (empty($template->getTemplate())) {
            throw new \InvalidArgumentException('template not found.');
        }

        $request->attributes->set("_ssr_template", $template);
    }


    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $template = $request->attributes->get('_ssr_template');

        // no @Template present
        if (null === $template) {
            return;
        }

        if (!$template instanceof SsrTemplate) {
            throw new \InvalidArgumentException('Request attribute "_template" is reserved for @SsrTemplate annotations.');
        }

        $parameters = $event->getControllerResult();
        if (!isset($parameters['state'])) {
            return ;
        }

        if ($request->isXmlHttpRequest()) {
            $event->setResponse(new JsonResponse($parameters['state']));
            return;
        }

        $ssr = $this->reduxReactSsr;
        list($html, $js) = $ssr($template->getRootContainer(), $parameters['state'], $template->getId());

        $parameters['markup'] = $html;
        $parameters['js'] = $js;

        $event->setResponse(new Response($this->templating->render($template->getTemplate(), $parameters)));
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => ['onKernelController', 10],
            KernelEvents::VIEW => ['onKernelView', 10],
        );
    }

}