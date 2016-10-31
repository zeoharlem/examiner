<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departments
 *
 * @author web
 */
use Phalcon\Validation\Validator;

class Departments extends BaseModel{
    public $headofdepartment;
    
    public function beforeValidationOnCreate(){
        $lecturerDesc = new Lecturer();
        $hod = $this->getDI()->getRequest()->getPost('headofdepartment');
        $name = $lecturerDesc->findFirst(array('codename'=>$hod));
        $this->headofdepartment = $name->firstname.' '.$name->lastname;
        //var_dump($name); exit;
    }
    
    public function validation(){
        $validator  = new \Phalcon\Validation();
        $validator->add('description', new Validator\Uniqueness(array(
            'model'     => $this,
            'message'   => 'Your description already in use'
        )));
        return $this->validate($validator);
    }
}
