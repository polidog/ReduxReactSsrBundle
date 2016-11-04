<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/11/04
 */

namespace Polidog\ReduxReactSsrBundle\Factory;


use Polidog\ReduxReactRouterSsr\ReduxReactRouterJs;

class ReduxReactRouterJsFactory implements FactoryInterface
{
    /**
     * @param string $reactBundleSrc
     * @param string $appBundleSrc
     * @return ReduxReactRouterJs
     */
    public static function create($reactBundleSrc, $appBundleSrc)
    {
        return new ReduxReactRouterJs(file_get_contents($reactBundleSrc), file_get_contents($appBundleSrc));
    }

}