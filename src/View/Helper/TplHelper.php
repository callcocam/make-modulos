<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 18/08/2016
 * Time: 19:40
 */

namespace Make\View\Helper;


use Base\Form\AbstractForm;
use Interop\Container\ContainerInterface;
use Zend\View\Helper\AbstractHelper;

class TplHelper extends AbstractHelper {
    /**
     * @var ContainerInterface
     */
    private $containerInterface;

    private $dir;

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
    private static $formRowFormat = '<div class="row">%s</div>';

    /**
     * Form layout (see LAYOUT_* consts)
     *
     * @var string
     */
    protected $formLayout = [];
    /**
     * @param ContainerInterface $containerInterface
     */
    function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
        $this->dir=$containerInterface->get('request')->getServer('DOCUMENT_ROOT');
    }

    function __invoke(AbstractForm $form)
    {
        $this->gerarTemplate($form);

    }


    public function gerarTemplate($form){
        if($form):
            foreach($form->getElements() as $element):
                $file=$element->getAttribute('type');
                if($element->getAttribute('type')!="hidden"){
                    $fildSet['#label#']=$element->getLabel();
                }
                if($element->getAttribute('name')=="images"){
                    $element->setAttribute('type','hidden');
                    $file="file";
                }
                $fildSet['#filed#']=$this->view->formElement($element);
                $fildSet['#error#']=  $this->view->formElementErrors()->render($element, ['class' => 'help-block']);
                if($this->view->resolver(sprintf("/partial/tpl/%s",$file))){
                    $partial=$this->view->partial(sprintf("/partial/tpl/%s",$file));
                }
                else{
                    $partial=$this->view->partial("/partial/tpl/text");
                }
                $this->formLayout[]= str_replace(array_keys($fildSet),array_values($fildSet),$partial);
            endforeach;
        endif;
    }

    public function btnGrup($o){?>
          <div class="btn-group">
          <a href="<?=$this->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>" type="button" class="btn btn-danger">Gerar Module</a>
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="<?=$this->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>">Action</a></li>
            <li><a href="<?=$this->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>">Another action</a></li>
            <li><a href="<?=$this->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>">Something else here</a></li>
            <li><a href="<?=$this->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>">Separated link</a></li>
          </ul>
        </div>
    <?php }
}