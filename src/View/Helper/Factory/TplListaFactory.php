<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 25/08/2016
 * Time: 09:36
 */

namespace Make\View\Helper\Factory;


use Interop\Container\ContainerInterface;
use Make\View\Helper\TplListaHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

class TplListaFactory implements FactoryInterface{

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
        return new TplListaHelper($container);
    }
}