<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logger
 *
 * @author Theophilus Alamu <theophilus.alamu at gmail.com>
 */
//namespace FileLogger;

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Formatter\Line as LineFormater;
use Phalcon\Mvc\User\Plugin;

class LoggersPlugin extends Plugin{
    //put your code here
    private $_logger;
    private static $_instance;
    private function __construct(){
        $this->_logger  = new FileAdapter("../app/logs/test.log");
        //$formatter  = new LineFormater("%date% - %message%");
    }
    
    //getting the instance once the class instantiated
    public static function getLoggerInst(){
        if(!isset(self::$_instance) || empty(self::$_instance)){
            self::$_instance  = new LoggersPlugin();
        }
        return self::$_instance;
    }
    
    public function setLogFile($file){
        $this->_logger  = new FileAdapter("../app/logs/".$file.".log");
        //$formatter  = new LineFormater("%date% - %message%");
    }
    
    //get the logger instantiated publicly
    public function getLogger(){ return $this->_logger; }
}
