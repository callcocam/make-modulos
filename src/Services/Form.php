<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 14:28
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\ClassGenerator;
use Zend\Debug\Debug;

class Form extends Options {


    protected $tabelaElements;
    protected $attr = array('id', 'title', 'requerid', 'valor_padrao', 'placeholder', 'readonly', 'class', 'style', 'multiple', 'rows', 'cols', 'min', 'max', 'step', 'data-access', 'data-position');
    protected $attrHidden = array('value');
    protected $images = array('1'=>'images');
    protected $exist_images=false;
    protected $controller = array('1'=>'state','2'=>'access','3'=>'created','4'=>'modified');

    public function __construct($data, ContainerInterface $container) {

        $this->container=$container;
        $this->setConfig();
        extract($data);
        $this->setTable(strtolower($tabela));
        // Poxfix e o que completa o nome do arquivo ArquivoPosfix (ArquivoForm)
        $this->setPosfix("Form");
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
        $this->setExtends("AbstractForm");
        // set os use
        $this->setUses(array('Base\Form\AbstractForm' => null, 'Interop\Container\ContainerInterface' => null, sprintf('%s\Form\%sFilter',$parent,$arquivo) => null));
        $class = new ClassGenerator();
        if ($this->getUses()) {
            foreach ($this->getUses() as $key => $value) {
                $class->addUse($key, $value);
            }
        }
        $this->setBody('// Configurações iniciais do Form;');
        $this->setBody('parent::__construct($containerInterface, $name, $options);');
        $this->setBody('$this->setAttribute("id","Manager");');
        $setInputFilter=sprintf('$this->setInputFilter($containerInterface->get(%sFilter::class));',$arquivo);
        $this->setBody($setInputFilter);
        $this->setBody('$this->setId([]);');
        $this->setBody('$this->setAssetid([]);');
        $this->setBody('$this->setCodigo([]);');
        $this->setBody('$this->setEmpresa([]);');
        // gera os methods podemos erar mais de um repetindo o codigo
        if ($this->getTable()->getColumns()):
            foreach ($this->getTable()->getColumns() as $value):
                extract($value);
                if (!array_search($name, self::$ignore)):
                    if(!array_search($name,self::$hidden)) {
                        if(!array_search($name,$this->images)) {
                            $this->setBody($this->addElement($value));
                        }
                        else{
                            $this->exist_images=true;
                        }

                    }
                endif;
            endforeach;
        endif;
        if($this->exist_images){
            $this->setBody('$this->setAtachament([]);');
        }
        $this->setBody('$this->setDescription([]);');
        $this->setBody('$this->setAccess([]);');
        $this->setBody('$this->setState([]);');
        $this->setBody('$this->setCreated([]);');
        $this->setBody('$this->setModified([]);');
        //$this->setBody('$this->setModified(["type" => "hidden"]);');
        $this->setBody('$this->setCsrf([]);');
        $this->setBody('$this->setSave([]);');
        //$this->setBody('$this->getAuthservice();');

        $datatype[]= sprintf(' \%s\Form\%sForm',$parent,$arquivo);
        $datatype[]= '@param ContainerInterface $containerInterface';
        $datatype[]= '@param string $name';
        $datatype[]= '@param array $options';


        $methodOption = array('name' => "__construct",
            'parameter' => array(
                array('name' => "containerInterface", 'type' => 'ContainerInterface', 'value' => false),
                array('name' => "name", 'type' => null, 'value' => $arquivo),
                array('name' => "options", 'type' => 'array', 'value' => []),
            ),
            'shortDescription' => "construct do Table",
            'longDescription' => null,
            'datatype' => implode(PHP_EOL,$datatype),
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
        $element['data-access'] = "3";
        $element['data-position'] = "geral";
        $options = $this->setOptions($value);
        $attributes = $this->setAttr($value);
        $type="text";
        if(array_search($name,self::$hidden)) {
            $type="hidden";
        }
        $body = <<<'EOT'
            //############################################ informações da coluna %s ##############################################:
		    $this->add([
	                   'type' => '%s',//text,hidden, select, radio, checkbox, textarea
	                    'name' => '%s',
	                    'options' => %s,
	                    'attributes' => %s,
	               ]
	            );
EOT;

        return sprintf($body, $name,$type, $name, $options, $attributes) . PHP_EOL . PHP_EOL;
    }

    public function setAttr($value) {
        extract($value);
        if(array_search($name,$this->images)){
            $this->exist_images=true;
            return "";
        }
        $title=strtoupper($name);
        $attributes[] = "[";
        $attributes[] = "        'id'=>'{$name}',";
        if(!array_search($name,self::$hidden)) {

            $attributes[] = "        'class' =>'form-control',";
            $attributes[] = "        'title' => 'FILD_{$title}_DESC',";
            $attributes[] = "        'placeholder' => 'FILD_{$title}_PLACEHOLDER',";
            $attributes[] = "        //'readonly' => true/false,";
            $attributes[] = "        //'requerid' => true/false,";
        }
        $attributes[] = "        'data-access' => '3',";
        $position="geral";
        if(array_search($name,$this->controller)){
            $position="datas";
        }



        $attributes[] = "        'data-position' => '{$position}',";

        $attributes[] = "    	        	        ]";
        return implode(PHP_EOL, $attributes);
    }
    public function setOptions($value) {
        extract($value);
        $label=strtoupper($name);
        $title=strtoupper($name);
        $options[] = "[";
        $options[] = "             	'label' => 'FILD_{$label}_LABEL',";
        $options[] = "            	//'value_options'      =>[],";
        $options[] = "				//'disable_inarray_validator' => true,";
        $options[] = "				//'label_attributes'=>['class'=>'control-label','for'=>'{$title}'],";
        $options[] = "				//'add-on-append'=>'aws-font'";
        $options[] = " ]";
        return implode(PHP_EOL, $options);
    }
}