<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 26/08/2016
 * Time: 13:22
 */

namespace Make\Services;


use Interop\Container\ContainerInterface;
use Zend\Code\Generator\FileGenerator;

class MakeConfig extends Options {


    protected $my_body;

    /**
     * @param $data
     * @param ContainerInterface $container
     * @internal param ContainerInterface $containerInterface
     */
    function __construct($data, ContainerInterface $container)
    {
        $module=$data['alias'];
        $route=strtolower($data['alias']);
        $this->container = $container;
          // namespace Auth;
        $this->setBody(sprintf("namespace %s;".PHP_EOL,$module));
        $this->setBody(' return [');
        $this->setBody(' "router" => [');
        $this->setBody('        "routes" => [');
        $this->setBody('            "%s" => [');
        $this->setBody('                "type" => "Literal",');
        $this->setBody('               "options" => [');
        $this->setBody('                    "route" => "/%s",');
        $this->setBody('                    "defaults" => [');
        $this->setBody('                       "__NAMESPACE__" =>"%s\\Controller",');
        $this->setBody('                       "controller" => "%s",');
        $this->setBody('                      "action" => "index",');
        $this->setBody('                  ],');
        $this->setBody('              ],');
        $this->setBody('            "may_terminate" => true,');
        $this->setBody('            "child_routes" => [');
        $this->setBody('                "default" => [');
        $this->setBody('                    "type" => "Segment",');
        $this->setBody('                        "options" => [');
        $this->setBody('                            "route" => "/[:controller[/:action][/:id][/:page]]",');
        $this->setBody('                            "constraints" => [');
        $this->setBody('                                "controller" => "[a-zA-Z][a-zA-Z0-9_-]*",');
        $this->setBody('                                "action" => "[a-zA-Z][a-zA-Z0-9_-]*",');
        $this->setBody('                            ],');
        $this->setBody('                           "defaults" => [');
        $this->setBody('                           ],');
        $this->setBody('                       ],');
        $this->setBody('                   ],');
        $this->setBody('              ],');
        $this->setBody('          ],');
        $this->setBody('      ],');
        $this->setBody('  ],');
        $this->setBody(' "view_manager" => [');
        $this->setBody('     "template_path_stack" => [');
        $this->setBody('         __DIR__ . "/../view",');
        $this->setBody('       ],');
        $this->setBody('   ],');
        $this->setBody(' ];');
        $body=implode(PHP_EOL, $this->getBody());
        $this->my_body=sprintf($body, $route,$route,$module,$module);
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