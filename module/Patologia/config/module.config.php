<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Patologia;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'
                    ],
                ],
            ],
            'patologia' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/patologia',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'amostra' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/amostra[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\AmostraController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'analise' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/analise[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\AnaliseController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'determinacao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/determinacao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\DeterminacaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'especie' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/especie[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\EspecieController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'metodo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/metodo[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MetodoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'saprofita' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/saprofita[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\SaprofitaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'resultado' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/resultado[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ResultadoController::class,
                                'action' => 'find'
                            ]
                        ]
                    ],
                ],
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\AmostraController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\AnaliseController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\DeterminacaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\EspecieController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\IndexController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MetodoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\SaprofitaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ResultadoController::class => Service\Factory\PadraoControllerFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
//            Service\AmostraManager::class => Service\Factory\AmostraManagerFactory::class,
//            Service\AnaliseManager::class => Service\Factory\AnaliseManagerFactory::class,
//            Service\DeterminacaoManager::class => Service\Factory\DeterminacaoManagerFactory::class,
//            Service\EspecieManager::class => Service\Factory\EspecieManagerFactory::class,
//            Service\MetodoManager::class => Service\Factory\MetodoManagerFactory::class,
//            Service\SaprofitaManager::class => Service\Factory\SaprofitaManagerFactory::class,
//            Service\ResultadoManager::class => Service\Factory\ResultadoManagerFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'patologia/index/index' => __DIR__ . '/../view/patologia/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
