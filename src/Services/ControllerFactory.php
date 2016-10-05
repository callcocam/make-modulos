<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 13:52
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;

class ControllerFactory extends Options{



    public function __construct($data, ContainerInterface $container) {
        $ds = DIRECTORY_SEPARATOR;
        $this->container=$container;
        $this->setConfig();
        extract($data);
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("ControllerFactory");
        // E tanto o o nome do arquivo como o nome da class
        $this->setName($arquivo);
        // ex:Form, Entity, Service
        $this->setSubDir(sprintf("Controller{$ds}Factory"));
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array(DIRECTORY_SEPARATOR, $parent, 'Controller');
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");
        // Base dir geralmente e ./module/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace(sprintf("%s\\Controller\\Factory", $parent));

        $this->setImplements(array('FactoryInterface'));

         // set os use
        $this->setUses(array(
            'Zend\ServiceManager\Factory\FactoryInterface' => null,
            'Interop\Container\ContainerInterface' => null,
             sprintf('%s\Controller\%sController', $parent, $arquivo) => null,
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Factory Controller');
        // gera os methods podemos erar mais de um repetindo o codigo

       $this->setBody(sprintf('return new %sController($container);',$arquivo));

        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = ['name' => "__invoke",
            'parameter' => [
                ['name' => "container", 'type' => 'ContainerInterface', 'value' => false],
                ['name' => "requestedName", 'type' => null, 'value' => false],
                ['name' => "options", 'type' => 'array', 'value' => null]
            ],
            'shortDescription' => "__invoke Factory Controller",
            'longDescription' => null,
            'datatype' => '__invoke',
            'body' => sprintf(implode(PHP_EOL, $this->getBody()), $arquivo)
        ];

        $methodConstruct = new Methods($methodOption);
        $this->setMethod($methodConstruct);
        $this->setBody("limpa");

        $class->setName($this->getName())
            ->setNamespaceName($this->getNameSpace())
            ->setExtendedClass($this->getExtends())
            ->setImplementedInterfaces($this->getImplements())
            ->setDocblock($this->getDocblock())
            ->addProperties($this->getProperties())
            ->addConstants($this->getConstants())
            ->addMethods($this->getMethod());
        $this->setGenerateClasse($class);
    }


} 