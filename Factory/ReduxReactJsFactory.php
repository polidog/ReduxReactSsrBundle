<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/11/04
 */

namespace Polidog\ReduxReactSsrBundle\Factory;


use Koriym\ReduxReactSsr\ReduxReactJs;

class ReduxReactJsFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create($reactBundleSrc, $appBundleSrc)
    {
        return new ReduxReactJs(file_get_contents($reactBundleSrc), file_get_contents($appBundleSrc));
    }

}