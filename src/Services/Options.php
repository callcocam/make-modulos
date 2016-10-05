<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:12
 */

namespace Make\Services;


use Make\Model\Table;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Debug\Debug;


class Options {



    public static $ignore = [
        1 => 'id',
        2 => 'codigo',
        3 => 'asset_id',
        4 => 'empresa',
        5 => 'description',
        6 => 'state',
        7 => 'access',
        8 => 'created',
        9 => 'modified'];

    public static $hidden = [
        1 => 'id',
        2 => 'codigo',
        3 => 'asset_id',
        4 => 'empresa',
        5 => 'controller',
        6 => 'route',
        7 => 'action',
        8 => 'url',
        9 => 'usr_registration_token',
        10 => 'modified'];
    protected $name;
    protected $nameSpace;
    protected $baseDir = './module';
    protected $subDir;
    protected $moduleInfo;
    protected $generateClasse;
    protected $extends;
    protected $implements = array();
    protected $method = array();
    protected $parameter;
    protected $docblock = null;
    protected $properties = array();
    protected $constants = array();
    protected $body = array();
    protected $uses = array();
    protected $posfix;
    protected $prefix;
    protected $user;
    protected $table;
    protected $container;
    protected $resutl;
    protected $servileLocator;
    protected $config;

    public function setConfig()
    {
        $this->config=$this->container->get('ZfConfig');
    }
    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getNameSpace() {
        return $this->nameSpace;
    }

    /**
     * @return string
     */
    public function getBaseDir() {
        return $this->baseDir;
    }

    /**
     * @return mixed
     */
    public function getSubDir() {
        return $this->subDir;
    }

    /**
     * @return mixed
     */
    public function getModuleInfo() {
        return $this->moduleInfo;
    }

    /**
     * @return mixed
     */
    public function getGenerateClasse() {
        return $this->generateClasse;
    }

    /**
     * @return mixed
     */
    public function getExtends() {
        return $this->extends;
    }

    /**
     * @return array
     */
    public function getImplements() {
        return $this->implements;
    }

    /**
     * @return array
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getParameter() {
        return $this->parameter;
    }

    /**
     * @return null
     */
    public function getDocblock() {
        if (is_null($this->docblock)) {
            $this->setDocblock();
        }
        return $this->docblock;
    }

    /**
     * @return array
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * @return array
     */
    public function getConstants() {
        return $this->constants;
    }

    /**
     * @return array
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getUses() {
        return $this->uses;
    }

    /**
     * @return mixed
     */
    public function getPosfix() {
        return $this->posfix;
    }

    /**
     * @return mixed
     */
    public function getPrefix() {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getTable() {
        return $this->table;
    }


    /**
     * @param $name
     */
    public function setName($name) {
        //$var = strtolower(utf8_encode($name));
        $var = ucwords(str_replace("_", " ", $name));
        $name = preg_replace('{\W}', '', preg_replace('{ +}', '', strtr(
            utf8_decode(html_entity_decode($var)), utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'), 'AAAAEEIOOOUUCNaaaaeeiooouucn')));
        $this->name = sprintf("%s%s%s", $this->getPrefix(), $name, $this->getPosfix());
    }

    /**
     * @param $nameSpace
     */
    public function setNameSpace($nameSpace) {
        $this->nameSpace = $nameSpace;
    }

    /**
     * @param $baseDir
     */
    public function setBaseDir($baseDir) {
        $this->baseDir = $baseDir;
    }

    /**
     * @param $subDir
     */
    public function setSubDir($subDir) {
        $this->subDir = $subDir;
    }

    /**
     * @param $moduleInfo
     */
    public function setModuleInfo($moduleInfo) {
        $this->moduleInfo = $moduleInfo;
    }

    /**
     * @param ClassGenerator $generateClasse
     */
    public function setGenerateClasse(ClassGenerator $generateClasse) {
        $this->generateClasse = $generateClasse;
    }

    /**
     * @param $extends
     */
    public function setExtends($extends) {
        $this->extends = $extends;
    }

    /**
     * @param $implements
     */
    public function setImplements($implements) {
        $this->implements = $implements;
    }

    /**
     * @param Methods $method
     * @return $this
     */
    public function setMethod(Methods $method) {
        extract($method->toArray());
         // Configuring after instantiation
        $this->method[] = new MethodGenerator(
            $name, $parameter, MethodGenerator::FLAG_PUBLIC, $body, DocBlockGenerator::fromArray(array(
                'shortDescription' => $short_description,
                'longDescription' => $long_description,
                'tags' => array(
                    new Tag\ReturnTag(array(
                        'datatype' => $datatype,
                    )),
                ),
            ))
        );
        return $this;
    }

    /**
     * @param $parameter
     */
    public function setParameter($parameter) {
        $this->parameter = $parameter;
    }

    /**
     *
     * @param array $docblock
     * @return $this
     */
    public function setDocblock(array $docblock = array('shortDescription' => 'SIGA-Smart', 'longDescription' => 'Esta class foi gerada via Zend\Code\Generator.')) {
        //$shortDescription = 'Sample generated class', $longDescription = 'This is a class generated with Zend\Code\Generator.') {
        extract($docblock);
        $this->docblock = DocBlockGenerator::fromArray(array(
            'shortDescription' => $shortDescription,
            'longDescription' => $longDescription,
            'tags' => array(
                        ),
        ));
        return $this;
    }

    /**
     * @param $properties
     */
    public function setProperties($properties) {
        extract($properties);
        $flagArray = array('FLAG_PUBLIC' => PropertyGenerator::FLAG_PUBLIC, 'FLAG_PROTECTED' => PropertyGenerator::FLAG_PROTECTED, 'FLAG_PRIVATE' => PropertyGenerator::FLAG_PRIVATE);
        $this->properties[] = array($name, $value, $flagArray[$flag]);
    }

    /**
     * @param $constants
     */
    public function setConstants($constants) {
        $this->constants = $constants;
    }

    /**
     * @param $body
     */
    public function setBody($body) {
        if ($body === 'limpa') {
            unset($this->body);
        } else {
            $this->body[] = $body;
        }
    }

    /**
     * @param $uses
     */
    public function setUses($uses) {
        $this->uses = $uses;
    }

    /**
     * @param $posfix
     */
    public function setPosfix($posfix) {
        $this->posfix = $posfix;
    }

    /**
     * @param $prefix
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    /**
     * @param $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @param $tabela
     * @return $this
     */
    public function setTable($tabela) {
        $table = $this->container->get(Table::class);
        $table->setColumns($tabela);
        $this->table = $table;
        return $this;
    }


    /**
     * @param array $options
     * @return string
     */
    public function generateClass(array $options = array('body' => null, 'shortDescription' => null, 'longDescription' => null)) {
        extract($options);
        $fileGenerate = FileGenerator::fromArray(array(
            'classes' => array($this->getGenerateClasse()),
            'docblock' => DocBlockGenerator::fromArray(array(
                'shortDescription' => $shortDescription,
                'longDescription' => $longDescription,
                'tags' => array(
                    array(
                        'name' => 'license',
                        'description' => '© 2005 - 2016 by Zend Technologies Ltd. All rights reserved.',
                    ),
                ),
            )),
            'body' => $body,
        ));
        $ds = DIRECTORY_SEPARATOR;
        $fileName = sprintf("%s{$ds}%s{$ds}%s.php", $this->getBaseDir(), $this->getSubDir(), $this->getName());
       // Debug::dump($fileName);
        $fileGenerate->setFilename($fileName)->write();
        return $fileGenerate->generate();


    }

    /**
     * @param array $options
     * @return string
     */
    public function generateFile(array $options = array('caminho'=>'teste.txt','description' => null, 'shortDescription' => null, 'longDescription' => null)) {
        extract($options);
        $fileGenerate = new FileGenerator();
        $fileGenerate->setFilename($caminho)->setBody(trim($description))->write();
        return $fileGenerate->generate();
    }
} 