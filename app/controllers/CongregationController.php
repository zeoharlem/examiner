<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CongregationController
 *
 * @author KenOP
 */
class CongregationController extends BaseController{
    public function initialize() {
        parent::initialize();
        Phalcon\Tag::appendTitle("Congregation");
    }
    
    public function indexAction(){
        $this->__getCongregation();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function createAction(){
        if($this->request->isPost()){
            $congregation   = new Congregation();
            if($congregation->create($this->request->getPost())){
                $this->flash->success('<strong>Task Done</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
                $this->response->redirect('congregation/?task=true');
            }
            else{
                $this->component->helper->getErrorMsgs($congregation,'congregation/');
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->redirect('congregation/task=false');
    }
    
    public function __getCongregation(){
        $congregation = Congregation::find()->toArray();
        $this->view->setVars(array('congregation' => $congregation));
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function getCongregationByIdAction($id){
        if($this->request->isPost()){
            $this->view->setVars(array(
                'congList'  => Courseregistration::find(array(
                    'conditions'    => $this->__conditionsRemoveEmpty(),
                    'bind'          => $this->__bindAfterRemoveEmpty()
                ))->toArray()
            ));
        }
        else{
            $this->view->setVars(array(
                'congList'  => Students::find('congregation='.$id)
            ));
        }
    }
    
    private function __registerShowCong($getPost){
        
    }
}
