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
use Make\Model\Makes\MakesRepository;
use Zend\Code\Generator\FileGenerator;
use Zend\Debug\Debug;

class MakeNavigation extends Options {

    protected $item = array();
    protected $subaction = array();
    /**
     * @param ContainerInterface $containerInterface
     */
    function __construct(ContainerInterface $containerInterface,$default="default")
    {
        $this->container = $containerInterface;
        $entro = false;
        $grupo=$this->container->get('ZfConfig');
        if($grupo->grupos){
            $entro = true;
            $this->setBody(sprintf('$%s= [',$default));
            foreach($grupo->grupos->toArray() as $key =>$title):
               $this->subMenu($key);
                if ($this->item):
                    $this->setBody("          [");
                    $this->setBody("              'label' => '{$title}',");
                    $this->setBody("              'class' => 'treeview',");
                    $this->setBody("              'action'     => '#',");
                    $this->setBody("              'icone'     => '',");
                    $this->setBody("              'title'   => '{$title}',");
                    $it = implode(PHP_EOL, $this->item);
                    $this->setBody("              'pages'   => [{$it}]");
                    $this->setBody("          ],");
                endif;
            endforeach;
            $this->setBody("          ];");
            $this->setBody(PHP_EOL);
           if (!$entro) {
                $this->setBody("limpa");
                $this->setBody("return ;");
            }
            }

     }

    private function subMenu($grupo) {
        unset($this->item);
        $this->item = array();
        $make=$this->container->get(MakesRepository::class);
        $make->findBy(['grupo'=>$grupo]);
          if ($make->getData()->getResult()):
            foreach ($make->getData()->getData() as $value):
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
                $this->setMenuitem(PHP_EOL);
                $this->setMenuitem("                    [");
                $this->setMenuitem("                          'label'      => '{$title}',");
                $this->setMenuitem("                          'route'      => '{$route}',");
                $this->setMenuitem("                          'controller' => '{$controller}',");
                $this->setMenuitem("                          'resource'   =>  '{$resource}',");
                $this->setMenuitem("                          'action'     => '{$action}',");
                $this->setMenuitem("                          'privilege'  => '{$privilege}',");
                $this->setMenuitem("                          'icone'      => '{$icone}',");
                $this->setMenuitem("                          'title'      => '{$description}',");
                $this->setMenuitem("                    ],");
            endforeach;
        endif;
    }

    public function setMenuitem($item) {
        $this->item[] = $item;
    }
    /**
     * @param $fileName
     * @return string
     */
    public function generate($fileName) {
        $fileGenerate = new FileGenerator();
        $fileGenerate->setFilename($fileName)->setBody(implode(PHP_EOL, $this->body))->write();
        return $fileGenerate->generate();
    }

}