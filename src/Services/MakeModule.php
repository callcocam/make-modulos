<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:19
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;

class MakeModule extends Options {
    /**
     * @var
     */
    private $data;


    /**
     * @param $data
     * @param ContainerInterface $container
     */
    public function __construct($data, ContainerInterface $container){
        $ds = DIRECTORY_SEPARATOR;
        $this->container = $container;
        $this->setConfig();
        $alias=$data['alias'];
        // E tanto o o nome do arquivo como o nome da class
        $this->setName("Module");
        // ex:Form, Entity, Service
        $this->setSubDir('');
        // Montar o caminho base
        $aFind = array('DS', 'dirBase', 'dirEntity');
        $aSub = array($ds,$alias,"src");
        $dirBase = str_replace($aFind, $aSub, ".DS{$this->config->module}DSdirBaseDSsrc");

        // Base dir geralmente e ./module/src/Modulo
        $this->setBaseDir($dirBase);
        // Name Space ex:Modulo\Form
        $this->setNameSpace($alias);

        // Se e uma extenção de outra classe set setExtends
        $this->setImplements(array('ConfigProviderInterface'));
        // set os use
        $this->setUses(array(
            'Zend\ModuleManager\Feature\ConfigProviderInterface' => null
        ));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Factory Table');
        $this->setBody("return include __DIR__.'/../config/module.config.php';");
        // gera os methods podemos erar mais de um repetindo o codigo

        // gera os methods podemos erar mais de um repetindo o codigo
        $methodOption = ['name' => "getConfig",
            'parameter' => null,
            'shortDescription' => "getConfig",
            'longDescription' => 'Returns configuration to merge with application configuration',
            'datatype' => 'array',
            'body' => implode(PHP_EOL, $this->getBody())
        ];

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