<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Results
 *
 * @author web
 */
class Results extends BaseModel{
    public function initialize(){
        $this->setSource('result');
        $this->belongsTo(
                'creg_id',
                'Courseregistration','Creg_id',
                array(
                    'reusable'  => true
                )
        );
    }
    
    public function getExcelFileUpload($file){
        $count = 0;
        $_fileRead = fopen($file, 'r');
        while(($readLines = fgetcsv($_fileRead))){
            
        }
    }
}
