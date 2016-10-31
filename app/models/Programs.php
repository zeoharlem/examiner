<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Programs
 *
 * @author web
 */
use Phalcon\Validation\Validator;

class Programs extends BaseModel{
    
    public function validation(){
        $validation = new \Phalcon\Validation();
        $validation->add('description', new Validator\Uniqueness(array(
            'model'     => $this,
            'message'   => 'Your description already in use'
        )));
        return $this->validate($validation);
    }
}
