<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneratematricController
 *
 * @author Theophilus Alamu <theophilus.alamu at gmail.com>
 */
class GeneratematricController extends BaseController{
    //put your code here
    public function initialize() {
        parent::initialize();
        \Phalcon\Tag::appendTitle('Generate Matric Number');
    }
    
    public function indexAction(){
        $counter    = 729;
        $stringFlow = array(); $stringFlowNum = array();
        
        if($this->request->isPost() && $this->request->hasFiles()){
            $getUploaded    = $this->request->getUploadedFiles();
            $getRealType    = $getUploaded[0]->getRealType();
            if($getRealType != 'text/plain' || $getRealType != 'text/*'){
                $textReturn = $this->__getFileStackFlow($getUploaded[0]->getTempName());
                sort($textReturn);
                foreach($textReturn as $keys => $values){
                    if(!empty($values) && !is_null($values)){
                        $stringFlowNum[]= array('number' => $counter);
                        $stringFlow[]   = array('names'  => $values);
                        $counter++;
                    }
                }
            }
            $this->view->setVars(array(
                'names' => $stringFlow, 'number' => $stringFlowNum));
        }
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        return;
    }
    
    public function setMatricNumberAction(){
        if($this->request->isPost()){
            
        }
    }
    
    private function __getFileStackFlow($filename){
        $newString  = array();
        $handler    = fopen($filename, 'r');
        if($handler){
            while(($line = fgets($handler)) !== false){
                $newString[]    = trim(strtolower($line));
            }
            fclose($handler);
        }
        return $newString;
    }
}
