<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogoutController
 *
 * @author Theophilus Alamu <theophilus.alamu at gmail.com>
 */
class LogoutController extends BaseController{
    
    public function initialize(){
        parent::initialize();
    }
    
    //put your code here
    public function indexAction() {
        $this->session->destroy();
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->redirect('index/?logout=true');
    }
}
