<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 13:43
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;

class Repository extends Options {


    public function __construct($data, ContainerInterface $container) {
        $ds = DIRECTORY_SEPARATOR;

        $this->container=$container;
        $this->setConfig();
        extract($data);
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("Repository");
        // E tanto o o nome do arquivo como o nome da class
        $this->setName($arquivo);
        // ex:Form, Entity, Service
        $this->setSubDir(sprintf("Model{$ds}%s",$arquivo));
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array(DIRECTORY_SEPARATOR, $parent, 'Model');
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");
        // Base dir geralmente e ./module/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace(sprintf("%s\\Model\\%s", $parent,$arquivo));
        // Se e uma extenção de outra classe set setExtends
        $this->setExtends("AbstractRepository");
        // set os use
        $this->setUses(array('Zend\Db\TableGateway\TableGateway' => null,
            'Base\Model\AbstractRepository' => null
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Factory Repository');
        // gera os methods podemos erar mais de um repetindo o codigo
         $this->setBody('$this->tableGateway=$tableGateway;');

        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = array('name' => "__construct",
            'parameter' => array(array('name' => "tableGateway", 'type' => 'TableGateway', 'value' => false)),
            'shortDescription' => "__construct Factory Model",
            'longDescription' => null,
            'datatype' => '__construct',
            'body' => sprintf(implode(PHP_EOL, $this->getBody()), $arquivo));

        $methodConstruct = new Methods($methodOption);
        $this->setMethod($methodConstruct);
        $this->setBody("limpa");

        $class->setName($this->getName())->setImplementedInterfaces($this->getImplements())
            ->setNamespaceName($this->getNameSpace())
            ->setExtendedClass($this->getExtends())
            ->setDocblock($this->getDocblock())
            ->addProperties($this->getProperties())
            ->addConstants($this->getConstants())
            ->addMethods($this->getMethod());
        $this->setGenerateClasse($class);
    }

} 