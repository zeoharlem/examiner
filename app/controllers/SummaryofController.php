<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SummaryofController
 *
 * @author WEB
 */
class SummaryofController extends BaseController{
    private $_flowStack;
    private $_classLevels = array(100,200,300,400);

    public function initialize() {
        parent::initialize();
        $this->_flowStack = array();
        \Phalcon\Tag::appendTitle('Summary Of Summary');
        $this->view->setVar('depts', Departments::find());
    }
    
    public function indexAction(){
        $this->view->setTemplateAfter('summaryof');
        return;
    }
    
    public function viewStackAction(){
        $this->__printViewCss();
        $level = $this->request->getPost('level');
        $newLevel = $this->__currSearchLevel($level);
        if($this->request->isPost()){
            $registered = $this->__viewStackFlow(false);
            $this->view->setVars(array(
                'summaryOf' => $this,
                'viewStack' => $registered, 'toLevel' => $level
            ));
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        return;
    }
    
    public function viewAction(){
        $this->__viewStackFlow();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        return;
    }
    
    /**
     * 
     * @param type $default
     * @return array
     * if $default is true the Method will return multi-dimensional array
     * else the method will return associative array grouped using matric numbers
     */
    private function __viewStackFlow($default=true){
        $stackFlow = array();
        $this->__printViewCss();
        if($this->request->isPost()){
            if(is_bool($default) && $default){
                $registered = Courseregistration::find(array(
                    //'order'         => "level ASC",
                    'group'         => "matric, level",
                    array(
                    'conditions'    => $this->__conditionsRemoveEmpty(),
                    'bind'          => $this->__bindAfterRemoveEmpty())
                    )
                );
                $gradePoints        = new GradePoints();
                foreach($registered as $keys => $values){
                    $scores = $this->__getResultTable($values->matric, $values->code);
                    $totalScores        = @$scores->ca + @$scores->exam;
                    $totalPackages[$values->matric][]    = array(
                        'totalGrades'       => $totalScores,
                        'othernames'        => $values->students->othernames,
                        'surname'           => $values->students->surname,
                        'sex'               => $values->students->sex,
                        'matric'            => $values->matric,
                        'codes'             => $values->code,
                        'level'             => $values->level,
                        'title'             => $values->title,
                        'units'             => $values->units
                    );

                }
            }
            else{
                $registered = Courseregistration::find(array(
                    'order'         => "level ASC",
                    'group'         => "matric",
                    array(
                    'conditions'    => $this->__conditionsRemoveEmpty(),
                    'bind'          => $this->__bindAfterRemoveEmpty())
                    )
                );
                $gradePoints        = new GradePoints();
                foreach($registered as $keys => $values){
                    $totalPackages[]    = array(
                        'othernames'    => $values->students->othernames,
                        'surname'       => $values->students->surname,
                        'sex'           => $values->students->sex,
                        'matric'        => $values->matric,
                    );

                }
            }
            
            $this->view->setVars(array(
                'gradePoints' => $totalPackages,
                'gradePointer'  => new GradePoints(),
                'registered' => $registered
                )
             );
            /*
             * Returns array which is either multidimensional or 
             * Associative depending on the default status set
             */
            return array(
                'registered'=>$registered,
                'totalPackage'=>$totalPackages
              );
        }
    }
    
    /**
     * @param String $matric
     * @param String $level
     * @return array
     */
    public function __setViewFlow($matric, $level=''){
        $pLev = $this->request->getPost('level');
        $level  = empty($level) ?  $pLev : $level;
        
        $builder = $this->modelsManager
                ->createBuilder()
                ->from('Courseregistration')
                ->where('matric="'.$matric.'"')
                ->andWhere('level <= "'.$level.'"')
                ->getQuery()
                ->execute();
        //Loop through the Builder Variable Results
        foreach($builder as $keys => $values){
            GradePoints::__setUnits($values->units);
            $scores = $this->__getResultTable($matric, $values->code);
            $totalScores    = (int) @$scores->ca + (int) @$scores->exam;
            GradePoints::__gradeParser($totalScores, $values->units, $values->code);
            $getStackFlow = array(
                'totalUnits'    => GradePoints::__getTotalUnits(),
                'totalGrade'    => GradePoints::__getTotalGrade(),
                'unitsPass'     => GradePoints::__getTotalUnitPass(),
                'unitsFail'     => GradePoints::__getTotalUnitFail(),
                'weightedAvr'   => GradePoints::__weightedGradeAvr(),
            );
        }
        //GradePoints::__clearSetArray();
        return $getStackFlow;
    }
    
    public function __setStackFlows($stackFlow,$key){
        $this->_flowStack[$key][] = $stackFlow;
    }
    
    public function __getStackFlows($key=''){
        return !empty($key) ? $this->_flowStack[$key] : $this->_flowStack;
    }
    
    public function __segregate($grade, $stackFlow, $remark='', $extra='',$extKey=''){
        if($grade >= GradePoints::FIRSTCLASS && empty($remark)){
            if(!empty($extra) && !empty($extKey)){
                $this->__setStackFlows($extra, $extKey);
            }
            $this->__setStackFlows($stackFlow, 'recommend');
        }
        if(!empty($remark) && !is_null($remark)){
            if(!empty($extra) && !empty($extKey)){
                $this->__setStackFlows($extra, $extKey);
            }
            $this->__setStackFlows($stackFlow, 'repeat');
        }
        if(empty($remark) || is_null($remark)){
            if(!empty($extra) && !empty($extKey)){
                $this->__setStackFlows($extra, $extKey);
            }
            $this->__setStackFlows($stackFlow, 'passed');
        }
        if($grade < GradePoints::FAILCLASS){
            if(!empty($extra) && !empty($extKey)){
                $this->__setStackFlows($extra, $extKey);
            }
            $this->__setStackFlows($stackFlow, 'probation');
        }
        if($grade < GradePoints::FAILCLASS){
            if(!empty($extra) && !empty($extKey)){
                $this->__setStackFlows($extra, $extKey);
            }
            $this->__setStackFlows($stackFlow, 'withdraw');
        }
    }
    
    public function __clearStorage(){
        $this->_flowStack = array();
    }
    
    public function __getCoursePackage(){
        $packages = array();
        if($this->request->isPost()){
            $packages = Packages::find(array(
                "conditions"    => $this->__bindAfterRemoveEmpty(),
                "bind"          => $this->__conditionsRemoveEmpty()
            ))->toArray();
        }
        foreach($packages as $keys => $values){
            $this->__fixTypeOfStatus($values['status'], $values['code']);
        }
        return $packages;
    }
    
    private function __fixTypeOfStatus($type, $values){
        switch (strtoupper($type)){
            case 'R':
                $this->__setStackFlows($values, 'required');
                break;
            case 'C':
                $this->__setStackFlows($values, 'cumpolsory');
                break;
            case 'E':
                $this->__setStackFlows($values, 'elective');
                break;
            default :
                $this->__setStackFlows($values, 'elective');
                break;
        }
        return $this->__getStackFlows();
    }
    
    private function __sortArrayMultiAssocDim($key){
        array_multisort($this->__getStackFlows($key), 1, $array1_sort_flags);
    }

    private function __currSearchLevel($level){
        $splitted = array_slice($this->_classLevels, 0, 
                array_search($level, $this->_classLevels)+1);
        return $splitted;
    }
    
    private function __getResultTable($matric='', $code=''){
        if((!empty($matric) && !empty($code)) || (!is_null($matric) && !is_null($code))){
            $resultsTable   = Results::find('course="'.$code.'" AND matric="'.$matric.'"')->getFirst();
            return $resultsTable;
        }
    }
    
    private function __printViewCss(){
        $this->assets->collection('prints')
                ->addCss('assets/bs3/css/bootstrap.min.css" rel="stylesheet"')
                ->addCss('assets/css/bootstrap-reset.css')
                ->addCss('assets/font-awesome-4.3.0/css/font-awesome.css')
                ->addCss('assets/css/style.css')
                ->addCss('assets/css/style-responsive.css');
                //->addCss('assets/css/invoice-print.css');
    }
}
