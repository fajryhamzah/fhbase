<?php


/*                  FH Base System
 *           http://www.fajryhamzah.com

 * Configuration for the app.
 */

    /*This code below is for configuration
     *of the apps
     */

    /*###########################################
     *              TIMEZONE
     *###########################################
     *see the list in : http://php.net/manual/en/timezones.php
    */
    $config['timezone'] = "Asia/Jakarta";

    /*###########################################
     *         CHARACTER SET(CHARSET)
     *###########################################
    */
    $config['charset'] = 'UTF-8';

    /*###########################################
     *         INDEX ROUTE
     *###########################################
    */
    $config['bypass_index'] = TRUE;

    /*###########################################
     *           PATH CONFIGURATION
     *###########################################
     *Path of the apps
     */
    $config['base_site'] = 'http://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
    $config['templates'] = '';
    /*###########################################
     *              ERROR REPORTING
     *############################################
     *Config for showing error, fill it with level like :
     *  -1 - To turn on all the error report  (Good for development)
     *  0  - To turn off all the error report (Good for production)
     */
    $config['error_level'] = -1;

    /*###########################################
     *          Database Connection
     *###########################################
     * List of Database support(Depends on installed PDO database driver on server),
     * To see avalaible Driver on your server, use PDO::getAvailableDrivers() function
     * PDO Support:
     *  mysql   (the default)
     *  mssql
     *  oci (Oracle)
     *  pgsql (postgresql)
     *  sqlite
     *
     */
    $config['db']['DRIVER']  = 'mysql';
    $config['db']['HOST']    = '';
    $config['db']['DBNAME']  = '';
    $config['db']['USER']    = '';
    $config['db']['PASS']    = '';


    /*###########################################
     *         ENCRYPTION KEY & Method
     *###########################################
     *$config['hash_pass'] : Hash the encrypted password with md5
     */
    $config['encrypt_key'] = 'whatever';
    $config['hash_pass'] = FALSE;

    /*###########################################
     *              Exception Controller
     *###########################################
     *Set the name of class controller here
     *so the system will not load the controller
     *when users try to load with url
     *(Separated with comma)
    */
    $config['exception_controller'] = 'FH_Config';


    /*############################################
     *          CACHING(MEMCACHED)
     *############################################
     */
    $config['enabling_caching'] = true;
    $config['memcache_server'] = 'localhost';
    $config['memcache_port'] = '11211';
