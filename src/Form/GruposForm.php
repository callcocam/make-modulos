<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Form;

use Base\Form\AbstractForm;
use Interop\Container\ContainerInterface;
use Make\Form\GruposFilter;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class GruposForm extends AbstractForm
{

    /**
     * construct do Table
     *
     * @return  \Make\Form\GruposForm
     * @param ContainerInterface $containerInterface
     * @param string $name
     * @param array $options
     */
    public function __construct(ContainerInterface $containerInterface, $name = 'Grupos', array $options = array())
    {
        // Configurações iniciais do Form;
        parent::__construct($containerInterface, $name, $options);
        $this->setAttribute("id","Manager");
        $this->setInputFilter($containerInterface->get(GruposFilter::class));
        $this->setId([]);
        $this->setAssetid([]);
        $this->setCodigo([]);
        $this->setEmpresa([]);
                    //############################################ informações da coluna title ##############################################:
        		    $this->add([
        	                   'type' => 'text',//text,hidden, select, radio, checkbox, textarea
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
                //'readonly' => true/false,
                //'requerid' => true/false,
                'data-access' => '3',
                'data-position' => 'geral',
            	        	        ],
        	               ]
        	            );
        
        
                    //############################################ informações da coluna icone ##############################################:
        		    $this->add([
        	                   'type' => 'text',//text,hidden, select, radio, checkbox, textarea
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
                //'readonly' => true/false,
                //'requerid' => true/false,
                'data-access' => '3',
                'data-position' => 'geral',
            	        	        ],
        	               ]
        	            );
        
        
                    //############################################ informações da coluna alias ##############################################:
        		    $this->add([
        	                   'type' => 'text',//text,hidden, select, radio, checkbox, textarea
        	                    'name' => 'alias',
        	                    'options' => [
                     	'label' => 'FILD_ALIAS_LABEL',
                    	//'value_options'      =>[],
        				//'disable_inarray_validator' => true,
        				//'label_attributes'=>['class'=>'control-label','for'=>'ALIAS'],
        				//'add-on-append'=>'aws-font'
         ],
        	                    'attributes' => [
                'id'=>'alias',
                'class' =>'form-control',
                'title' => 'FILD_ALIAS_DESC',
                'placeholder' => 'FILD_ALIAS_PLACEHOLDER',
                //'readonly' => true/false,
                //'requerid' => true/false,
                'data-access' => '3',
                'data-position' => 'geral',
            	        	        ],
        	               ]
        	            );
        
        
                    //############################################ informações da coluna ordering ##############################################:
        		    $this->add([
        	                   'type' => 'text',//text,hidden, select, radio, checkbox, textarea
        	                    'name' => 'ordering',
        	                    'options' => [
                     	'label' => 'FILD_ORDERING_LABEL',
                    	//'value_options'      =>[],
        				//'disable_inarray_validator' => true,
        				//'label_attributes'=>['class'=>'control-label','for'=>'ORDERING'],
        				//'add-on-append'=>'aws-font'
         ],
        	                    'attributes' => [
                'id'=>'ordering',
                'class' =>'form-control',
                'title' => 'FILD_ORDERING_DESC',
                'placeholder' => 'FILD_ORDERING_PLACEHOLDER',
                //'readonly' => true/false,
                //'requerid' => true/false,
                'data-access' => '3',
                'data-position' => 'geral',
            	        	        ],
        	               ]
        	            );
        
        
        $this->setDescription([]);
        $this->setAccess([]);
        $this->setState([]);
        $this->setCreated([]);
        $this->setModified([]);
        $this->setCsrf([]);
        $this->setSave([]);
    }


}

