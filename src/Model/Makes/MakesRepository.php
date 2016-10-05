<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Model\Makes;

use Base\Model\AbstractModel;
use Zend\Db\TableGateway\TableGateway;
use Base\Model\AbstractRepository;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class MakesRepository extends AbstractRepository
{

    /**
     * __construct Factory Model
     *
     * @param TableGateway $tableGateway
     * @return \Make\Model\Makes\MakesRepository
     */
    public function __construct(TableGateway $tableGateway)
    {
        // Configurações iniciais do Factory Repository
        $this->tableGateway=$tableGateway;
    }

    public function insert(AbstractModel $model)
    {
        $model->setAssetId('makes');
        $model->setArquivo($this->StringSpace($model->getArquivo()));
        //$model->setRoute(strtolower($model->getArquivo()));
        $model->setController(strtolower($model->getArquivo()));
        $model->setAlias(sprintf("%s\Controller\%s",$model->getParent(),$model->getArquivo()));
        //$model->setAlias(sprintf("%s_controller_%scontroller",strtolower($model->getParent()),strtolower($model->getArquivo())));
        return parent::insert($model);
    }

    public function update(AbstractModel $model, $where = null)
    {
        $model->setAssetId('makes');
        $model->setArquivo($this->StringSpace($model->getArquivo()));
        //$model->setRoute(strtolower($model->getArquivo()));
        $model->setController(strtolower($model->getArquivo()));
        $model->setAlias(sprintf("%s\Controller\%s",$model->getParent(),$model->getArquivo()));
        return parent::update($model, $where);
    }



}

