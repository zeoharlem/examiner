<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseRegistrationController
 *
 * @author web
 */
class CourseController extends BaseController{
    
    public function initialize() {
        parent::initialize();
        Phalcon\Tag::appendTitle('Courses');
        $this->view->setVars(array(
            'departments'   => Departments::find(),
            'codename'      => $this->component->helper->makeRandomInts(8),
            'lecturer'      => Lecturer::find()->toArray(),
            'faculty'       => Faculty::find()
        ));
        $this->assets->collection('headers')->addCss('assets/js/jquery-multi-select/css/multi-select.css');
        $this->assets->collection('headers')->addCss('assets/js/select2/select2.css');
        $this->assets->collection('footers')->addJs('assets/js/jquery-multi-select/js/jquery.multi-select.js');
        $this->assets->collection('footers')->addJs('assets/js/jquery-multi-select/js/jquery.quicksearch.js');
        $this->assets->collection('footers')->addJs('assets/js/select2/select2.js');
        $this->assets->collection('footers')->addJs('assets/js/select-init.js');
    }
    
    public function indexAction(){
        if($this->request->isPost()){
            $course = new Course();
            if($course->create($this->request->getPost())){
                $this->flash->success('<strong>Action Performed Successfully</strong>');
                return $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
            }
            else{
                $this->component->helper->getErrorMsgs($course,'course/');
            }
        }
        $this->view->setVars(array(
            'departments'   => Departments::find(),
            'codename'      => $this->component->helper->makeRandomInts(8)
        ));
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function departmentsAction(){
        if($this->request->isPost()){
            $departments = new Departments();
            if($departments->create($this->request->getPost())){
                $this->flash->success("<strong>".$this->request->getPost(
                        'department')." created</strong>");
            }
            else{
                $this->component->helper->getErrorMsgs($departments,'course/');
            }
        }
        $this->view->setVars(array('departments'   => Departments::find()));
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function facultyAction(){
        if($this->request->isPost()){
            $faculty = new Faculty();
            if($faculty->save($this->request->getPost())){
                $this->flash->success('<strong>Faculty Create Successfully</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                return true;
            }
            else{
                $this->component->helper->getErrorMsgs($faculty,'course/faculty');
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function programsAction(){
        $this->view->setVar('department',Departments::find());
        if($this->request->isPost()){
            $department = new Programs();
            if($department->save($this->request->getPost())){
                $this->flash->success('<strong>Program Created Successfully</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                return true;
            }
            else{
                $this->component->helper->getErrorMsgs($department, 'course/programs');
            }
        }
    }
    
    public function multipleTableAction(){
        if($this->request->isPost()){
            $course = new Course();
            $extra = 'codename="'.$this->component->helper->makeRandomInts(8).'"';
            $result = $course->__postMultiRaw($this->request->getPost(),'course');
            if($result != false){
                $this->flash->success('<strong>Courses Successfully Uploaded</strong>');
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                return true;
            }
            else{
                $this->component->helper->getErrorMsgs($course,'multipleTable');
                return false;
            }
        }
        $this->view->setVars(array(
            'codename'  => $this->component->helper->makeRandomInts(8)
        ));
    }
    
    public function showAction(){
        $this->__callBackJsCss();
        $this->view->allCourses = Course::find();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function departmentAction(){
        if($this->request->isPost()){
            $departments = new Departments();
            if($departments->create($this->request->getPost())){
                $this->flash->success("Department created successfully");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
            }
            else{
                $this->component->helper->getErrorMsgs($departments,'course/department');
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function editAction($package_id=''){
        if($this->request->isPost() && $this->request->isAjax()){
            $response = new Phalcon\Http\Response();
            $pack = Course::findFirstByC_id($this->request->getPost('c_id'));
            if($pack != false){
                $response->setHeader("Content-Type", "application/json");
                $response->setJsonContent(array(
                    'status'    => 'OK',
                    'data'      => array(
                        'title'         => ucwords($pack->title),
                        'code'          => $pack->code,
                        'department'    => $pack->department,
                        'level'         => $pack->level,
                        'session'       => $pack->session,
                        'status'        => $pack->status,
                        'semester'      => $pack->semester,
                        'c_id'          => $pack->c_id
                    )
                ));
            }
            else{
                $response->setHeader("Content-Type", "application/json");
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'message'   => $pack->getMessages()
                ));
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setRawHeader('HTTP/1.1 200 OK');
            $response->send();
        }
        else{
            $pack = Packages::findFirstByC_id(
                    $this->request->getQuery($package_id));
            if($pack != false){
                $this->view->setVar('showPackage', $pack);
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
    }
    
    
    public function deleteAction($creg_id=''){
        if($this->request->isAjax()){
            
            $cid = $this->request->getPost('c_id');
            $response = new Phalcon\Http\Response();
            $courseregs = Course::findFirstByC_id($cid);
            if($courseregs != false){
                if($courseregs->delete() != false){
                    $response->setJsonContent(array(
                        'status'    => 'OK',
                        'message'   => $courseregs->getMessages()
                    ));
                }
                else{
                    $response->setJsonContent(array(
                        'status'    => 'ERROR',
                        'message'   => $courseregs->getMessages()
                    ));
                }
                //Course registration delete using the c_id sent datatable
            }
            $response->setHeader("Content-Type", "application/json");
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setRawHeader('HTTP/1.1 200 OK');
            $response->send();
        }
    }
    
    public function editPostAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isPost() && $this->request->isAjax()){
            $findCourse = Course::findFirstByC_id($this->request->getPost('c_id'));
            if($findCourse != false){
                if($findCourse->update($this->request->getPost())){
                    $response->setJsonContent(array(
                        'status'    => 'OK',
                        'data'      => $findCourse->getMessages()
                    ));
                }
                else{
                    $response->setJsonContent(array(
                        'status'    => 'ERROR',
                        'data'      => $findCourse->getMessages()
                    ));
                }
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setHeader('Content-Type', 'application/json');
            $response->send();
        }
    }
    
    public function tableFlowAction(){
        //$this->__setJsonFlows();
        $builder = $this->modelsManager
                ->createBuilder()->columns(array(
                    'title','code','session','department','lecturer','c_id'
                ))->from('Course');
        $this->__dataTableFlow($builder);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    public function __callBackJsCss(){
        $this->assets->collection('headers')
                ->addCss('assets/js/data-tables/DT_bootstrap.css')
                ->addCss('assets/js/advanced-datatable/css/demo_table.css')
                ->addCss('assets/js/advanced-datatable/css/demo_table.css');
        $this->assets->collection('footers')
                ->addJs('assets/js/advanced-datatable/js/jquery.dataTables.js')
                ->addJs('assets/js/data-tables/DT_bootstrap.js')
                ->addJs('assets/js/bootbox.js')
                ->addJs('assets/js/dynamic_table_init.js');
    }
    
    private function __setJsonFlows(){
        $response = new Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/json");
        $response->setRawHeader("HTTP/1.1 200 OK");
    }
    
    protected function __dataTableFlow($builder){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            return $dataTables->fromBuilder($builder)->sendResponse();
        }
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
}
