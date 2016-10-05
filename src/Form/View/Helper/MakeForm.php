<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 18/08/2016
 * Time: 22:45
 */

namespace Make\Form\View\Helper;


use Base\Form\AbstractForm;
use Zend\Form\View\Helper\Form;


class MakeForm extends Form{

    /**
     * @var string
     */
    const LAYOUT_HORIZONTAL = 'horizontal';

    /**
     * @var string
     */
    const LAYOUT_INLINE = 'inline';

    /**
     * @var string
     */
    const LAYOUT_RADIO = 'radio';

    /**
     * @var string
     */
    const LAYOUT_DEFAULT = '';

    /**
     * @var string
     */
    private static $formRowFormat = ['inline'=>null,'horizontal'=>null];

    /**
     * Form layout (see LAYOUT_* consts)
     *
     * @var string
     */
    protected $formLayout = null;

    /**
     * Layout Html Do Form
     * @var array
     */
    protected $layout=[];
    /**
     * Carrega os Campos Da Tabela
     * @var array
     */
    protected $fields=[];
    /**
     * CArrega As Labes
     * @var array
     */
    protected $labes=[];
    /**
     * Monta O Bloco Geral
     * @var array
     */
    protected $geral=[];
    protected $datas=[];
    protected $controle=[];
    protected $btn=[];

    protected $label;
    protected $field;
    protected $partial="%s%s%s";

    /**
     * @see Form::__invoke()
     * @param AbstractForm $oForm
     * @param string $sFormLayout
     * @return TwbBundleForm|string
     */
    public function gerar(AbstractForm $oForm = null, $sFormLayout = self::LAYOUT_HORIZONTAL)
    {


        self::$formRowFormat[self::LAYOUT_INLINE]=$this->view->Html('div','%s',['class'=>'row']);

        self::$formRowFormat[self::LAYOUT_HORIZONTAL]=$this->view->Html('div','%s',['class'=>'row']);

        self::$formRowFormat[self::LAYOUT_DEFAULT]=$this->view->Html('div','%s',['class'=>'form-group']);

        self::$formRowFormat[self::LAYOUT_RADIO]=$this->view->Html('div','%s');

        if ($oForm) {
            return $this->render($oForm, $sFormLayout);
        }
        $this->formLayout = $sFormLayout;
        return $this;
    }

    /**
     * Render a form from the provided $oForm,
     * @see Form::render()
     * @param AbstractForm $oForm
     * @param string $sFormLayout
     * @return string
     */
    public function render(AbstractForm $oForm= null, $sFormLayout = self::LAYOUT_DEFAULT)
    {


        //Prepare form if needed
        if (method_exists($oForm, 'prepare')) {
            $oForm->prepare();
        }
        $this->setFormClass($oForm, $sFormLayout);
        $oForm->setAttribute("id","Manager");
        $oForm->setAttribute("class","form floating-label form-validate");
        $oForm->setAttribute("accept-charset","utf-8");
        //Set form role
        if (!$oForm->getAttribute('role')) {
            $oForm->setAttribute('role', 'form');
        }
        if (!$oForm->getAttribute('action')) {
            $oForm->setAttribute('action', 'action-form-do-formulario');
        }
        $this->renderElements($oForm, $sFormLayout);
        return implode(PHP_EOL,$this->layout);
    }

    public function renderElements($oForm, $sFormLayout){
        foreach ($oForm as $key => $element):
            $visible = "";
            $access=1;
            $position=$oForm->get($key)->getAttribute('data-position');
            //verifica se o usuario pode ter acesso ao campo
            if ($element->hasAttribute('data-access')) {
                if(isset($this->view->user->role_id)){
                    $access=$this->view->user->role_id;
                }
                $visible = $access <= $element->getAttribute('data-access') ? "" : " disabled";
            }

            if($element->getAttribute('type')=="hidden"){
                $visible="disabled";
            }

            $this->partial=sprintf($this->view->partial('/make/partials/text'),"#{$key}#","{{{$key}}}");


            if ($element->hasAttribute('placeholder')) {
                //$element->setAttribute('placeholder', $this->view->translate($element->getAttribute('placeholder')));
                $element->removeAttribute('placeholder');
            }

            if ($element->hasAttribute('data-access')) {
                //$element->setAttribute('placeholder', $this->view->translate($element->getAttribute('placeholder')));
                $element->removeAttribute('data-access');
            }

            if ($element->hasAttribute('data-position')) {
                //$element->setAttribute('placeholder', $this->view->translate($element->getAttribute('placeholder')));
                $element->removeAttribute('data-position');
            }
            if(!empty($visible)){
                $this->layout[$key]="#$key#";
                $this->fields["#{$key}#"]=$this->view->formHidden($element);
            }
            elseif($element->getAttribute('type')=="button" || $element->getAttribute('type')=="submit"){
                $this->setButton($element);
                $this->layout[$key]=$this->getLabel();
                $this->btn["#{$key}#"]=$this->getFild();
            }
            elseif($element->getAttribute('name')=="created" || $element->getAttribute('name')=="modified"){
                $this->partial=sprintf($this->view->partial('/make/partials/date'),"#{$key}#","{{{$key}}}",'%s');
                $this->setDate($element,self::$formRowFormat[$sFormLayout],$key);
                $this->labes["{{{$key}}}"]=$this->getLabel();
                $this->fields["#{$key}#"]=$this->getFild();
            }
            elseif($element->getAttribute('type')=="radio"){
                $this->partial=sprintf($this->view->partial('/make/partials/radio'),"#{$key}#","{{{$key}}}");
                $this->setRadio($element,self::$formRowFormat[self::LAYOUT_RADIO],$key);
                $this->labes["{{{$key}}}"]=$this->getLabel();
                $this->fields["#{$key}#"]=$this->getFild();
            }
            elseif($element->getAttribute('type')=="file"){
                $element->setAttribute('class','images form-control');
                $this->partial=$this->view->partial('/make/partials/file');
                $this->setImage($element,self::$formRowFormat[$sFormLayout],$key);
                $this->labes["{{{$key}}}"]=$this->getLabel();
                $this->fields["#{$key}#"]=$this->getFild();

            }
            else{
                $this->setDefault($element,self::$formRowFormat[$sFormLayout],$key);
                $this->labes["{{{$key}}}"]=$this->getLabel();
                $this->fields["#{$key}#"]=$this->getFild();
            }

            if($position=="datas"){
                $this->datas[$key]=$this->layout[$key];
            }
            elseif($position=="controller"){
                $this->controle[$key]=$this->layout[$key];
            }
            else{
                $this->geral[$key]=$this->layout[$key];
            }
        endforeach;

        $this->layout["btn-voltar"]="";

      //  $this->btn["#btn-voltar#"]="#btn-voltar#";

        $this->fields["#btn-voltar#"]=$this->view->Html('a',"",[
            //'style'=>'margin-top: -37px;',
            'class'=>'btn ink-reaction btn-floating-action btn-lg btn-accent',
            'data-toggle'=>'tooltip',
            'data-original-title'=>"Voltar Para A Listagem",
            'href'=>$this->view->url("{$this->view->route}/default",
                [
                    'controller'=>$this->view->controller,
                    'action'=>'index',
                    'page'=>$this->view->page
                ]
            )
        ]
        )->appendText($this->view->glyphicon('share-alt'));

        $this->fields["action-form-do-formulario"]=$this->view->url("{$this->view->route}/default",['controller'=>$this->view->controller,'action'=>'finalizar']);


    }

    /**
     * @return array
     */
    public function getGeral()
    {
        return $this->geral;
    }

    /**
     * @return array
     */
    public function getBtn()
    {
        return $this->btn;
    }


    /**
     * @param $element
     * @param $sFormLayout
     * @param $key
     */
    public function setDefault($element, $sFormLayout, $key)
    {
        if(!empty($element->getOption('add-on-append'))){
            // $element->setOption('add-on-append',$this->view->fontAwesome($element->getOption('add-on-append')));
        }
        $this->label=$this->view->Html('label',PHP_EOL,['for'=>$key])->setText($this->view->translate($element->getLabel())) ;
        $this->field=$this->view->formElement($element);
        $row=sprintf($this->partial,$this->field,$this->label,$this->view->formElementErrors($element));
        $this->layout[$key]=sprintf($sFormLayout,$row);

    }

    /**
     * @param $element
     * @param $key
     */
    public function setRadio($element,$sFormLayout, $key){
        $label=[];
        foreach($element->getValueOptions() as $key_opt => $vale):
            $checked=$element->getValue()==$key_opt?true:false;
            $el=$this->view->Html('input')->setAttributes(['type'=>$element->getAttribute('type'),'name'=>$element->getAttribute('name'),'id'=>$element->getAttribute('id'),'value'=>$key_opt,'checked'=>$checked]);
            $span=$this->view->Html('span')->setText($vale);
            $label[]=$this->view->Html('label')->setClass($element->getOptions()['label_attributes']['class'])->setText($el)->appendText($span);
        endforeach;
        $this->label='';//$this->view->Html('label',PHP_EOL,['for'=>$key])->setText($this->view->translate($element->getLabel())) ;
        $this->field=implode('',$label);
        $row=sprintf($this->partial,$this->field,$this->label,$this->view->formElementErrors($element));
        $this->layout[$key]=sprintf($sFormLayout,$row);


    }

    /**
     * @param $element
     * @param $sFormLayout
     * @param $key
     * @internal param $labelBox
     * @internal param $rowBox
     */
    public function setDate($element, $sFormLayout, $key)
    {

        $row = sprintf($this->partial, $this->view->formElementErrors($element));
        $this->layout[$key] = sprintf($sFormLayout, $row, $key);
        // $element->setOption('add-on-append', $this->view->glyphicon('calendar'));
        $this->label =$this->view->Html('label',PHP_EOL,['for'=>$key])->setText($this->view->translate($element->getLabel())) ;
        $this->field = $this->view->formElement($element);

    }

    /**
     * @param $element
     */
    public function setButton($element)
    {
        if(!empty($element->getOption('add-on-append'))){
            $element->setOption('glyphicon',$this->view->fontAwesome($element->getOption('add-on-append')));
        }
        $title='';
        if(!empty($element->getAttribute('title'))){
            $title=$this->view->translate($element->getAttribute('title'));
        }
        $this->label="";
        $button=$this->view->Html('button')->setAttributes(
            [
                'data-toggle'=>'tooltip',
                'data-original-title'=>$title,
                'type'=>$element->getAttribute('type'),
                'name'=>$element->getAttribute('name'),
                'class'=>$element->getAttribute('class'),
                'id'=>$element->getAttribute('id')
            ]);
        $label='';
        if(!empty($element->getLabel())){
            $label=$this->view->translate($element->getLabel());
        }
        if(!empty($element->getOption('glyphicon'))){
            $button->setText($this->view->fontAwesome($element->getOption('glyphicon')))->appendText($label);
        }
        else{
            $button->setText($element->getLabel());
        }
        $this->field=$button;
    }

    /**
     * @param $element
     * @param $sFormLayout
     * @param $key
     * @internal param $labelBox
     * @internal param $rowBox
     */
    public function setImage($element, $sFormLayout, $key)
    {

        $element->setAttribute('type','text');
        $this->label=$this->view->Html('label',PHP_EOL,['for'=>$key])->setText($this->view->translate($element->getLabel())) ;
        $this->field=$this->view->formElement($element);
        $row=sprintf($this->partial,$this->label,$this->field,$this->view->formElementErrors($element));
        $this->layout[$key]=sprintf($sFormLayout,$row);
        $root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        $info = new \SplFileInfo(sprintf("%s/dist/%s",$root,$element->getValue()));
        if($this->isFileHidden($info)){
            $this->fields["#imagePriview#"]=$this->view->Html('img',PHP_EOL,['src'=>sprintf("/dist/%s",$element->getValue()),'style'=>'width:100%;height:250px;','id'=>'img-preview'])->appendText(PHP_EOL);
        }
        else{
            $this->fields["#imagePriview#"]=$this->view->Html('img',PHP_EOL,['src'=>'/dist/no_image.jpg','style'=>'width:100%;height:250px;','id'=>'img-preview'])->appendText(PHP_EOL);
        }
    }

    /**
     * Sets form layout class
     * @param AbstractForm $oForm
     * @param string $sFormLayout
     * @return \TwbBundle\Form\View\Helper\TwbBundleForm
     */
    protected function setFormClass(AbstractForm $oForm, $sFormLayout = self::LAYOUT_HORIZONTAL)
    {
        if (is_string($sFormLayout)) {
            $sLayoutClass = 'form-' . $sFormLayout;
            if ($sFormClass = $oForm->getAttribute('class')) {
                if (!preg_match('/(\s|^)' . preg_quote($sLayoutClass, '/') . '(\s|$)/', $sFormClass)) {
                    $oForm->setAttribute('class', trim($sFormClass . ' ' . $sLayoutClass));
                }
            } else {
                $oForm->setAttribute('class', $sLayoutClass);
            }
        }
        return $this;
    }

    /**
     * Generate an opening form tag
     * @param null|AbstractForm $form
     * @return string
     */
    public function openTag(AbstractForm $form = null)
    {
        $this->setFormClass($form, $this->formLayout);
        return parent::openTag($form);
    }

    public function closeTag()
    {
        return parent::closeTag();
    }


    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getLabes()
    {
        return $this->labes;
    }

    /**
     * @return array
     */
    public function getControle()
    {
        return $this->controle;
    }

    /**
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }




    /**
     * @return mixed
     */
    public function getFild()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param \SplFileInfo $file
     * @return bool
     */
    public function isFileHidden(\SplFileInfo $file) {
        $basename = $file->getBasename();
        return strpos($basename, '.') > 0;
    }


}