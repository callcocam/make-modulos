<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 25/08/2016
 * Time: 09:34
 */

namespace Make\View\Helper;


use Interop\Container\ContainerInterface;
use Zend\View\Helper\AbstractHelper;

class TplListaHelper extends AbstractHelper {
    /**
     * @var ContainerInterface
     */
    private $containerInterface;


    /**
     * @param ContainerInterface $containerInterface
     */
    function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    public function geraListagem($data){
        $partial=$this->view->partial("/partial/tpl/index");
        $render=[];

        return $partial;

    }
    public function btnGrup($o){?>
        <div class="btn-group">
            <a data-question="POR FAVOR CONFIRME A OPERAÇÃO!"  href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id']])?>" type="button" class="btn btn-success btn-xs confirm">Gerar Module</a>
            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="confirm" data-question="POR FAVOR CONFIRME A OPERAÇÃO!" href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id'],'files'=>'model'])?>"><span class="md md-view-module"> Model</span></a></li>
                <li><a class="confirm" data-question="POR FAVOR CONFIRME A OPERAÇÃO!"  href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id'],'files'=>'repository'])?>"><span class="md md-receipt"> Repository</span></a></li>
                <li><a class="confirm" data-question="POR FAVOR CONFIRME A OPERAÇÃO!"  href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id'],'files'=>'controller'])?>"><span class="md md-settings-input-component"> Controller</span></a></li>
                <li><a class="confirm" data-question="POR FAVOR CONFIRME A OPERAÇÃO!"  href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'gerar','id'=>$o['id'],'files'=>'form'])?>"><span class="md md-format-list-numbered"> Form</span></a></li>
                <li><a class="confirm" data-question="POR FAVOR CONFIRME A OPERAÇÃO!" href="<?=$this->view->url("{$this->view->route}/default",['controller'=>'make','action'=>'destroy','id'=>$o['id']])?>"><span class="fa fa-trash"></span> Deletar Module</a></li>
            </ul>
        </div>
    <?php }

}