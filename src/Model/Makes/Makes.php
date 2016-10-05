<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Model\Makes;

use Base\Model\AbstractModel;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class Makes extends AbstractModel
{

    protected $title = null;

    protected $grupo = null;

    protected $parent = 'Admin';

    protected $arquivo = null;

    protected $route = 'admin';

    protected $controller = 'admin';

    protected $action = 'index';

    protected $privilege = 'index';

    protected $alias = null;

    protected $tabela = null;

    protected $icone = null;

    /**
     * get title
     *
     * @return varchar
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * get parent
     *
     * @return varchar
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * get arquivo
     *
     * @return varchar
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * get route
     *
     * @return varchar
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * get controller
     *
     * @return varchar
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * get action
     *
     * @return varchar
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * get privilege
     *
     * @return varchar
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * get alias
     *
     * @return varchar
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * get tabela
     *
     * @return varchar
     */
    public function getTabela()
    {
        return $this->tabela;
    }

    /**
     * get icone
     *
     * @return varchar
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * set title
     *
     * @return varchar
     */
    public function setTitle($title = null)
    {
        $this->title=$title;
        return $this;
    }

    /**
     * @param null $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * set parent
     *
     * @return varchar
     */
    public function setParent($parent = 'Admin')
    {
        $this->parent=$parent;
        return $this;
    }

    /**
     * set arquivo
     *
     * @return varchar
     */
    public function setArquivo($arquivo = null)
    {
        $this->arquivo=$arquivo;
        return $this;
    }

    /**
     * set route
     *
     * @return varchar
     */
    public function setRoute($route = 'admin')
    {
        $this->route=$route;
        return $this;
    }

    /**
     * set controller
     *
     * @return varchar
     */
    public function setController($controller = 'admin')
    {
        $this->controller=$controller;
        return $this;
    }

    /**
     * set action
     *
     * @return varchar
     */
    public function setAction($action = 'index')
    {
        $this->action=$action;
        return $this;
    }

    /**
     * set privilege
     *
     * @return varchar
     */
    public function setPrivilege($privilege = 'index')
    {
        $this->privilege=$privilege;
        return $this;
    }

    /**
     * set alias
     *
     * @return varchar
     */
    public function setAlias($alias = null)
    {
        $this->alias=$alias;
        return $this;
    }

    /**
     * set tabela
     *
     * @return varchar
     */
    public function setTabela($tabela = null)
    {
        $this->tabela=$tabela;
        return $this;
    }

    /**
     * set icone
     *
     * @return varchar
     */
    public function setIcone($icone = null)
    {
        $this->icone=$icone;
        return $this;
    }


}

