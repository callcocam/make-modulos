<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 18/08/2016
 * Time: 19:47
 */

namespace Make\View\Helper\Factory;


use Make\View\Helper\TplHelper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TplFactory implements FactoryInterface {

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TplHelper($container);
    }
}