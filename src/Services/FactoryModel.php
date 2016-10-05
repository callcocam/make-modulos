<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 11:37
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;

class FactoryModel extends Options {
    public function __construct($data, ContainerInterface $container) {
        $ds = DIRECTORY_SEPARATOR;
        $this->container=$container;
        $this->setConfig();
        extract($data);
        $this->setTable(strtolower($tabela));
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("Factory");
        // E tanto o o nome do arquivo como o nome da class
        $this->setName($arquivo);
        // ex:Form, Entity, Service
        $this->setSubDir(sprintf("Model{$ds}%s{$ds}Factory",$arquivo));
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array(DIRECTORY_SEPARATOR, $parent, 'Model');
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");
        // Base dir geralmente e ./module/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace(sprintf("%s\\Model\\%s\\Factory", $parent,$arquivo));
        // Se e uma extenção de outra classe set setExtends
          // set os use
        $this->setUses(array(
            'Interop\Container\ContainerInterface' => null,
            'Zend\ServiceManager\Factory\FactoryInterface' => null,
            sprintf('%s\Model\%s\%s',$parent,$arquivo,$arquivo)=> null
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setImplements(array('FactoryInterface'));
        $this->setBody('// Configurações iniciais do Factory Model');
        // gera os methods podemos erar mais de um repetindo o codigo
        $this->setBody(sprintf('return new %s();',$arquivo));
        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = ['name' => "__invoke",
            'parameter' => [
                ['name' => "container", 'type' => 'ContainerInterface', 'value' => false],
                ['name' => "requestedName", 'type' => null, 'value' => false],
                ['name' => "options", 'type' => 'array', 'value' => null]
            ],
            'shortDescription' => "__invoke Factory Model",
            'longDescription' => null,
            'datatype' => '__invoke',
            'body' => sprintf(implode(PHP_EOL, $this->getBody()), $arquivo)
        ];

        $methodConstruct = new Methods($methodOption);
        $this->setMethod($methodConstruct);
        $this->setBody("limpa");

        $class->setName($this->getName())
            ->setNamespaceName($this->getNameSpace())
            ->setImplementedInterfaces($this->getImplements())
            ->setDocblock($this->getDocblock())
            ->addProperties($this->getProperties())
            ->addConstants($this->getConstants())
            ->addMethods($this->getMethod());
        $this->setGenerateClasse($class);
    }
} 