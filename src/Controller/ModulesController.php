<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Controller;

use Base\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Make\Form\ModulesFilter;
use Make\Form\ModulesForm;
use Make\Model\Modules\Modules;
use Make\Model\Modules\ModulesRepository;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class ModulesController extends AbstractController
{

    /**
     * __construct Factory Model
     *
     * @return __construct
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        // Configurações iniciais do Controller
        $this->containerInterface=$containerInterface;
        $this->table=ModulesRepository::class;
        $this->model=Modules::class;
        $this->form=ModulesForm::class;
        $this->filter=ModulesFilter::class;
        $this->route="make";
        $this->controller="modules";
    }


}

