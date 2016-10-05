<?php
namespace Make;
/**
 * Created by PhpStorm.
 * User: Call
 * Date: 31/07/2016
 * Time: 10:32
 */

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            "make" => [
                "type" => "Literal",
                "options" => [
                    "route" => "/make",
                    "defaults" => [
                        "__NAMESPACE__" => "Make\Controller",
                        "controller" => "Makes",
                        "action" => "index",
                    ],
                ],
                "may_terminate" => true,
                "child_routes" => [
                    "default" => [
                        "type" => "Segment",
                        "options" => [
                            "route" => "/[:controller[/:action][/:id][/:files]]",
                            "constraints" => [
                                "controller" => "[a-zA-Z][a-zA-Z0-9_-]*",
                                "action" => "[a-zA-Z][a-zA-Z0-9_-]*",
                            ],
                            "defaults" => [
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Make\Controller\Make' => 'Make\Controller\Factory\MakeControllerFactory',
            'Make\Controller\Makes'=>'Make\Controller\Factory\MakesControllerFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];