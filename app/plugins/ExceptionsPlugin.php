<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExceptionsPlugin
 *
 * @author Theophilus Alamu <theophilus.alamu at gmail.com>
 */
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher,    Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;

class ExceptionsPlugin extends Plugin{
    //put your code here
    private static $_instance;
    
    private function __construct() {
        
    }
    
    public static function getExceptionInst(){
        if(!isset(self::$_instance) || empty(self::$_instance)){
            self::$_instance  = new ExceptionsPlugin();
        }
        return self::$_instance;
    }
    
    public function beforeException(Event $events, Dispatcher $dispatcher, $exception){
        if($exception instanceof DispatcherException){
            $dispatcher->forward(array(
                'controller'    => 'index',
                'action'        => 'show404'
            ));
            return false;
        }
        //Alternatively check if controller or action doesnot exist
        switch($exception->getCode()){
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward(array(
                    'controller'    => 'index',
                    'action'        => 'show404'
                ));
                return false;
                break;
            case Dispatcher::EXCEPTION_INVALID_HANDLER:
            case Dispatcher::EXCEPTION_INVALID_PARAMS:
                $dispatcher->forward(array(
                    'controller'    => 'index',
                    'action'        => 'show409'
                ));
                return false;
                break;
        }
    }
}
