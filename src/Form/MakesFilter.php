<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Form;

use Base\Form\AbstractFilter;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\NotEmpty;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class MakesFilter extends AbstractFilter
{

    /**
     * construct do Table
     *
     * @return \Make\Form\MakesFilter
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        // Configurações iniciais do Form
        parent::__construct($containerInterface);
        $this->setId([]);
        $this->setAssetid([]);
        $this->setCodigo([]);
        $this->setEmpresa([]);
        //############################################ informações da coluna title ##############################################:
        $this->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                    ],
                ],
            ],
        ]);

        //############################################ informações da coluna grupo ##############################################:
        $this->add([
            'name' => 'grupo',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                    ],
                ],
            ],
        ]);


        //############################################ informações da coluna parent ##############################################:
        $this->add([
            'name' => 'parent',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                    ],
                ],
            ],
        ]);


        //############################################ informações da coluna arquivo ##############################################:
        $this->add([
            'name' => 'arquivo',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                    ],
                ],
            ],
        ]);


        //############################################ informações da coluna route ##############################################:
        $this->add([
            'name' => 'route',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                'name' => NotEmpty::class,
                'options' => [
                    'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                ],
            ],
            ],
        ]);


        //############################################ informações da coluna controller ##############################################:
        $this->add([
            'name' => 'controller',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [],
        ]);


        //############################################ informações da coluna action ##############################################:
        $this->add([
            'name' => 'action',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [],
        ]);


        //############################################ informações da coluna privilege ##############################################:
        $this->add([
            'name' => 'privilege',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [],
        ]);


        //############################################ informações da coluna alias ##############################################:
        $this->add([
            'name' => 'alias',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [],
        ]);


        //############################################ informações da coluna tabela ##############################################:
        $this->add([
            'name' => 'tabela',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => "Campo Obrigatorio"]
                    ],
                ],
            ],
        ]);


        //############################################ informações da coluna icone ##############################################:
        $this->add([
            'name' => 'icone',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [],
        ]);


        $this->setDescription([]);
        $this->setAccess([]);
        $this->setState([]);
        $this->setModified([]);
        $this->setCreated([]);
    }


}

