<?php
//MAIN FUNCTION

    /**
     * Sent header to redirect
     *
     * @since 0.1
     * @param string $link URL to redirect
     * @return - header sent to new location
     **/
    function redirect($link = ''){
        if($link != null){
            header('Location: '.$link, TRUE);
        }
        exit;
    }

    /**
     * Get config value from config file
     *
     * @since 0.1
     * @param string $key key/index of the config
     * @return string return value of the config or boolean false
     **/
    function get_config($key){
        global $config;

       if(!array_key_exists($key,$config)){
           return false;
        }

        return $config[$key];
    }

    /**
     * Set templates name(folder)
     *
     * @since 0.1
     * @param string $name name of the templace folder
     * @return boolean true
     **/
    function set_templates_name($name){
        global $config;

        $config['templates'].= rtrim($name).'/';

        return true;
    }

    /**
     * Sent data to an ajax request
     *
     * @since 0.1
     * @param string $data data to Sent
     * @param string $type type of the data sent
     * @return - not return anything will terminate instead
     **/
    function ajax_callback($data,$type=null){
        if($type == null){
            echo $data;
        }
        else{
            switch($type){
                case "json":
                    echo json_encode($data);
                break;
            }
        }
        die();
    }

    /**
     * Set full base url site
     *
     * @since 0.1
     * @param string $url full url
     * @return boolean true
     **/
    function set_full_url($url){
        global $config;

        $config['full_url'] = $url;

        return true;
    }

    /**
     * Get the current full url
     *
     * @since 0.1
     * @return string full url from config file
     **/
    function full_url(){
        global $config;

        return $config['full_url'];
    }


    /**
     * File includer for templates to the correct path in current path
     *
     * @since 0.1
     * @param string $name name of the file
     * @param integer $error show error if set to 1
     * @return boolean if error happen and activate, will return string
     **/
    function FH_include($name,$error = 0){
      $backtrace = debug_backtrace();
      $path = dirname($backtrace[0]['file']);

      if(file_exists(realpath($path."/".$name))){
         require_once(realpath($path."/".$name));
       }
       else{
         if($error == 1){
           die("File not Exist, searching in : ".realpath($path."/".$name));
         }
         return false;
       }

       return true;
    }

    /**
     * Check if str is on base64 encoding format
     *
     * @since 0.1
     * @param string $str string to check
     * @return boolean true if base64 format
     **/
    function is_base64($str){
      if(preg_match("/^([A-Za-z0-9+\/]{4})*([A-Za-z0-9+\/]{4}|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{2}==)$/",$str)){
        return true;
      }

      return false;
    }
