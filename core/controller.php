<?php

/**
 *                FH Base System
 *           http://www.fajryhamzah.com
 *
 * MainController is the parent of all the controllers,
 * all of the controller created must extend this class
 * to use the rest of the system function such as communicating
 * with the views and models.
 *
 * @since 0.1
 **/

class MainController{

    private $params = array();
    private $libspath = "libs/";
    private $modelspath = "models/";

    //Initialize object view and models when the main controller being extended
    function __construct(){
        global $config;

       //set error
       error_reporting(get_config("error_level"));




       //Creating object view
       $this->view = New View();


    }


    //to set parameter for the controller
    public function set_param($param){
        $this->params = $param;
    }

    /**
     * Get the parameter value from url
     *
     * @since 0.1
     * @param integer $key the order of parameter from url(Separated with "/")
     * @param integer $error an error report
     * @return string return value of the param or null string
     **/
    public function get_param($key,$error=1){
        global $config;

        if(count($this->params)-1 < $key){    //handling error if using key largest or smallest than the parameter
            $data = array( 'msg' => "Undefined offset for index ".$key." In Parameter. " );
            if($config['error_level'] == -1){
                if($error != 0){ $this->view->show('error',$data);die(0); }
            }
            return Null;
        }

        return $this->params[$key];
    }


    /**
     * Get all parameter value from url
     *
     * @since 0.1
     * @return array all parameter with index
     **/
    public function all_param(){
        return $this->params;
    }

    /**
     * Load a library class on the library folder
     *
     * @since 0.1
     * @param string $name name of the library
     * @param boolean $makeobject default true to returning as an object
     * @return object/boolean return object if succesfully loaded, return false if already loaded or lib not found
     **/
    public function loadlib($name,$makeobject=true){

        if(class_exists($name)) return false;

        if(file_exists($this->libspath.$name.".php")){
            require($this->libspath.$name.".php");
        }
        else{
            return false;
        }

        if($makeobject) return $this->$name = new $name();

        return true;
    }

    /**
     * Load a model class
     *
     * @since 0.1
     * @param string $name name of the model
     * @return object/boolean return object if succesfully loaded, return false model not found
     **/
    public function loadmodel($name){
        if(file_exists($this->modelspath.$name.".php")){
             require($this->modelspath.$name.".php");
        }
        else{
            return false;
        }

        return $this->$name = new $name();
    }

}
