<?php

/**
 *                FH Base System
 *           http://www.fajryhamzah.com
 *
 * Session library
 *
 * @since 0.1
 **/

class Session {

    function __construct(){
        session_start(); //start a session
    }

    /**
     * Set a session
     *
     * @since 0.1
     * @param string/array $name name of the session, array if set a multiple Session
     * @param string $value value of the session if not set multiple session at once
     * @return null
     **/
    public function set_session($name,$value = null){
        if(is_array($name)){
            foreach($name as $key => $value){
                $_SESSION[$key] = $value;
            }
            return;
        }
        $_SESSION[$name] = $value;

        return;
    }

    /**
     * Get a session value
     *
     * @since 0.1
     * @param string $name name of the session
     * @return string value of the session if exist
     **/
    public function get_session($key){
        if(isset($_SESSION[$key])){
           return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Get all session
     *
     * @since 0.1
     * @return array session
     **/
    public function all_session(){
        return $_SESSION;
    }

    /**
     * delete the session
     *
     * @since 0.1
     * @param string $key key of the session
     * @return boolean true
     **/
    public function unsession($key){
        unset($_SESSION[$key]);
        return true;
    }

    /**
     * Destroy session
     *
     * @since 0.1
     * @return boolean 
     **/
    public function destroy(){
        return session_destroy();
    }

}
