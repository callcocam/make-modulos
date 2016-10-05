<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 14:29
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;

class Filter extends Options {

    protected $images = array('1'=>'images');
    public function __construct($data, ContainerInterface $container) {
        $this->container=$container;
        $this->setConfig();
        extract($data);
        $this->setTable(strtolower($tabela));
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("Filter");
        // E tanto o o nome do arquivo como o nome da class
        $this->setName($arquivo);
        // ex:Form, Entity, Service
        $this->setSubDir("Form");
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array(DIRECTORY_SEPARATOR, $parent, 'Form');
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");
        // Base dir geralmente e ./module/Modulo/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace(sprintf("%s\\Form", $parent));
        // Se e uma extenção de outra classe set setExtends
        $this->setExtends("AbstractFilter");
        // set os use
        $this->setUses(array(
            'Base\Form\AbstractFilter' => null,
            'Interop\Container\ContainerInterface' => null,
            'Zend\Db\Adapter\AdapterInterface' => null,
            'Zend\Filter\StringTrim' => null,
            'Zend\Filter\StripTags' => null,
            'Zend\Validator\NotEmpty' => null,
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Form');
        $this->setBody('parent::__construct($containerInterface);');
        $this->setBody('$this->setId([]);');
        $this->setBody('$this->setAssetid([]);');
        $this->setBody('$this->setCodigo([]);');
        $this->setBody('$this->setEmpresa([]);');
        // gera os methods podemos erar mais de um repetindo o codigo
        if ($this->getTable()->getColumns()):
            foreach ($this->getTable()->getColumns() as $value):
                extract($value);
                if (!array_search($name, self::$ignore)):
                    $this->setBody($this->addElement($value));
                endif;
            endforeach;
        endif;
        if($this->images){
            $this->setBody('$this->setAtachament([]);');
        }
        $this->setBody('$this->setDescription([]);');
        $this->setBody('$this->setAccess([]);');
        $this->setBody('$this->setState([]);');
        $this->setBody('$this->setModified([]);');
        $this->setBody('$this->setCreated([]);');

        $datatype[]=' \Auth\Form\PrivilegesFilter';
        $datatype[]='@param ContainerInterface $containerInterface';

        $methodOption = array('name' => "__construct",
            'parameter' => array(
                array('name' => "containerInterface", 'type' => 'ContainerInterface', 'value' => false),
            ),
            'shortDescription' => "construct do Table",
            'longDescription' => null,
            'datatype' =>implode(PHP_EOL,$datatype),
            'body' => implode(PHP_EOL, $this->getBody()));
        $methodConstruct = new Methods($methodOption);
        $this->setMethod($methodConstruct);
        $this->setBody("limpa");


        $class->setName($this->getName())
            ->setNamespaceName($this->getNameSpace())
            ->setExtendedClass($this->getExtends())
            ->setDocblock($this->getDocblock())
            ->addProperties($this->getProperties())
            ->addConstants($this->getConstants())
            ->addMethods($this->getMethod());
        $this->setGenerateClasse($class);
//$this->generateClass();
    }

    public function addElement($value) {
        extract($value);
        if(!array_search($name,self::$hidden) && !array_search($name,$this->images)) {
            $body = <<<'EOT'
            //############################################ informações da coluna %s ##############################################:
             $this->add([
            'name' => '%s',
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
EOT;
        }
        else{
            $body = <<<'EOT'
            //############################################ informações da coluna %s ##############################################:
             $this->add([
            'name' => '%s',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [ ],
        ]);
EOT;
        }


        return sprintf($body, $name,$name) . PHP_EOL . PHP_EOL;
    }

}