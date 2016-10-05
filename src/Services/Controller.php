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

class Controller extends Options{



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
            sprintf('%s\Form\%sFilter', $parent, $arquivo) => null,//Vendas\Form\VendasFilter
            sprintf('%s\Form\%sForm', $parent, $arquivo) => null,//Vendas\Form\VendasForm
            sprintf('%s\Model\%s\%s', $parent, $arquivo,$arquivo) => null,//Vendas\Model\Vendas\Vendas
            sprintf('%s\Model\%s\%sRepository', $parent, $arquivo,$arquivo) => null,//Vendas\Model\Vendas\VendasRepository
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
        $this->setBody(sprintf('$this->table=%sRepository::class;',$arquivo));
        $this->setBody(sprintf('$this->model=%s::class;',$arquivo));
        $this->setBody(sprintf('$this->form=%sForm::class;',$arquivo));
        $this->setBody(sprintf('$this->filter=%sFilter::class;',$arquivo));
        $this->setBody(sprintf('$this->route="%s";',strtolower($route)));
        $this->setBody(sprintf('$this->controller="%s";',strtolower($arquivo)));

        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = array('name' => "__construct",
            'parameter' => array(array('name' => "containerInterface", 'type' => 'ContainerInterface', 'value' => false)),
            'shortDescription' => "__construct Factory Model",
            'longDescription' => null,
            'datatype' => '__construct',
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