<?php
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:39
 */

namespace Make\Controller;


use Base\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Make\Model\Makes\Makes;
use Make\Model\Makes\MakesRepository;
use Make\Model\Modules\Modules;
use Make\Model\Modules\ModulesRepository;
use Make\Services\Controller;
use Make\Services\ControllerFactory;
use Make\Services\FactoryFilter;
use Make\Services\FactoryForm;
use Make\Services\FactoryModel;
use Make\Services\Filter;
use Make\Services\Form;
use Make\Services\MakeConfig;
use Make\Services\MakeModule;
use Make\Services\MakeNavigation;
use Make\Services\Model;
use Make\Services\Repository;
use Make\Services\RepositoryFactory;
use Zend\Config\Writer\PhpArray;
use Zend\Debug\Debug;
use Zend\View\Model\ViewModel;

class MakeController extends AbstractController{

    /**
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container)
    {
        // TODO: Implement __construct() method.
        $this->containerInterface = $container;
        $this->template="admin/admin/index";
        $this->table=MakesRepository::class;
        $this->model=Makes::class;
        $this->route="makes";
        $this->controller="make";

    }
    public function gerarAction()
    {
        $ds = DIRECTORY_SEPARATOR;
        $module=$this->params()->fromRoute('id');
        $param=$this->params()->fromRoute('files',null);
        $make=$this->getTable()->find($module,false);
        $msg=[];
         if($make->getData()){
            $data=$make->getData();
            $module=$data['parent'];
            $classe=$data['arquivo'];
            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model"))){
                mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model"));
            }

            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form"))){
                mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form"));
            }

            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"))){
                mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"));
            }

            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model{$ds}{$classe}"))){
                mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model{$ds}{$classe}"));
            }
           /* $viewTemplate=strtolower($data['controller']);
            $viewTemplateRoute=strtolower($data['route']);
            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$viewTemplateRoute}{$ds}{$viewTemplate}"))){
             mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$viewTemplateRoute}{$ds}{$viewTemplate}"));
            }*/


            /*Model Factory*/

             if(!$param || $param=='model' ){

                 if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model{$ds}{$classe}{$ds}Factory"))){
                 mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model{$ds}{$classe}{$ds}Factory"));
                }
                 $model=new Model($data,$this->containerInterface);
                 $model->generateClass();
                 $msg[]="Model {$classe} Foi Criado Com Sucesso!";

                 $modelFactory=new FactoryModel($data,$this->containerInterface);
                 $modelFactory->generateClass();
                 $msg[]="Model Factory {$classe} Foi Criado Com Sucesso!";
             }

             if(!$param || $param=='repository' ){
                 $repository=new Repository($data,$this->containerInterface);
                 $repository->generateClass();
                 $msg[]="Repository {$classe} Foi Criado Com Sucesso!";

                 $repositoryFactory=new RepositoryFactory($data,$this->containerInterface);
                 $repositoryFactory->generateClass();
                 $msg[]="Repository Factory {$classe} Foi Criado Com Sucesso!";
             }


             if(!$param || $param=='controller' ){
                 if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"))){
                     mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"));
                 }
                 $controller=new Controller($data,$this->containerInterface);
                 $controller->generateClass();
                 $msg[]="Controller {$classe} Foi Criado Com Sucesso!";

                 if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller{$ds}Factory"))){
                     mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller{$ds}Factory"));
                 }
                 $controllerFactory=new ControllerFactory($data,$this->containerInterface);
                 $controllerFactory->generateClass();
                 $msg[]="Controller Factory {$classe} Foi Criado Com Sucesso!";
             }
             if(!$param || $param=='controller' ){

                 if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form"))){
                     mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form"));
                 }
                 $form=new Form($data,$this->containerInterface);
                 $form->generateClass();
                 $msg[]="Form {$classe} Foi Criado Com Sucesso!";

                 if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form{$ds}Factory"))){
                     mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Form{$ds}Factory"));
                 }
                 $formFactory=new FactoryForm($data,$this->containerInterface);
                 $formFactory->generateClass();
                 $msg[]="Form Factory {$classe} Foi Criado Com Sucesso!";

                 $filter=new Filter($data,$this->containerInterface);
                 $filter->generateClass();
                 $msg[]="Filter {$classe} Foi Criado Com Sucesso!";

                 $filterFactory=new FactoryFilter($data,$this->containerInterface);
                 $filterFactory->generateClass();
                 $msg[]=PHP_EOL;
                 $msg[]="Filter Factory {$classe} Foi Criado Com Sucesso!";
             }


            $this->Messages()->flashSuccess(implode("<p>",$msg));
             return $this->redirect()->toRoute("make");
        }
        return new ViewModel(['error'=>"Nenhum Parametro Valido Foi Passado, Você Deve Passar Um Model E Uma Tabela"]);
    }

    public function destroyAction()
    {
        $module=$this->params()->fromRoute('id');
        $make=$this->getTable()->find($module,false);
        $ds = DIRECTORY_SEPARATOR;
        if($make->getData()) {
            $data=$make->getData();
            $module=$data['parent'];
            $classe=$data['arquivo'];

            $msg[]=PHP_EOL;
            $msg[]="Você Pode Ainda Remover Os Uses No Arquivo module/{$module}/src/Module.php";
            $path=sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Model{$ds}{$classe}");
            if (PHP_OS === 'Windows')
            {
                exec("rd /s /q {$path}");
                $msg[]="use {$module}\Model\\{$classe}\Factory\\{$classe}Factory;";
                $msg[]="use {$module}\Model\\{$classe}\Factory\\{$classe}RepositoryFactory;";
                $msg[]="use {$module}\Model\\{$classe}\\{$classe};";
                $msg[]="use {$module}\Model\\{$classe}\\{$classe}Repository;";
            }
            else
            {
                exec("rm -rf {$path}");
                $msg[]="use {$module}\Model\\{$classe}\Factory\\{$classe}Factory;";
                $msg[]="use {$module}\Model\\{$classe}\Factory\\{$classe}RepositoryFactory;";
                $msg[]="use {$module}\Model\\{$classe}\\{$classe};";
                $msg[]="use {$module}\Model\\{$classe}\\{$classe}Repository;";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Form/%sForm.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Form/%sForm.php",$classe));
                $msg[]="use {$module}\Form\\{$classe}Form;";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Form/Factory/%sFormFactory.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Form/Factory/%sFormFactory.php",$classe));
                $msg[]="use {$module}\Form\Factory\\{$classe}FormFactory;";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Form/%sFilter.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Form/%sFilter.php",$classe));
                $msg[]="use {$module}\Form\\{$classe}Filter;";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Form/Factory/%sFilterFactory.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Form/Factory/%sFilterFactory.php",$classe));
                $msg[]="use {$module}\Form\Factory\\{$classe}FilterFactory;";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Controller/%sController.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Controller/%sController.php",$classe));
                $msg[]=PHP_EOL;
                $msg[]="Você Pode Ainda Remover Os Serviços No Arquivo module/{$module}/config/module.config.php";
                $msg[]="{$classe}Controller::class=>{$classe}ControllerFactory::class,";
            }

            if(file_exists(sprintf("./{$this->config->module}/{$module}/src/Controller/Factory/%sControllerFactory.php",$classe))){
                unlink(sprintf("./{$this->config->module}/{$module}/src/Controller/Factory/%sControllerFactory.php",$classe));
            }
            $msg[]=PHP_EOL;
            $msg[]="Você Pode Ainda Remover Os Serviços No Arquivo module/{$module}/Module.php";
            $msg[]="{$classe}::class=>{$classe}Factory::class,";
            $msg[]="{$classe}Repository::class=>{$classe}RepositoryFactory::class,";
            $msg[]="{$classe}Form::class=>{$classe}FormFactory::class,";
            $msg[]="{$classe}Filter::class=>{$classe}FilterFactory::class,";


            $this->Messages()->flashError(implode("<p>",$msg));
            return $this->redirect()->toRoute("make");

        }
        return new ViewModel(['error'=>"Nenhum Parametro Valido Foi Passado, Você Deve Passar Um Model E Uma Tabela"]);
    }

    /**
     * Gera A Nevegação Do Sistema
     */
    public function navigationAction(){

        $navigatio=new MakeNavigation($this->containerInterface,"special");
        $navigatio->generate('./config/autoload/special.php');
        $this->Messages()->flashSuccess("NAVEGAÇÃO ATUALIZADA COM SUCESSO!");
        return $this->redirect()->toRoute("make");

    }

    public function traduzirAction(){
        $this->containerInterface->get('Base\Services\Tradutor')->writer();
        $this->Messages()->flashSuccess("TRADUÇÂO FOI ATUALIZADA COM SUCESSO!");
        return $this->redirect()->toRoute("make");
    }
    public function servicesAction(){
        $make=$this->getTable()->findBy(['state'=>'0']);
        if($make->getData()) {
            $data = $make->getData();
            $service_factories=[];
            $controllers_factories=[];
            $controllers['controllers']=[];
            $servicos['service_manager']['factories']=[];
            if($make->getResult()){
                foreach($make->getData() as $o){
                    $parent=$o->getParent();
                    $arquivo=$o->getArquivo();
                    $service_factories["{$parent}\\Model\\{$arquivo}\\{$arquivo}"]="{$parent}\\Model\\{$arquivo}\\Factory\\{$arquivo}Factory";
                    $service_factories["{$parent}\\Model\\{$arquivo}\\{$arquivo}Repository"]="{$parent}\\Model\\{$arquivo}\\Factory\\{$arquivo}RepositoryFactory";
                    $service_factories["{$parent}\\Form\\{$arquivo}Form"]="{$parent}\\Form\\Factory\\{$arquivo}FormFactory";
                    $service_factories["{$parent}\\Form\\{$arquivo}Filter"]="{$parent}\\Form\\Factory\\{$arquivo}FilterFactory";

                    $controllers_factories["{$parent}\\Controller\\{$arquivo}"]="{$parent}\\Controller\\Factory\\{$arquivo}ControllerFactory";


                }
                $servicos['service_manager']['factories']=$service_factories;
                $servicos['controllers']['factories']=$controllers_factories;
                $writer = new PhpArray();

                file_put_contents("./config/autoload/services.module.global.php",$writer->toString($servicos));

            }
            $this->Messages()->flashSuccess("SERVIÇOS ATUALIZADA COM SUCESSO!");
        }
        else{
            $this->Messages()->flashSuccess("NENHUM SERVIÇO PARA ESTE MODULE FOI ENCNTRADO!");
        }
        return $this->redirect()->toRoute("make");
    }


    public function createnewAction(){
        $this->table=ModulesRepository::class;
        $this->model=Modules::class;
        $ds=DIRECTORY_SEPARATOR;
        $msg=[];
        $id=$this->params()->fromRoute('id',0);
        if(!$id){
            $this->Messages()->flashError("NENHUM CODIGO VALIDO FOI PASSADO!");
            return $this->redirect()->toRoute("make/default",['controller'=>'modules','action'=>'index']);
        }

        $modules=$this->getTable()->find($id,false);
        if($modules->getData()) {
            $data = $modules->getData();
            if($data['state']){
                $this->Messages()->flashError("O MODULO SELECIONADO ETA COM O STATE ARQUIVADO, NÂO PODE SER GERADO!");
                return $this->redirect()->toRoute("make/default",['controller'=>'modules','action'=>'index']);
            }
            $path="./config/modules.config.php";
            $config = new \Zend\Config\Config(include $path, true);
            $config=$config->toArray();
            $config[]=$data['alias'];
           // $writer = new \Zend\Config\Writer\PhpArray();
           // file_put_contents('./config/modules.config1.php', $writer->toString($config));die;
           // Debug::dump($data);
            $module=$data['alias'];
            if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}"))){
                if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}"))){
                       $msg[]="CRIOU O MODULE {$module}";
                    if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src"))){
                        $msg[]="O Caminho {$ds}{$this->config->module}{$ds}{$module}{$ds}src Foi Criado Com Sucesso!";
                        $makeModule=new MakeModule($data,$this->containerInterface);
                        $makeModule->generateClass();
                        if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"))){
                            mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"));
                        }

                        if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"))){
                            mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller"));
                        }
                        $data['parent']=$module;
                        $data['arquivo']=$module;
                        $data['route']=$data['url'];
                        $controller=new \Make\Services\MakeController($data,$this->containerInterface);
                        $controller->generateClass();
                        $msg[]="Controller {$module} Foi Criado Com Sucesso!";

                        if(!is_dir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller{$ds}Factory"))){
                            mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}src{$ds}Controller{$ds}Factory"));
                        }
                        $controllerFactory=new ControllerFactory($data,$this->containerInterface);
                        $controllerFactory->generateClass();
                        $msg[]="Controller Factory {$module} Foi Criado Com Sucesso!";


                        if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}config"))){
                            $msg[]="O Caminho {$ds}{$this->config->module}{$ds}{$module}{$ds}config Foi Criado Com Sucesso!";
                            $config=new MakeConfig($data,$this->containerInterface);
                            $config->generate(".{$ds}{$this->config->module}{$ds}{$module}{$ds}config{$ds}module.config.php");
                        }

                        $view=strtolower($module);
                        if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view"))){
                            if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$view}"))){
                                if(mkdir(sprintf(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$view}{$ds}{$view}"))){
                                    file_put_contents(".{$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$view}{$ds}{$view}{$ds}index.phtml",$module);
                                    $msg[]="O Caminho {$ds}{$this->config->module}{$ds}{$module}{$ds}view{$ds}{$view}{$ds}{$view}{$ds}index.phtml Foi Criado Com Sucesso!";
                                }
                            }
                        }

                        $model=$this->getModel();
                        $model->exchangeArray($data);
                       // $model->setState('1');
                        $model->setUrl(strtolower($module));
                        $this->getTable()->update($model,$data['id']);
                        $this->Messages()->flashSuccess(sprintf("MODULO CRIADO COM SUCESSO! %s",implode(PHP_EOL,$msg)));
                    }
                }


            }
            else{
                $this->Messages()->flashError("NÂO FOI POSSIVEL CRIAR O MODULO!");
            }

        }
        else{
            $this->Messages()->flashError("NENHUM MODULO FOI ENCNTRADO!");
        }
        return $this->redirect()->toRoute("make/default",['controller'=>'modules','action'=>'index']);
    }


}