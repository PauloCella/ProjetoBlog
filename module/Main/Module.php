<?php

namespace Main;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig(){
        
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager){
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }
    
    /**
     * Executa no bootstrap do módulo
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap($e){
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\ModuleManager\ModuleManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        
        //adicionaeventos ao modulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH,array($this, 'mvcPreDispatch'),100);
        
    }
    
    /**
     * Verifica se precisa fazer a autorizacao do acesso 
     * @param MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event){
        
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');
        $authService = $di->get('Admin\Service\Auth');
        
        
        
        if(!$authService->authorize($moduleName,$controllerName,$actionName)){
            throw new \Exception('Voce não tem permissao para acessar esse recurso!');
        }
        
        
        return true;
        
    }
        
   }
    