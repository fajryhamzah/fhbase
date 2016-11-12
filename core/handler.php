<?php
 /**
  *                FH Base System
  *           http://www.fajryhamzah.com
  *
  *  Handler file is used for handling all the request on the apps
  *  and this also will handle the flow of the app process such
  *  as creating the controller object and call the  method and also
  *  passing all of the parameters into the object.
  *
  *  @since 0.1
  **/
class handler{
    private $controller;
    private $method;
    private $params;
    private $path = "controller/";

    function __construct($url = ''){

        if(substr($url,strlen($url)-1,1) != '/'){
            $url .= '/';
        }

        set_full_url($url);
        $this->setter($url);
        $this->loader();

    }


    /**
     * This function is used for parsing the url given
     * to the single variable such as controller,method and the parameter
     *
     * @since 0.1
     * @param string $url full url
     * @return boolean will always return true
     **/
    private function setter($url){
        $url = explode("/",rtrim($url));    //Explode url to an array
        $i=$this->controller_position($url);

        /*reindex array*/
        $new_arr = array();
        if ($i < count($url) ){
           for($a = $i;$a < count($url);$a++){
                $new_arr[] = $url[$a];
           }
        }
        else{
            $new_arr[0] = $url[$i];
        }

        $this->controller = (((isset($new_arr[0])) && ($new_arr[0] != NULL))? $new_arr[0]:'index'); //the first element is the controller

        if(isset($new_arr[1])){                 //Check if the url has a method to call
            $this->method = $new_arr[1];        //the second element is the method of the controller
        }

        $this->params = array_values($new_arr);

        return true;

    }

    /**
     * Used to check real controller position from url
     *
     * @since 0.1
     * @param array $arr an array from explode of url
     * @return integer index of the controller in the array
     **/
    private function controller_position($arr){
        $i = 0;

        foreach($arr as $b){
            if ($b == NULL) $b='index';
            if(is_dir($this->path.$b)){
                $this->path .= rtrim($b)."/";
                $i +=1;
            }
            else{
                return $i;
            }
        }
    }

    /**
     * this function will create an object of the controller
     * and call the method and also this will passing the parameter to the controller
     *
     * @since 0.1
     * @return boolean will always return true
     **/
    private function loader(){

        //Check if the controller is in an exception
     if(strpos(strtolower(get_config('exception_controller')),strtolower($this->controller)) !== false){
            $this->controller = 'error_page';
            $title = "Exception Config";
            $msg = "Not Allowed to access";
        }

        //echo $this->controller;

        if(!$this->check_cont($this->controller)){
            if(get_config("bypass_index")){
                require($this->path.'index.php');
                $load = new Index();

                if(method_exists($load,$this->controller)){
                   $bypassed = true;
                }
            }
            else{
                //check if controller exist, if not, redirect it to error page
                $this->controller = ($this->check_cont($this->controller) ? $this->controller: 'error_page');  //checking if controller is exist
            }
        }

        if($this->controller == 'error_page'){
            require("controller/".$this->controller.'.php');
            if(isset($msg) && isset($title)){
               $load = new $this->controller($title,$msg);
            }
            else{
               $load = new $this->controller("Controller Error","The Controller you try to access is not found.");
            }
        }
        else{
            if(isset($bypassed) && ($bypassed)){
                $load->set_param($this->params);    //passing the url as a parameter
                $method = $this->controller;
                $load->$method();
            }
            else{
                require($this->path.$this->controller.'.php');
                $load = new $this->controller();
                $load->set_param($this->params);    //passing the url as a parameter

                if($this->method == null) $this->method='index';

                $method = $this->method;

                if(method_exists($load,$method)){    // Check if the method exist in the object
                    $load->$method();                //Then it will call the method
                }
                else{
                    $data = array( 'msg' => "The method you try to access is doesn't exist" );
                    $load->view->show('error',$data);
                }
            }

        }

        return true;
    }


    /**
     * Check the controller is exist on the controller path
     *
     * @since 0.1
     * @param string $cont name of the controller
     * @return boolean
     **/
    private function check_cont($cont){
        if(file_exists($this->path.$cont.".php")){
            return true;
        }
        else{
            return false;
        }
    }

}
