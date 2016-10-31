<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResultsController
 *
 * @author web
 */
class ResultsController extends BaseController{
    private $_excelSingleResult, $_studentFlow, $_carryOver;
    
    public function initialize() {
        parent::initialize();
        $this->_carryOver = array();
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Departments::find())
        );
        $this->assets->collection('headers')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload.css')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload-ui.css');
        $this->assets->collection('footers')
                ->addJs('assets/js/file-uploader/js/jquery.fileupload-ui.js');
        $this->view->selectSession = $this->__selectSession();
    }
    
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
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
        $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel    = $objReader->load($inputFileName);
        $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null);
        $resultExcel = new Results();
        //Set the Response Variable using HTTP type
        $response = new Phalcon\Http\Response();
        $return = $resultExcel->__excelPostArray($sheetData, 'result');
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->setHeader('Content-Type', 'application/json');
        $response->setJsonContent(array('return' => $return));
        
        $response->sendHeaders();
        $response->send();
    }
    
    public function showAction(){
        if($this->request->isPost()){
            $packages = Packages::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ));
            if($packages != false){
                $this->view->setVar('packs', $packages);
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
        }
    }
    
    public function viewAllLevelAction(){
        //Remove empty or _url on get Query
        $this->__getPostRemoveEmpty();
        
        if($this->request->getQuery('matric')){
            $matric = $this->request->getQuery('matric');
            $getDetails = Courseregistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty('get'),
                "bind"          => $this->__bindAfterRemoveEmpty('get'),
                "order"         => "level ASC",
            ));
            //Get Carry over Registration by Students
            $carryOvers = Carryover::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty('get'),
                "bind"          => $this->__bindAfterRemoveEmpty('get')
            ));
            if($carryOvers != false){
                foreach($carryOvers as $indexs => $elements){
                    //Results of carry over courses registered
                    $carryResult = Resultcarry::findFirst(array(
                        'matric="'.$elements->matric.'" AND course="'.$elements->code.'"'
                    ));
                    $carryCa    = $carryResult != false ? $carryResult->ca : 0;
                    $carryScore = $carryResult != false ? $carryResult->exam : 0;
                    $stackFlowCO[] = array(
                        'title'     => $elements->title,
                        'code'      => $elements->code,
                        'lecturer'  => $elements->lecturer,
                        'session'   => $elements->session,
                        'matric'    => $elements->matric,
                        'level'     => $elements->level,
                        'units'     => GradePoints::__setUnits($elements->units),
                        'grade'     => GradePoints::__gradeParser(
                                       (int)$carryScore+$carryCa, $elements->units, $elements->code),
                        'caCO'      => $carryCa,
                        'scoreCO'   => $carryScore
                    );
                    $remarks = GradePoints::__resetRemark(
                            $elements->code, (int)$carryScore+$carryCa);
                    
                    $this->view->setVars(array(
                        'stackFlowCO'   => $stackFlowCO,
                        'remarks'       => GradePoints::__getRemarks(),
                    ));
                }
            }
            //Normal Course Registered
            if($getDetails != false){
                $studentFlow = Students::findFirstByMatric(
                        $this->request->getQuery('matric'));
                
                foreach($getDetails as $keys => $values){
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));
                    //Set the units of the courses registered
                    GradePoints::__setUnits($values->units);
                    
                    //Add the continuos asseemesnts and examscore
                    $totalScore = $result->ca + $result->exam;
                    $totalView[] = array(
                        'matric'    => $values->matric,
                        'code'      => $values->code,
                        'title'     => $values->title,
                        'session'   => $values->session,
                        'units'     => $values->units,
                        'level'     => $values->level,
                        'status'    => $values->status,
                        'ca'        => $result->ca,
                        'exam'      => $result->exam,
                        'totalScore'=> $totalScore,
                        'gradePoint'=> GradePoints::__gradeParser(
                                $totalScore, $values->units, $values->code),
                    );
                }
                $this->_excelSingleResult = $stackFlow;
                $setRemarks = $carryOvers ? $remarks : GradePoints::__getRemarks();
                $this->view->setVars(array(
                    'results'       => $totalView,
                    'studentFlow'   => $studentFlow,
                    'remarks'       => $setRemarks,
                    'totalGrade'    => GradePoints::__getTotalGrade(),
                    'weightedAvr'   => GradePoints::__weightedGradeAvr(),
                    'totalUnitP'    => GradePoints::__getTotalUnitPass(),
                    'totalUnitF'    => GradePoints::__getTotalUnitFail(),
                    'totalUnits'    => GradePoints::__getTotalUnits()
                ));
            }
        }
        else{
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $this->response->redirect('results/viewForm');
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function viewRegsAction(){
        $listView = $this->modelsManager->createBuilder()
                ->from('Courseregistration')
                ->where('Courseregistration.department="'.$this->request->getQuery('department').'"')
                ->andWhere('Courseregistration.session="'.$this->request->getQuery('session').'"')
                ->andWhere('Courseregistration.code="'.$this->request->getQuery('code').'"')
                ->orderBy('Courseregistration.c_id')->getQuery()->execute();
        //var_dump($listView); exit;
        if($listView != false){
            foreach($listView as $keys => $values){
                $full = Students::findFirstByMatric($values->matric);
                $result = Results::findFirst(array(
                    'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                ));
                
                $cassess = $result != false ? $result->ca : 0;
                $scores  = $result != false ? $result->exam : 0;
                
                $listViewArrays[] = array(
                    'fullname'  => $full->othernames.' '.$full->surname,
                    'matric'    => $values->matric,
                    'department'=> $values->department,
                    'codename'  => $full->codename,
                    'creg_id'   => $values->creg_id,
                    'title'     => $values->title,
                    'course'    => $values->code,
                    'ca'        => $cassess,
                    'exam'      => $scores
                );
            }
            $this->view->setVar('listView', $listViewArrays);
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
    }
    
    public function postAction(){
        if($this->request->isPost()){
            $results = new Results();
            if($results->__postRawSQLTask($this->request->getPost(),
                    'result', '', BaseModel::MODEL_REPLACE)){
                $this->flash->success($this->request->getPost('course')[0]."'s Uploaded");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
            else{
                $this->flash->error($results->getMessages()->getMessage());
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
        }
    }
    
    public function viewFormAction(){
        if($this->request->isPost()){
            $rows = '';
            $this->__getPostRemoveEmpty();
            //var_dump($this->__bindAfterRemoveEmpty()); exit;
            $registered = CourseRegistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty(),
                "group"         => "matric"
            ));
            if($registered != false){
                foreach($registered as $keys => $values){
                    $student = Students::find('matric="'.$values->matric.'"')->getFirst();
                    $comArray[] = array(
                        'fullname'  => $student->surname.' '.$student->othernames,
                        'matric'    => $values->matric,
                        'session'   => $values->session,
                        'department'=> $values->department,
                        'email'     => $student->email,
                        'phone'     => $student->phone
                    );
                }
                $this->view->setVars(array(
                    'comArray'  => $comArray,
                    'formString'=> http_build_query($this->request->getPost())
                ));
            }
            else{
                $this->flash->error("<strong>No Registered Students Now!</strong>");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function viewAction(){
        $this->__viewStackFlow();
        $url = $this->request->getQuery();
        unset($url['_url']); unset($url['semester']);
        $urlTask = http_build_query($url);
        $this->view->setVars(array('urlTask'=>$urlTask));
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    /**
     * Creating excel sheet Dynamically
     */
    //Array value should be preformatted for brevity
    public function createSinglePersonExcelSheetAction(array $array = NULL){
        $this->__viewStackFlow();
        
        $styleArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );

        $styleArray2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
         );
        
        $objectPHPExcel = $this->getDI()->get('PHPExcel');
        
        $objectPHPExcel->getDefaultStyle()->applyFromArray($styleArray2);
        
        $objectPHPExcel->getProperties()->setCreator("Examiner")
                ->setLastModifiedBy("Examiner")->setTitle("Student Transcript")
                ->setSubject("Student Transcript")->setKeywords("office 2007 openxml php")
                ->setCategory("Result Sheet");
        
        //PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        $objectPHPExcel->getActiveSheet()->mergeCells('A1:Z1');
        $objectPHPExcel->getActiveSheet()->mergeCells('A2:Z2');
        $objectPHPExcel->getActiveSheet()->mergeCells('A3:Z3');
        $objectPHPExcel->getActiveSheet()->mergeCells('A4:Z4');
        
        foreach(range('A','Z') as $column_id){
            $objectPHPExcel->getActiveSheet()->getColumnDimension($column_id)->setAutoSize(true);
        }
        
        $objectPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);
        
        $objectPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        
        //Get students Programs, Department and Faculty details
        if($this->_studentFlow != false){
            $programFlow = Programs::findFirstByPrograms_id($this->_studentFlow->programs_id);
        }
        else{
            echo 'Student Looks Like Not registered. Kindly check Registration details';
            exit;
        }
        $objectPHPExcel->setActiveSheetIndex(0);
        $objectPHPExcel->getActiveSheet()
                ->setCellValue('A1','OLABISI ONABANJO UNIVERSITY AGO-IWOYE')
                ->setCellValue('A2', 'DEPARTMENT OF '.strtoupper($this->_studentFlow->department)
                        .'('.strtoupper($programFlow->description).')')
                ->setCellValue('A3','TRANSCRIPT');
        
        $objectPHPExcel->getActiveSheet()->setCellValue('A5','Matric NO:')
                ->setCellValue('B5',$this->_studentFlow->matric)->setCellValue('A6','Student Names:')
                ->setCellValue('B6',strtoupper($this->_studentFlow->surname.' '.$this->_studentFlow->othernames))
                ->setCellValue('A7', 'Year of Entry:')->setCellValue('B7', $this->_studentFlow->entry)
                ->setCellValue('A8', 'Mode of Entry:')->setCellValue('B8', $this->_studentFlow->mode);
        
        $objectPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);
        
        $objectPHPExcel->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objectPHPExcel->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        
        $objectPHPExcel->getActiveSheet()->getStyle('A11:J11')->getFont()->setBold(true);
        
        $objectPHPExcel->getActiveSheet()->mergeCells('A10:Z10');
        $objectPHPExcel->getActiveSheet()->setCellValue('A10','Any Alteration Noticed on the Marks Makes Document Invalid');
        $objectPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setSize(10);
        $objectPHPExcel->getActiveSheet()->setCellValue('A11','Course Code');
        $objectPHPExcel->getActiveSheet()->setCellValue('B11','Course Title');
        $objectPHPExcel->getActiveSheet()->setCellValue('C11','Unit');
        $objectPHPExcel->getActiveSheet()->setCellValue('D11','Semester');
        $objectPHPExcel->getActiveSheet()->setCellValue('E11','Session');
        $objectPHPExcel->getActiveSheet()->setCellValue('F11','Level');
        $objectPHPExcel->getActiveSheet()->setCellValue('G11','Status');
        $objectPHPExcel->getActiveSheet()->setCellValue('H11','Score');
        $objectPHPExcel->getActiveSheet()->setCellValue('I11','Grade');
        $objectPHPExcel->getActiveSheet()->setCellValue('J11','Remark');
        
        $counter = 12;
        $rangers = $this->__charIncStart('A','Z');
        foreach($this->_excelSingleResult as $keys => $values){
            $semester = $values['semester'] == 1 ? 'Harmattan' : 'Rain';
            $remarkFlow = ($values['score'] + $values['ca']) > GradePoints::DEFAULT_LIMIT ? 'PASSED' : 'FAILED';
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[0].$counter, strtoupper($values['code']));
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[1].$counter, ucwords($values['title']));
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[2].$counter, $values['units']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[3].$counter, $semester);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[4].$counter, $values['session']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[5].$counter, $values['level']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[6].$counter, $values['status']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[7].$counter, $values['score'] + $values['ca']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[8].$counter, $values['grade'] * $values['units']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[9].$counter, $remarkFlow);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.$counter.':J'.$counter)->getFont()->setSize(10);
            $objectPHPExcel->getActiveSheet()->getStyle('D'.$counter.':G'.$counter)->applyFromArray($styleArray);
            $counter++;
        }
        
        $highestCol = $objectPHPExcel->getActiveSheet()->getHighestRow() + 2;
        
        if(!empty($this->_carryOver) || !is_null($this->_carryOver)){
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Carry Overs');
            foreach($this->_carryOver as $keys => $values){
                $int = $highestCol+$keys+1;
                $remarkFlow = ($values['scoreCO'] + $values['caCO']) > GradePoints::DEFAULT_LIMIT ? 'PASSED' : 'FAILED';
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[0].$int, strtoupper($values['code']));
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[1].$int, ucwords($values['title']));
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[2].$int, $values['units']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[3].$int, $semester);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[4].$int, $values['session']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[5].$int, $values['level']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[6].$int, $values['status']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[7].$int, $values['scoreCO'] + $values['caCO']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[8].$int, $values['grade'] * $values['units']);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[9].$int, $remarkFlow);
                $objectPHPExcel->getActiveSheet()->getStyle('A'.$int.':J'.$int)->getFont()->setSize(10);
            }
        }
        
        $highestCol = $objectPHPExcel->getActiveSheet()->getHighestRow() + 2;
        //Setting the last floor variables 
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Units Taken');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalUnits());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Units Passed');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalUnitPass());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Units Failed');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalUnitFail());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'WPG');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalGrade());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'CGPA');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__weightedGradeAvr());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        
        //Creating the file with the write method
        $objectWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objectWriter->save('../excel_sheet/'.$this->__strReplace($this->request->getQuery('matric')).'_'.
                $this->request->getQuery('level').'.xls');
        $filePath    = '../excel_sheet/'.  $this->__strReplace($this->request->getQuery('matric')).'_'.
                $this->request->getQuery('level').'.xls';
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"".basename($filePath)."\"");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        ob_clean(); flush(); 
        readfile($filePath);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    //Replace the stroke for dash
    private function __strReplace($subject){
        return str_replace('/', '_', $subject);
    }
    
    //Method was refactored for excel
    private function __viewStackFlow(){
        $studentFlow = ''; $remarks = '';
        $stackFlow = array(); $stackFlowCO = array();
        
        if($this->request->isGet()){
            $this->__getPostRemoveEmpty();
            
            $getQuery = $this->request->getQuery();
            if(array_key_exists('_url', $getQuery)){
                array_shift($getQuery);
            }
            $result = $this->__getArrayCon($getQuery);
            //Get Normal COurse Registration bby Students
            $registered = Courseregistration::find(array(
                "conditions"    => $result[1],
                "bind"          => $result[0]
            ));
            //Get Carry over Registration by Students
            $carryOvers = Carryover::find(array(
                "conditions"    => $result[1],
                "bind"          => $result[0]
            ));
            if($carryOvers != false){
                foreach($carryOvers as $indexs => $elements){
                    //Results of carry over courses registered
                    $carryResult = Resultcarry::findFirst(array(
                        'matric="'.$elements->matric.'" AND course="'.$elements->code.'"'
                    ));
                    $carryCa    = $carryResult != false ? $carryResult->ca : 0;
                    $carryScore = $carryResult != false ? $carryResult->exam : 0;
                    $stackFlowCO[] = array(
                        'title'     => $elements->title,
                        'code'      => $elements->code,
                        'lecturer'  => $elements->lecturer,
                        'session'   => $elements->session,
                        'status'    => $elements->status,
                        'semester'  => $elements->semester,
                        'matric'    => $elements->matric,
                        'level'     => $elements->level,
                        'units'     => GradePoints::__setUnits($elements->units),
                        'grade'     => GradePoints::__gradeParser(
                                       (int)$carryScore+$carryCa, $elements->units, $elements->code),
                        'caCO'      => $carryCa,
                        'scoreCO'   => $carryScore
                    );
                    $this->_carryOver = $stackFlowCO;
                    //Reset the remarks if found that the course has been done and passed
                    $remarks = GradePoints::__resetRemark(
                            $elements->code, (int)$carryScore+$carryCa);
                    
                    $this->view->setVars(array(
                        'stackFlowCO'   => $stackFlowCO,
                        'remarks'       => GradePoints::__getRemarks(),
                    ));
                }
            }
            
            if($registered != false){
                
                $student = Students::findFirstByMatric(
                        $this->request->getQuery('matric'));
                //Store student details for class use
                $this->_studentFlow = $student;
                
                foreach($registered as $keys => $values){
                    //Result of normal course Registration
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));
                    $cassess    = $result != false ? $result->ca : 0;
                    $scores     = $result != false ? $result->exam : 0;
                    $stackFlow[] = array(
                        'title'     => $values->title,
                        'code'      => $values->code,
                        'lecturer'  => $values->lecturer,
                        'session'   => $values->session,
                        'semester'  => $values->semester,
                        'matric'    => $values->matric,
                        'level'     => $values->level,
                        'status'    => $values->status,
                        'units'     => GradePoints::__setUnits($values->units),
                        'grade'     => GradePoints::__gradeParser(
                                       (int)$scores+$cassess, $values->units, $values->code),
                        'ca'        => $cassess,
                        'score'     => $scores,
                    );
                }
                $this->_excelSingleResult = $stackFlow;
                $setRemarks = $carryOvers ? $remarks : GradePoints::__getRemarks();
                $this->view->setVars(array(
                    'stackFlow'     => $stackFlow,
                    'studentFlow'   => $student,
                    'remarks'       => $setRemarks,
                    'totalUnits'    => GradePoints::__getTotalUnits(),
                    'totalGrade'    => GradePoints::__getTotalGrade(),
                    'totalUnitP'    => GradePoints::__getTotalUnitPass(),
                    'totalUnitF'    => GradePoints::__getTotalUnitFail(),
                    'weightedAvr'   => GradePoints::__weightedGradeAvr()
                ));
            }
            else{
                $this->flash->error("<strong>Student have not Registered</strong>");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
        }
    }
    
    //Get Array Conditions to replace post or get Query
    //Note that the index 0 returned is array and 1 is strings
    //Use like this $getWhatever = $this->__getArrayCon($array);
    protected function __getArrayCon(array $array){
        $strings = '';
        $results = array();
        foreach($array as $key => $value){
            $results[$key] = $value;
            $strings .= $key.' = :'.$key.': AND ';
        }
        return array(
            $results, substr($strings,0,-4)
        );
    }
    
    //Remove empty getPost() | getQuery() request
    protected function __getPostRemoveEmpty(){
        if($this->request->isPost()){
            foreach($this->request->getPost() as $key => $value){
                if(empty($value) || is_null($value)){
                    unset($_POST[$key]);
                }
            }
        }
        else{
            foreach($this->request->getQuery() as $key => $value){
                if(empty($value) || is_null($value)){
                    unset($_GET[$key]);
                }
            }
        }
    }
    
    //This method create a binding value based
    //Empty post remooved from the getPost() returned
    protected function __bindAfterRemoveEmpty($type='post'){
        $results = array();
        switch ($type) {
            case 'post':
                foreach($this->request->getPost() as $key => $value){
                    $results[$key] = $value;
                }
                return $results;
                break;
                
            case 'get':
                foreach($this->request->getQuery() as $key => $value){
                    if($key !== '_url'){
                        $results[$key] = $value;
                    }
                }
                return $results;
                break;
        }
    }
    
    //This method creates queries of values for binding
    protected function __conditionsRemoveEmpty($type='post'){
        $strings = '';
        switch ($type) {
            case 'post':
                foreach($this->request->getPost() as $key => $value){
                    $strings .= $key.' = :'.$key.': AND ';
                }
                return substr($strings,0,-4);
                break;
                
            case 'get':
                foreach($this->request->getQuery() as $key => $value){
                    if($key !== '_url'){
                        $strings .= $key.' = :'.$key.': AND ';
                    }
                }
                return substr($strings,0,-4);
                break;
        }
    }
    
    //Built for the purpose of excel library cells
    public function __charIncStart($current='A', $stop='ZZZ'){
        $array = array($current);
        while($current != $stop){
            $array[] = ++$current;
        }
        return $array;
    }
}
