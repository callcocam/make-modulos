<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Form;

use Base\Form\AbstractForm;
use Interop\Container\ContainerInterface;
use Make\Model\Grupos\GruposRepository;


/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class MakesForm extends AbstractForm
{

    /**
     * construct do Table
     *
     * @return  \Make\Form\MakesForm
     * @param ContainerInterface $containerInterface
     * @param string $name
     * @param array $options
     */
    public function __construct(ContainerInterface $containerInterface, $name = 'Makes', array $options = array())
    {
        // Configurações iniciais do Form;
        parent::__construct($containerInterface, $name, $options);
        $this->setAttribute("id","Manager");
        $this->setInputFilter($containerInterface->get(MakesFilter::class));
        $this->setId([]);
        $this->setAssetid([]);
        $this->setCodigo([]);
        $this->setEmpresa([]);
        //############################################ informações da coluna title ##############################################:
        $this->add([
                'type' => 'text',//hidden, select, radio, checkbox, textarea
                'name' => 'title',
                'options' => [
                    'label' => 'FILD_TITLE_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'TITLE'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'title',
                    'class' =>'form-control',
                    'title' => 'FILD_TITLE_DESC',
                    'placeholder' => 'FILD_TITLE_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );

        //############################################ informações da coluna grupo ##############################################:
        $this->add([
                'type' => 'select',//hidden, select, radio, checkbox, textarea
                'name' => 'grupo',
                'options' => [
                    'label' => 'FILD_GRUPO_LABEL',
                    'value_options'      =>$this->setValueOption(GruposRepository::class,['state'=>'0'],'alias','title'),
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'TABELA'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'grupo',
                    'class' =>'form-control',
                    'title' => 'FILD_GRUPO_DESC',
                    'placeholder' => 'FILD_GRUPO_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna parent ##############################################:
        $this->add([
                'type' => 'select',//text, select, radio, checkbox, textarea
                'name' => 'parent',
                'options' => [
                    'label' => 'FILD_PARENT_LABEL',
                    'value_options'      =>$this->setValueOption(GruposRepository::class,['state'=>'0'],'alias','title'),
                    'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'PARENT'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'parent',
                    'class' =>'form-control',
                    'title' => 'FILD_PARENT_DESC',
                    'placeholder' => 'FILD_PARENT_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna arquivo ##############################################:
        $this->add([
                'type' => 'text',//hidden, select, radio, checkbox, textarea
                'name' => 'arquivo',
                'options' => [
                    'label' => 'FILD_ARQUIVO_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'ARQUIVO'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'arquivo',
                    'class' =>'form-control',
                    'title' => 'FILD_ARQUIVO_DESC',
                    'placeholder' => 'FILD_ARQUIVO_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna route ##############################################:
        $this->add([
                'type' => 'text',//hidden, select, radio, checkbox, textarea
                'name' => 'route',
                'options' => [
                    'label' => 'FILD_ROUTE_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'ROUTE'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'route',
                    'class' =>'form-control',
                   'title' => 'FILD_ROUTE_DESC',
                    'placeholder' => 'FILD_ROUTE_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna controller ##############################################:
        $this->add([
                'type' => 'hidden',//text, select, radio, checkbox, textarea
                'name' => 'controller',
                'options' => [
                    // 'label' => 'FILD_CONTROLLER_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'CONTROLLER'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'controller',
                    //'class' =>'form-control',
                    //'title' => 'FILD_CONTROLLER_DESC',
                    //'placeholder' => 'FILD_CONTROLLER_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna action ##############################################:
        $this->add([
                'type' => 'hidden',//hidden, select, radio, checkbox, textarea
                'name' => 'action',
                'options' => [
                    // 'label' => 'FILD_ACTION_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'ACTION'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'action',
                    //'class' =>'form-control',
                    //'title' => 'FILD_ACTION_DESC',
                    //'placeholder' => 'FILD_ACTION_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                    'value'=>'index'
                ],
            ]
        );


        //############################################ informações da coluna privilege ##############################################:
        $this->add([
                'type' => 'hidden',//hidden, select, radio, checkbox, textarea
                'name' => 'privilege',
                'options' => [
                    // 'label' => 'FILD_PRIVILEGE_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'PRIVILEGE'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'privilege',
                    // 'class' =>'form-control',
                    //'title' => 'FILD_PRIVILEGE_DESC',
                    // 'placeholder' => 'FILD_PRIVILEGE_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                    'value'=>'index'
                ],
            ]
        );


        //############################################ informações da coluna alias ##############################################:
        $this->add([
                'type' => 'hidden',//hidden, select, radio, checkbox, textarea
                'name' => 'alias',
                'options' => [
                    //'label' => 'FILD_ALIAS_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'ALIAS'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'alias',
                    //'class' =>'form-control',
                    //'title' => 'FILD_ALIAS_DESC',
                    //'placeholder' => 'FILD_ALIAS_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna tabela ##############################################:
        $this->add([
                'type' => 'select',//hidden, select, radio, checkbox, textarea
                'name' => 'tabela',
                'options' => [
                    'label' => 'FILD_TABELA_LABEL',
                    'value_options'      =>$this->getTableName(),
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'TABELA'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'tabela',
                    'class' =>'form-control',
                    'title' => 'FILD_TABELA_DESC',
                    'placeholder' => 'FILD_TABELA_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        //############################################ informações da coluna icone ##############################################:
        $this->add([
                'type' => 'text',//hidden, select, radio, checkbox, textarea
                'name' => 'icone',
                'options' => [
                    'label' => 'FILD_ICONE_LABEL',
                    //'value_options'      =>[],
                    //'disable_inarray_validator' => true,
                    //'label_attributes'=>['class'=>'control-label','for'=>'ICONE'],
                    //'add-on-append'=>'aws-font'
                ],
                'attributes' => [
                    'id'=>'icone',
                    'class' =>'form-control',
                    'title' => 'FILD_ICONE_DESC',
                    'placeholder' => 'FILD_ICONE_PLACEHOLDER',
                    'data-access' => '3',
                    'data-position' => 'geral',
                    //'readonly' => true/false,
                    //'requerid' => true/false,
                ],
            ]
        );


        $this->setDescription([]);
        $this->setAccess([]);
        $this->setState([]);
        $this->setCreated([]);
        $this->setModified(["type" => "hidden"]);
        $this->setCsrf([]);
        $this->setSave([]);
        $this->setSaveCopy([]);

    }


}

