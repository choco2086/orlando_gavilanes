<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    
    'controller_plugins' => array(
        'invokables' => array(
            
            'EntityManagerPlugin' => 'Application\Controller\Plugin\EntityManagerPlugin',
            'Head' => 'Application\Controller\Plugin\Head',
            
        )
    ),
    
   
    
    
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Application/Entity'
                )
            ),
            
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            )
        )
    ),
    
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index'
                    )
                )
            ),
           ///////////////////////////USER/////////////////////////////// 
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index'
                    )
                )
            ),
          ///////////////////////////NEGOCIO////////////////////////////////  
            'negocio' => array(
                    'type' => 'segment',
                    'options' => array(
                            'route' => '/negocio[/][:action][/:id]',
                            'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                    'controller' => 'Application\Controller\Negocio',
                                    'action' => 'index'
                            )
                    )
            ),
         
          
            ///////////////////////////LISTADOGENERAL////////////////////////////////
            'listadogeneral' => array(
                    'type' => 'segment',
                    'options' => array(
                            'route' => '/listadogeneral[/][:action][/:id]',
                            'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                    'controller' => 'Application\Controller\Listadogeneral',
                                    'action' => 'index'
                            )
                    )
            ),
            /////////////////////////////////////////////////////////////////////
            
            
            
            
            
            
            
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    
    ///////////////////Agregar aqui las rutas de los controladores/////////////////////////
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Negocio' => 'Application\Controller\NegocioController',
            'Application\Controller\Listadogeneral' => 'Application\Controller\ListadogeneralController'
        )
    ),
   ////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    
    
    'view_helpers' => array(
            'invokables'=> array(
                    'fecha_helper' => 'Application\View\Helper\Fechahelper',
                    'sesion_helper' => 'Application\View\Helper\Sesionhelper'
            )
    ),
    
    
  
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ) 
    
  
    
);
