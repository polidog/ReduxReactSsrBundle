<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/11/03
 */

namespace Polidog\ReduxReactSsrBundle\Annotations;

/**
 * @Annotation
 */
final class SsrTemplate
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $engine = 'twig';

    /**
     * @var string
     */
    private $rootContainer = "App";

    /**
     * @var string
     */
    private $id = "root";


    /**
     * SsrTemplate constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data['template'])) {
            $this->template = $data['template'];
        }

        if (isset($data['engine'])) {
            $this->engine = $data['engine'];
        }

        if (isset($data['rootContainer'])) {
            $this->rootContainer = $data['rootContainer'];
        }

        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @return string
     */
    public function getRootContainer()
    {
        return $this->rootContainer;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


}