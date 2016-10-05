<?php
/**
 * @license © 2005 - 2016 by Zend Technologies Ltd. All rights reserved.
 */


namespace Make\Model\Modules;

use Base\Model\AbstractModel;

/**
 * SIGA-Smart
 *
 * Esta class foi gerada via Zend\Code\Generator.
 */
class Modules extends AbstractModel
{

    protected $title = null;

    protected $icone = 'plus-sign';

    protected $url = '#';

    protected $alias = 'Admin';

    protected $ordering = '00001';

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
     * get icone
     *
     * @return varchar
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * get url
     *
     * @return varchar
     */
    public function getUrl()
    {
        return $this->url;
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
     * get ordering
     *
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
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
     * set icone
     *
     * @return varchar
     */
    public function setIcone($icone = 'plus-sign')
    {
        $this->icone=$icone;
        return $this;
    }

    /**
     * set url
     *
     * @return varchar
     */
    public function setUrl($url = '#')
    {
        $this->url=$url;
        return $this;
    }

    /**
     * set alias
     *
     * @return varchar
     */
    public function setAlias($alias = 'Admin')
    {
        $this->alias=$alias;
        return $this;
    }

    /**
     * set ordering
     *
     * @return int
     */
    public function setOrdering($ordering = '00001')
    {
        $this->ordering=$ordering;
        return $this;
    }


}

