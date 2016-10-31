<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author web
 */
class IndexController extends BaseController{
    private $_registerUser, $_admin;
    
    public function initialize(){
        parent::initialize();
    }
    
    public function indexAction(){
        if($this->request->isPost()){
            $users = Admin::findFirst(array(
                "username = :username: AND password = :password:",
                'bind'  => array(
                    'username'  => $this->request->getPost('username'),
                    'password'  => $this->request->getPost('password')
                ))
            );
            if($users){
                $this->__registerAdmin($users);
                
                //create logs for the user that logged in
                LoggersPlugin::getLoggerInst()->setLogFile($users->username);
                //Assign a name to the users log files details
                LoggersPlugin::getLoggerInst()->getLogger()->info(
                            $users->username.' Logged Into Backend Application');
                
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
                $this->flash->success('<strong>Welcome '.ucwords($users->username).'</strong>');
                $this->response->redirect('dashboard/?tok='.$this->component->helper->makeRandomString(15));
            }
            else{
                //$this->component->helper->getErrorMsgs($users, 'index');
                $this->flash->error('<strong>Not a valid user</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function logOutAction(){
        $this->session->destroy();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->redirect('index/?logout=true');
    }
    
    public function removeKey($key){
        $this->session->remove($key);
    }
    
    public function show404(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        return;
    }
    
    public function show409(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        return;
    }
    
    private function __checkUserLogin($post){
        $register = Students::findFirstByMatric($post->getPost('username'));
        if($register){
            if($this->security->checkHash($post->getPost('password'), 
                    $register->password)){
                $this->__registerAdmin($register);
                return true;
            }
            else{
                return false;
            }
        }
        return $register;
    }
    
    private function __registerAdmin(Admin $admin){
        $this->session->set('auth', array('admin_id'=>$admin->admin_id,
            'codename'=>$admin->codename,'privy'=>$admin->privy,
            'username'=>$admin->username,'role'=>$admin->role));
    }
}
