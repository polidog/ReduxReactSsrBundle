<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/11/04
 */

namespace Polidog\ReduxReactSsrBundle\Factory;


use Koriym\ReduxReactSsr\ReduxReactJsInterface;
use Polidog\ReduxReactRouterSsr\ReduxReactRouterInterface;

interface FactoryInterface
{
    /**
     * @param string $reactBundleSrc
     * @param string $appBundleSrc
     * @return ReduxReactJsInterface|ReduxReactRouterInterface
     */
    public static function create($reactBundleSrc, $appBundleSrc);
}