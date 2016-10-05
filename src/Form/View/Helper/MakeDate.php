<?php
/**
 * Created by PhpStorm.
 * User: Claudio
 * Date: 28/09/2016
 * Time: 23:47
 */

namespace Make\Form\View\Helper;


use  Zend\Form\View\Helper\Form;

class MakeDate extends Form
{

    protected $label;
    protected $fild;
    protected $partial=" %s%s%s";

    public function __construct($element, $labelBox, $rowBox, $sFormLayout, $key)
    {

        var_dump($element);
        $row = sprintf($this->partial, $labelBox, $rowBox, $this->view->TwbformElementErrors($element));
        $this->layout[$key] = sprintf($sFormLayout, $row, $key);
        $element->setOption('add-on-append', $this->view->glyphicon('calendar'));
        $this->label = $this->view->translate($element->getLabel());
        $this->fild = $this->view->TwbformElement($element);
    }

    /**
     * @return mixed
     */
    public function getFild()
    {
        return $this->fild;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }
}