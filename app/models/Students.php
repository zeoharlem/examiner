<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Students
 *
 * @author webadmin
 */
use Phalcon\Validation\Validator;

class Students extends \Phalcon\Mvc\Model{
    //put your code here
    public $password;
    private $_security;
    
    public function initialize(){
        $this->_security = new \Phalcon\Security();
        if(method_exists($this, 'allowEmptyStringValues')){
            $this->allowEmptyStringValues(array(
                'congregation','entry'
            ));
        }
    }
    
    public function validation(){
        $validation = new \Phalcon\Validation();
        $validation->add('email', new Validator\Email(array(
            'model'     => $this,
            'message'   => 'Please enter correct email address'
        )));
        return $this->validate($validation);
    }
}
