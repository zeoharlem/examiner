<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatricsController
 *
 * @author web
 */
use Phalcon\Mvc\View;

class MatricsController extends BaseController{
    public function initialize() {
        parent::initialize();
        \Phalcon\Tag::appendTitle('Matric Number Upload');
    }
    
    public function indexAction(){
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
    
    public function uploadAjaxAction(){
        $inputFileName = '';
        $inputFileType = 'Excel5';
	//$inputFileType = 'Excel2007';
        if($this->request->isPost()){
            if($this->request->hasFiles()){
                $file = $this->request->getUploadedFiles();
                $inputFileName = $file[0]->getTempName();
                //echo $file[0]->getExtension(); exit;
                if($file[0]->getExtension() != 'xls'){
                    $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
                    $this->flash->error('<strong>Excel Extension Not Supported</strong>');
                    $this->response->redirect('matrics/?type=false');
                    return false;
                }
            }

            //$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel    = $objReader->load($inputFileName);
            $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null);
            $resultExcel = new Results();
            //Set the Response Variable using HTTP type
            $response = new Phalcon\Http\Response();
            $return = $resultExcel->__excelPostArray($sheetData, 'matrics');
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $this->response->redirect('matrics/index?type='.$return);
        }
    }
}
