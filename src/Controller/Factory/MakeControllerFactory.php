<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:40
 */

namespace Make\Controller\Factory;


use Interop\Container\ContainerInterface;
use Make\Controller\MakeController;
use Zend\ServiceManager\Factory\FactoryInterface;

class MakeControllerFactory implements FactoryInterface{

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
       return new MakeController($container);
    }
}