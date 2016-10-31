<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lecturer
 *
 * @author web
 */
use Phalcon\Validation\Validator;

class Lecturer extends BaseModel{
    public $password, $codename;
    //put your code here
    public function beforeValidationOnCreate(){
        $this->role     = 'user';
        $component = $this->getDI()->getComponent();
        $this->password = $component->helper->makeRandomString(4);
        $this->codename = $component->helper->makeRandomInts();
    }
    
    public function afterValidationOnCreate(){
        
    }
    
    public function validation(){
        $validation = new Phalcon\Validation();
        $validation->add('email', new Validator\Email(array(
            'model'     => $this, 
            'message'   => 'Please enter correct email address'
        )));
        
        $validation->add('email', new Validator\Uniqueness(array(
            'model'     => $this, 
            'message'   => 'Email Already Existed'
        )));
        
        $validation->add('codename', new Validator\Uniqueness(array(
            'model'     => $this, 
            'message'   => 'Codename already existed'
        )));
        
        return $this->validate($validation);
    }
}
