<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentsController
 *
 * @author webadmin
 */
class StudentsController extends BaseController{
    private $_students, $_builder;
    
    public function initialize() {
        parent::initialize();
        Phalcon\Tag::appendTitle("Students");
        $this->_students = Students::find();
        $this->_builder = new \Phalcon\Mvc\Model\Query();
        $this->__dataTableJsCss();
    }
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function registerAction(){
        if($this->request->isPost()){
            $students = new Students();
            $results = $students->create($this->request->getPost());
            if($results != false){
                $this->flash->success('<strong>Registration Completed</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                return true;
            }
            else{
                $this->component->helper->getErrorMsgs($students,'students/register');
            }
        }
    }
    
    public function blockAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isAjax() && $this->request->isPost()){
            $matric = $this->request->getPost('matric');
            $student = Students::findFirstByMatric($matric);
            if($student != false){
                if($student->update(array('role'=>'guest')) != false){
                    $response->setRawHeader("HTTP/1.1 200 OK");
                    $response->setJsonContent(array(
                        'blocked'   => true,
                    ));
                }
            }
            else{
                $response->setRawHeader("HTTP/1.1 304 NOT FOUND");
                $response->setJsonContent(array(
                    'blocked'   => false,
                ));
            }
            $response->setHeader('Content-Type', 'application/json');
            $response->send();
        }
    }
    
    public function deleteAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isAjax() && $this->request->isPost()){
            $matric = $this->request->getPost('matric');
            $student = Students::findFirstByMatric($matric);
            if($student){
                if($student->delete() != false){
                    $response->setRawHeader("HTTP/1.1 200 OK");
                    $response->setJsonContent(array(
                        'status'    => 'OK'
                    ));
                }
            }
            else{
                $response->setRawHeader("HTTP/1.1 304 NOT FOUND");
                $response->setJsonContent(array(
                    'status'    => 'ERROR'
                ));
            }
            $response->setHeader('Content-Type', 'application/json');
            $response->send();
        }
    }
    
    public function getStudentsAction(){
        $builder = $this->modelsManager
                ->createBuilder()->columns(array(
                    'othernames','surname','phone','email','matric','department'
                ))->from('Students');
        $this->__dataTableFlow($builder);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    protected function __dataTableFlow($builder){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            return $dataTables->fromBuilder($builder)->sendResponse();
        }
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
}
