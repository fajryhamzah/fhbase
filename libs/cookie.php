<?php
/**
 *                FH Base System
 *           http://www.fajryhamzah.com
 *
 * Cookie class for cookies handler
 *
 * @since 0.1
 **/

Class cookie{

    function __construct(){
        ob_start();
    }

    function __desctruct(){
        ob_end_flush();
    }

    /**
     * Set a new cookies
     *
     * @since 0.1
     * @param string $name name of the cookies
     * @param string $value value of the cookies
     * @param string $alifetime life time for the cookies(opt)
     * @param string $path path of domain (DEFAULT: root folder)
     * @param string $domain domain (opt)
     * @return boolean
     **/
    function set_cookies($name,$value,$alifetime=null,$path="/",$domain=null){
        if($alivetime!=null){
             if(setcookie($name,$value,time()+$alifetime,$path,$domain)) return true;
        }
        else{
            if($alifetime !== null){
                if(setcookie($name,false,time()-500,$path,$domain)) return true;
            }
            if(setcookie($name,$value,time()+86400,$path,$domain)) return true; //set for one day for default
        }

        return false;
    }

    /**
     * Get cookies value
     *
     * @since 0.1
     * @param string $name name of the cookies
     * @return string cookies value or boolean false if error
     **/
    function get_cookies($name){
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }
        else{
            return false;
        }
    }

    /**
     * Delete cookies
     *
     * @since 0.1
     * @param string $name name of the cookies
     * @param string $path path of domain (opt,DEFAULT: root folder)
     * @param string $domain domain (opt)
     * @return boolean
     **/
    function delete_cookies($name,$path="/",$domain=null){
        if($this->get_cookies($name) !== false){
            unset($_COOKIE[$name]);
            if($this->set_cookies($name,'',false,$path,$domain)) return true;
        }

        return false;
    }
}
