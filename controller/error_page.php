<?php

class Error_page Extends MainController{
    
    function __construct($title = 'Error',$msg = 'Unknown Error'){
        parent::__construct();
        $data = array( 'msg' => $msg );
        $this->view->show('error',$data);
    }
    
}