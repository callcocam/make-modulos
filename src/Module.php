<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:11
 */

namespace Make;


use Make\Form\View\Helper\MakeButton;
use Make\Form\View\Helper\MakeForm;
use Make\Model\Factory\TableFactory;
use Make\Model\Table;
use Make\View\Helper\Factory\TplFactory;
use Make\View\Helper\Factory\TplListaFactory;
use Make\View\Helper\FontAwesome;
use Make\View\Helper\Glyphicon;
use Make\View\Helper\HtmlElement;
use Make\View\Helper\TplHelper;
use Make\View\Helper\TplListaHelper;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

use Make\Form\Factory\MakesFilterFactory;

use Make\Form\Factory\MakesFormFactory;

use Make\Form\MakesFilter;

use Make\Form\MakesForm;

use Make\Model\Makes\Factory\MakesFactory;

use Make\Model\Makes\Factory\MakesRepositoryFactory;

use Make\Model\Makes\Makes;

use Make\Model\Makes\MakesRepository;

class Module implements ConfigProviderInterface, ServiceProviderInterface,ViewHelperProviderInterface{

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__."/../config/module.config.php";
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories'=>[
                Makes::class=>MakesFactory::class,

                MakesRepository::class=>MakesRepositoryFactory::class,

                MakesForm::class=>MakesFormFactory::class,

                MakesFilter::class=>MakesFilterFactory::class,

                Table::class=>TableFactory::class
            ],
            'aliases'=>[
            ],
            'invokables'=>[

            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return [
            'factories'=>[
                TplHelper::class=>TplFactory::class,
                TplListaHelper::class=>TplListaFactory::class,
                Table::class=>TableFactory::class
             ],
            'aliases'=>[
                'TplHelper'=>TplHelper::class,
                'TplListaHelper'=>TplListaHelper::class,
             ],
            'invokables'=>[
                'MakeForm'=>MakeForm::class,
                'Html'=>HtmlElement::class,
                'fontAwesome'=>FontAwesome::class,
                'glyphicon'=>Glyphicon::class,
                'MakeButton'=>MakeButton::class,
            ]
        ];
    }
}