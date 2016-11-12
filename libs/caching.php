<?php

/**
 *                FH Base System
 *           http://www.fajryhamzah.com
 *
 * Caching class require memcache to work
 *
 * @since 0.1
 **/

Class caching{
    private $enabling;
    private $m;

    function __construct(){

        $this->enabling = get_config('enabling_caching');
        $server = get_config('memcache_server');
        $port = get_config('memcache_port');

        if(!$this->enabling){
            return true;
        }

        if(!class_exists('Memcached')){
            die('Memcache extension not installed');
        }

       $this->m = new Memcached;
       $this->connect($server,$port);
    }

    /**
     * Connect to cache server
     *
     * @since 0.1
     * @param string $server server name or IP
     * @param string $port server port
     * @return boolean true
     **/
    private function connect($server,$port){
       $this->m->addserver($server,$port) or die('Could Not Connect to Cache Server');
    }

    /**
     * Set a new data to cache server
     *
     * @since 0.1
     * @param string $key key for the data
     * @param string $data data to cache
     * @return boolean true
     **/
    public function set($key,$data){
        if(!$this->enabling){
            return null;
        }


        $key = md5($key);
        $this->m->set($key,$data);

        return true;
    }

    /**
     * Get a data from cache server
     *
     * @since 0.1
     * @param string $key key for the data
     * @return string data
     **/
    public function get($key){
        if(!$this->enabling){
            return null;
        }

        $key = md5($key);
        return $this->m->get($key);
    }

    /**
     * Flush data from cache server
     *
     * @since 0.1
     * @return boolean
     **/
    public function flush(){
        if(!$this->enabling){
            return false;
        }

        $this->m->flush();

        return true;
    }

}
