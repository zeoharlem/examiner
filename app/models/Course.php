<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Course
 *
 * @author web
 */
use Phalcon\Validation\Validator;

class Course extends BaseModel{
    public function initialize(){
        //$this->skipAttributesOnUpdate($attributes);
        if(method_exists($this, 'allowEmptyStringValues')){
            $this->allowEmptyStringValues(array(
                'lecturer', 'lectcode'
            ));
        }
    }
    
    public function beforeValidationOnCreate(){
        $this->skipAttributesOnCreate(array(
            'lecturer', 'lectcode'
        ));
    }
    
    public function validation(){
        $validator  = new \Phalcon\Validation();
        $validator->add('code', new Validator\Uniqueness(array(
            'model'     => $this,
            'message'   => 'Code already in use'
        )));
        return $this->validate($validator);
    }
}
