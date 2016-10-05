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
use Zend\Code\Generator\MethodGenerator;

class Model extends Options {
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
        $this->data = $data;
        $this->container = $container;
        $this->setConfig();
        extract($data);
        $this->setTable(strtolower($tabela));
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("");
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
        $this->setExtends("AbstractModel");
        // set os use
        $this->setUses(array('Base\Model\AbstractModel' => null));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->addMethods($tabela);
        $this->gerarPropertys($tabela);
        $class->setName($this->getName())
            ->setNamespaceName($this->getNameSpace())
            ->setExtendedClass($this->getExtends())
            ->setDocblock($this->getDocblock())
            ->addProperties($this->getProperties())
            ->addConstants($this->getConstants())
            ->addMethods($this->getMethod());
        $this->setGenerateClasse($class);

    }

    public function gerarPropertys($tabela) {

        foreach ($this->getTable()->getColumns() as $value) {
            extract($value);
            if (!array_search($name, self::$ignore)):
                $this->setProperties(['name' => $name, 'value' => $columnDefault, 'flag' => 'FLAG_PROTECTED']);
            endif;
        }
    }

    public function addMethods($tabela) {
        $method = new MethodGenerator();
        $colunas = $this->getTable()->getColumns();
        foreach ($colunas as $value) {
            extract($value);
            if (!array_search($name, self::$ignore)):
                // gera os methods podemos erar mais de um repetindo o codigo
                $this->setBody(sprintf('return $this->%s;', $name));
                $method = array('name' => $name,
                    'parameter' => array(array('name' => null, 'type' => null, 'value' => $columnDefault)),
                    'shortDescription' => "get {$name}",
                    'longDescription' => null,
                    'datatype' => "{$dataType}",
                    'body' => implode(PHP_EOL, $this->getBody()));
                $methodSave = new Methods($method, TRUE, "get");
                $this->setBody("limpa");
                $this->setMethod($methodSave);

            endif;
        }

        foreach ($colunas as $value) {
            extract($value);
            if (!array_search($name, self::$ignore)):
                // gera os methods podemos erar mais de um repetindo o codigo
                $this->setBody(sprintf('$this->%s=$%s;', $name, $name));
                $this->setBody('return $this;');
                $method = array('name' => $name,
                    'parameter' => array(array('name' => $name, 'type' => null, 'value' => $columnDefault)),
                    'shortDescription' => "set {$name}",
                    'longDescription' => null,
                    'datatype' => "{$dataType}",
                    'body' => implode(PHP_EOL, $this->getBody()));
                $methodSave = new Methods($method, TRUE, "set");
                $this->setBody("limpa");
                $this->setMethod($methodSave);
            endif;
        }

    }
} 