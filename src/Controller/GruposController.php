<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Controller;

use Base\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Make\Form\GruposFilter;
use Make\Form\GruposForm;
use Make\Model\Grupos\Grupos;
use Make\Model\Grupos\GruposRepository;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class GruposController extends AbstractController
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
        $this->table=GruposRepository::class;
        $this->model=Grupos::class;
        $this->form=GruposForm::class;
        $this->filter=GruposFilter::class;
        $this->route="make";
        $this->controller="grupos";
    }


}

