<?php

/*                      FH Base System
 *              Author : Fajry Hamzah
 *              URL    : http;//www.fajryhamzah.com
 *
 *  FH Base System is the base system (Based on MVC) That I will
 *  use for my project. This is just simple system to make my work
 *  easier to developing.
 */


//Uncomment for development 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;



/* Include the loader
 */
require_once("core/autoload.php");

//set the default timezone
date_default_timezone_set(get_config('timezone'));

$link = (isset($_GET['cmd']) ? $_GET['cmd']:'');


//Creating an object to handle all of incoming request
$bootstrap = new handler($link);



$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<br>Page generated in '.$total_time.' seconds.';
