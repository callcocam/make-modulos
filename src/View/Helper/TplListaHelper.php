<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 25/08/2016
 * Time: 09:34
 */

namespace Make\View\Helper;


use Interop\Container\ContainerInterface;
use Make\Model\Makes\MakesRepository;
use Zend\Debug\Debug;
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

    public function gerarTpllistar($routeCurrent,$currentController,$module,$block){
       $make=$this->containerInterface->get(MakesRepository::class)->findOneBy(['route'=>$routeCurrent,'controller'=>$currentController]);
        $partial="";
        if($make->getResult()):
            $parent=$make->getData()->getParent();
            $route=$make->getData()->getRoute();
            $controller=$make->getData()->getController();
            if(!is_dir("./{$module}/{$parent}/view/{$route}/{$controller}")):
                mkdir("./{$module}/{$parent}/view/{$route}/{$controller}");
            endif;
            if (!$this->view->resolver("{$route}/{$controller}/listar")) :
                file_put_contents("./{$module}/{$parent}/view/{$route}/{$controller}/listar.phtml", $block);
            endif;
            $partial=$this->view->partial("{$route}/{$controller}/listar");
        endif;
        return $partial;
    }

    public function gerarTpleditar($routeCurrent,$currentController,$module,$tplEditar,$form){
        $make=$this->containerInterface->get(MakesRepository::class)->findOneBy(['route'=>$routeCurrent,'controller'=>$currentController]);
        $html="";
        if($make->getResult()):
            $parent=$make->getData()->getParent();
            $route=$make->getData()->getRoute();
            $controller=$make->getData()->getController();
            if(!is_dir("./{$module}/{$parent}/view/{$route}/{$controller}")):
                mkdir("./{$module}/{$parent}/view/{$route}/{$controller}");
            endif;
            if (!$this->view->resolver("{$route}/{$controller}/{$tplEditar}")) :
                $html=str_replace("#open-form#", $this->view->MakeForm()->openTag($form), $this->view->partial("/make/partials/fieldset"));
                $default=str_replace("#close-form#", $this->view->MakeForm()->closeTag(), $html);
                $html=str_replace("#controller#", implode(PHP_EOL,$this->view->MakeForm()->getControle()), $default);
                $default=str_replace("#datas#", implode(PHP_EOL,$this->view->MakeForm()->getDatas()), $html);
                $html=str_replace("#geral#", implode(PHP_EOL,$this->view->MakeForm()->getGeral()), $default);
                file_put_contents("./{$module}/{$parent}/view/{$route}/{$controller}/{$tplEditar}.phtml", $html);
            endif;
            $html = $this->view->partial("{$route}/{$controller}/{$tplEditar}");
        endif;
        return $html;
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