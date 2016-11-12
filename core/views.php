<?php
 /**
  *                FH Base System
  *           http://www.fajryhamzah.com
  *
  * View is used for rendering the output of the app,
  * Data from the controller will be passing to the output
  *
  * @since 0.1
  **/


Class View{
    private $path;
    private $template_name;

    function __construct(){
        $this->template_name = 'templates/';
    }

    /**
     * Output to the browser
     *
     * @since 0.1
     * @param string $path view file name
     * @param array $data data to sent to the view (Optional)
     * @return boolean always return true
     **/
    function show($path,$data=array()){
      extract($data);
      require($this->template_name.$path.'.php');

      return true;
    }

    function set_template($name){
        $this->template_name .= rtrim($name).'/';
    }
}
