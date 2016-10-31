<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboadController
 *
 * @author web
 */
class DashboardController extends BaseController{
    
    public function initialize() {
        parent::initialize();
        \Phalcon\Tag::appendTitle('Admin');
    }
    
    public function indexAction(){
        Phalcon\Tag::appendTitle($this->session->get('auth')['firstname']);
    }
}
