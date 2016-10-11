<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 26/08/2016
 * Time: 13:22
 */

namespace Make\Services;


use Base\Model\Cache;
use Interop\Container\ContainerInterface;
use Make\Model\Grupos\GruposRepository;
use Make\Model\Makes\MakesRepository;
use Zend\Code\Generator\FileGenerator;
use Zend\Config\Writer\PhpArray;
use Zend\Debug\Debug;

class MakeNavigation extends Options {

    protected $item = array();
    protected $subaction = array();
    protected $menu=[];
    protected $my_body;
    /**
     * @param ContainerInterface $containerInterface
     */
    function __construct(ContainerInterface $containerInterface,$default="default")
    {
        $this->container = $containerInterface;
         $groups=$this->container->get(GruposRepository::class)->findBy(['state'=>'0'],['ordering'=>"ASC"]);
         if($groups->getResult()){
            foreach($groups->getData()->toArray() as $group):
               $this->subMenu($group["alias"]);
                if ($this->item):
                       $this->setMenu($group["alias"],["label"=>$group["title"],"class"=>'treeview',"action"=> $group["url"],"icone"=>$group["icone"],"title"=>$group["title"],"pages"=>$this->item]);
                endif;

            endforeach;
         }
        $writer = new PhpArray();
        $this->my_body=trim($writer->toString($this->menu));
     }
    protected function setMenu($key,$item){
        $this->menu[$key]=$item;
    }

    private function subMenu($grupo) {
        unset($this->item);
        $this->item = array();
        $make=$this->container->get(MakesRepository::class);
        $make->findBy(['grupo'=>$grupo]);
          if ($make->getData()->getResult()):
            foreach ($make->getData()->getData() as $key => $value):
                $value=$value->toArray();
                $title = strtoupper($value['title']);
                $route = strtolower($value['route']);
                $controller = strtolower($value['controller']);
                $resource = $value['alias'];
                //$resource = strtolower($value['alias']);
                $action = strtolower($value['action']);
                $privilege = strtolower($value['privilege']);
                $icone = strtolower($value['icone']);
                $description = strtolower($value['description']);
                $parent=strtolower($value['parent']);
                $this->setMenuitem(
                    $key,
                    [
                        "label"=>$title,
                        "route"=>"{$route}/default",
                        "controller"=>$controller,
                        "resource"=>$resource,
                        "action"=>$action,
                        "privilege"=>$privilege,
                        "icone"=>$icone,
                        "title"=>utf8_decode(strip_tags($description)),
                        'pages' => array(
                            0 => array(
                                'label' => 'CADASTRANDO',
                                'route' => "{$route}/default",
                                'controller' => $controller,
                                'resource' => $resource,
                                'action' => 'create',
                                'privilege' => 'create',
                                'title' => 'Cadastrando Um Novo Registro',
                            ),
                            1 => array(
                                'label' => 'ALTERANDO',
                                'route' =>"{$route}/default",
                                'controller' => $controller,
                                'resource' => $resource,
                                'action' => 'update',
                                'privilege' => 'update',
                                'title' => 'Editar',
                            )
                        )

                    ]);
            endforeach;
        endif;
    }

    public function setMenuitem($key,$item) {
        $this->item[$key] = $item;
    }
    /**
     * @param $fileName
     * @return string
     */
    public function generate($fileName) {
        $fileGenerate = new FileGenerator();
        $fileGenerate->setFilename($fileName)->setBody(trim($this->my_body))->write();
        return $fileGenerate->generate();
    }

}