<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 24/07/2016
 * Time: 19:14
 */

namespace Make\Model\Factory;


use Interop\Container\ContainerInterface;
use Make\Model\Table;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TableFactory implements FactoryInterface{

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
        return new Table($container->get(AdapterInterface::class));
    }
}