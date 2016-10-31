<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CarryoverController
 *
 * @author web
 */
use Phalcon\Mvc\View;

class CarryoverController extends BaseController{
    
    public function initialize(){
        parent::initialize();
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Departments::find())
        );
        $this->assets->collection('headers')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload.css')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload-ui.css');
    }
    
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function ajaxCOAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isPost() && $this->request->isAjax()){
            $carryOvers     = new Carryover();
            $carryScores    = $this->request->getPost();
            if($carryOvers->__replaceMultiRaw($carryScores, 'resultcarry')){
                $response->setJsonContent(array('status' => 'OK'));
                $response->setRawHeader("HTTP/1.1 200 OK");
            }
        }
        $response->setHeader('Content-Type', 'application/json');
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        $response->send();
    }
    
    public function uploadAjaxAction(){
        $inputFileName = '';
        //$inputFileType = 'Excel5';
	$inputFileType = 'Excel2007';
        if($this->request->hasFiles()){
            $file = $this->request->getUploadedFiles();
            $inputFileName = $file[0]->getTempName();
        }
        
        //$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null);
        
        //Check whether processing should be ajax or normal post
        
        $resultExcel = new Resultcarry();
        //Set the Response Variable using HTTP type
        $response = new Phalcon\Http\Response();
        $return = $resultExcel->__excelPostArray($sheetData, 'resultcarry');
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->setHeader('Content-Type', 'application/json');
        $response->setJsonContent(array('return' => $return));
        
        $response->sendHeaders();
        $response->send();
    }
    
    public function getCarryOverAction(){
        $this->__dataTableJsCss();
        if($this->request->isPost()){
            $carryOver = Carryover::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ));
            if($carryOver != false){
                foreach($carryOver as $keys => $values){
                    $student = Students::findFirstByMatric($values->matric);
                    $results = Resultcarry::findFirst(
                            'matric="'.$values->matric.
                            '" AND course="'.$values->code.'"');
                    
                    $carrs[] = array(
                        'fullname'  => $student->surname.' '.$student->othernames,
                        'matric'    => $values->matric,
                        'department'=> $values->department,
                        'course'    => $values->code,
                        'session'   => $values->session,
                        'creg_id'   => $values->creg_id,
                        'ca'        => $results->ca,
                        'exam'      => $results->exam
                    );
                }
                $this->view->setVars(array('carryovers' => $carrs));
            }
            $this->view->setRenderLevel(View::LEVEL_AFTER_TEMPLATE);
        }
    }
    
    public function downloadAction(){
        $totalRegister = array();
        if($this->request->isPost()){
            $this->__getPostRemoveEmpty();
            $coureregistered = Carryover::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ))->toArray();
    
            if($coureregistered != false){
                foreach($coureregistered as $keys => $values){
                    $results = Resultcarry::find(array('matric="'.$values['matric'].
                        '" AND course="'.$values['code'].'"'))->toArray();

                    //Set default scores and cas if found in the database to excel
                    $scores  = $results != false ? $results[0]['exam'] : 0;
                    $cassess = $results != false ? $results[0]['ca'] : 0;

                    $totalRegister[] = array(
                        'matric'    => $values['matric'],
                        'course'    => $values['code'],
                        'ca'        => $cassess,
                        'exam'      => $scores,
                        'creg_id'   => $values['creg_id'],
                        'title'     => $values['title']
                    );
                }
                
                $this->__getRegisteredExcel($totalRegister);
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
                return true;
            }
            else{
                $this->flash->error('<strong>No Registration Found</strong>');
                //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
                $this->view->disableLevel(array(View::LEVEL_LAYOUT => true));
                $this->view->setTemplateAfter('carryovercourse');
                return false;
            }
        }
        $this->view->setTemplateAfter('carryovercourse');
        $this->view->disableLevel(array(View::LEVEL_LAYOUT => true));
    }
    
    private function __getRegisteredExcel(array $courseRegister){
        $writerType = 'Excel2007';
        $response = new Phalcon\Http\Response();
        $objectPHPExcel = $this->getDI()->get('PHPExcel');
        $styleArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );

        $styleArray2 = array(
            'borders'   => array(
                'allborders' => array(
                    'style'     => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );
        $counter = 2;
        //Start the creation and the format of the excel file
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        
        $objectPHPExcel->getDefaultStyle()->applyFromArray($styleArray2);
        
        $objectPHPExcel->getProperties()->setCreator("Examiner")->setLastModifiedBy("Examiner")
                ->setKeywords("office 2007 openxml php")->setCategory("Result Sheet")
                ->setTitle("Student Transcript")->setSubject("Student Transcript");
        
        $objectPHPExcel->setActiveSheetIndex(0);
        
        $objectPHPExcel->getActiveSheet()->setCellValue('A1','matric')->setCellValue('B1','course')
                ->setCellValue('C1','ca')->setCellValue('D1','exam')->setCellValue('E1','creg_id');
        
        foreach($courseRegister as $keys => $values){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.$counter, $values['matric']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.$counter, $values['course']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.$counter, $values['ca']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.$counter, $values['exam']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.$counter, $values['creg_id']);
            $counter++;
        }
        $text = $courseRegister[0]['course'].'_'.$courseRegister[0]['title'];
        
        $fileNew     = preg_replace('#[ -]+#', '-', $text);
        $filePath    = '../excel_sheet/carryover_'.$fileNew.'.xls';
        
        $objectWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, $writerType);
        $objectWriter->save($filePath);
        
        $this->__setHeaderNotify($filePath);
        ob_clean(); flush(); 
        readfile($filePath);
    }
    
    /**
     * Set Header to be sent to the browser
     * @param type $filePath
     */
    private function __setHeaderNotify($filePath){
        $response = new Phalcon\Http\Response();
        //$response->setHeader('Content-Type','application/vnd.ms-excel');
        $response->setHeader('Content-Type','application/octet-stream');
        $response->setHeader("Content-Disposition","attachment;filename=".basename($filePath));
        
        // If you're serving to IE over SSL, then the following may be needed
        $response->setHeader('Expires','Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        $response->setHeader('Last-Modified',gmdate('D, d M Y H:i:s').' GMT'); // always modified
        $response->setHeader('Cache-Control','cache, must-revalidate'); // HTTP/1.1
        $response->setHeader('Content-Length', filesize($filePath));
        $response->setHeader('Pragma','public'); // HTTP/1.0
        $response->sendHeaders();
    }
}
