<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Congregation
 *
 * @author KenOP
 */
use Phalcon\Validation\Validator;

class Congregation extends BaseModel{
    public function initialize(){
        $this->belongsTo(
                'congregation_id',
                'Courseregistration',
                'congregation_id',
                array(
                    'resusable' => true
                )
        );
    }
    
    public function validation(){
        $validator  = new \Phalcon\Validation();
        $validator->add('email', new Validator\Uniqueness(array(
            'model'     => $this,
            'message'   => 'Email already Existed'
        )));
        $validator->add('name', new Validator\Uniqueness(array(
            'model'     => $this,
            'message'   => 'Name already Existed'
        )));
        $validator->add('email', new Validator\Email(array(
            'model'     => $this,
            'message'   => 'Email is not a Valid one'
        )));
        
        return $this->validate($validator);
    }
}
