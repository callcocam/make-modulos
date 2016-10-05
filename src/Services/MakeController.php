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

class MakeController extends Options{



    public function __construct($data, ContainerInterface $container) {
         $this->container=$container;
        $this->setConfig();
        extract($data);
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("Controller");
        // E tanto o o nome do arquivo como o nome da class
        $this->setName($arquivo);
        // ex:Form, Entity, Service
        $this->setSubDir(sprintf("Controller"));
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array(DIRECTORY_SEPARATOR, $parent, 'Controller');
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");
        // Base dir geralmente e ./module/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace(sprintf("%s\\Controller", $parent));
        // Se e uma extenção de outra classe set setExtends
        $this->setExtends("AbstractController");
        // set os use
        $this->setUses(array('Base\Controller\AbstractController' => null,
            'Interop\Container\ContainerInterface' => null,
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Controller');
        // gera os methods podemos erar mais de um repetindo o codigo

        $this->setBody('$this->containerInterface=$containerInterface;');
        $this->setBody(sprintf('$this->route="%s";',strtolower($route)));
        $this->setBody(sprintf('$this->controller="%s";',strtolower($arquivo)));

        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = array('name' => "__construct",
            'parameter' => array(array('name' => "containerInterface", 'type' => 'ContainerInterface', 'value' => false)),
            'shortDescription' => '@param ContainerInterface $containerInterface',
            'longDescription' => sprintf('@return \Ecommerce\Controller\%sController',$arquivo),
            'datatype' => 'Controller',
            'body' => sprintf(implode(PHP_EOL, $this->getBody()), $arquivo));

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
    }


} 