<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseRegistration
 *
 * @author web
 */
class Courseregistration extends BaseModel{
    
    public function initialize(){
        $this->belongsTo(
                'matric',
                'Students',
                'matric',
                array(
                    'reusable'  => true
                )
        );
        $this->setSource('courseregistration');
    }
}
