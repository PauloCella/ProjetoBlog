<?php

// module/Main/conﬁg/module.config.php:
return array(
    'controllers' => array(//add module controllers
        'invokables' => array(
            'Main\Controller\Index' => 'Main\Controller\IndexController',
        ),
    ),
//Configuração doctrine
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Main/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Main\Entity' => 'application_entities'
                )
            ))),
//*********************************************************
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Main\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        'module' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array(//permite mandar dados pela url
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),

            
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'Session' => function ($sm){
                return new Zend\Session\Container('SessionMain');
            },
        )
    ),
    
    'view_manager' => array(//the module can have a specific layout
// 'template_map' => array(
// 'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
// ),
        'template_path_stack' => array(
            'main' => __DIR__ . '/../view',
        ),
    ),
        /* 'db' => array( //module can have a specific db configuration
          'driver' => 'PDO_SQLite',
          'dsn' => 'sqlite:' . __DIR__ .'/../data/admin.db',
          'driver_options' => array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
          )
          ) */
);
