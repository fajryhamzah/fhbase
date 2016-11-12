<?php
 /**
  *                FH Base System
  *           http://www.fajryhamzah.com
  *
  * Model is used for access the database and
  * retrieving data from database or all of database transaction
  * and passing it to the controller
  *
  * @since 0.1
  **/
class Model Extends PDO{
    private $cfg = array();
    private $host;
    private $driver;
    private $uname;
    private $pass;
    private $dbname;
    private $error = null;

    function __construct(){
        $config = get_config("db");

        /* Passing database config to local variable */
        $this->driver   = (($config['DRIVER'] != NULL)? $config['DRIVER'] : 'mysql'); //mysql is the default
        $this->host     = $config['HOST'];
        $this->dbname   = $config['DBNAME'];
        $this->uname    = $config['USER'];
        $this->pass     = $config['PASS'];

        $dns = $this->driver.':dbname='.$this->dbname.";host=".$this->host;

        //try catch statement to cath if an error happen
        try{
         parent::__construct( $dns, $this->uname, $this->pass );
         $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
         $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            $this->error =  $e->getMessage();
        }


    }

    /**
     * Error Message
     *
     * @since 0.1
     * @return String Return error message if occured, false if it's not
     **/
    public function Err(){

        if($this->error != null){
            return $this->error;
        }

        return false;
    }

    /**
     * Execute SELECT query
     *
     * @since 0.1
     * @param string $rows selected rows
     * @param string $table table name
     * @param string $where where clause (Optional)
     * @param string $order_by sort method (Optional)
     * @param string $limit limit the result
     * @return Array Return array of result, false if error occured
     **/
    public function select($rows,$table,$where = null,$order_by = null,$limit = null){

        $cmd = "SELECT ".$rows." FROM ".$table." ";
        if($where != null) $cmd .= "WHERE ".$where;
        if($order_by != null) $cmd .= " ORDER BY ".$order_by;
        if($limit != null) $cmd .= " LIMIT ".$limit;

       $prep = $this->prepare($cmd);
       try{
            $prep->execute();
       }
       catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
       }


        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * Execute INSERT query
     *
     * @since 0.1
     * @param string $table table name
     * @param array $rows array of the new record, field name as the index. ex : array('id'=>1,'uname'=>'test)
     * @return boolean true if successfully added
     **/
    public function insert($table,$rows = array()){
        $cmd = "INSERT INTO ".$table;
        $column=null;$value=null;

        if(empty($rows)){
            $this->error = "Null Parameter";
            return false;
        }

        foreach($rows as $key =>$vl){
            $column .= ",".$key;
            $value .= ", '".$vl."'";
        }

        $cmd .= "(".substr($column,1).") ";
        $cmd .= "VALUES(".substr($value,1).")";

        $prep = $this->prepare($cmd);

        try{
            $prep->execute();
            return true;
        }
        catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }

    }


    /**
     * Execute INSERT(multiple) query
     *
     * @since 0.1
     * @param string $table table name
     * @param array $field field name
     * @param array $record new record
     * @return boolean true if successfully added
     * @example multi_insert("user",Array("username","password"),Array(array("admin","admin"),array("test","test")))
     **/
    public function multi_insert($table,$field=array(),$record=array()){
        $cmd = "INSERT INTO ".$table;
        $column=null;$value=null;$col1=null;$col=null;

        if(empty($field) || empty($record)){
            $this->error = "Null Parameter";
            return false;
        }

        $column = implode(",",$field);
        foreach ($record as $a){
	           if(is_array($a)){
		              foreach($a as $b){
                      $col1.= $this->quote($b).",";
		              }
		              $col.= "(".rtrim($col1,',')."),";
		              $col1='';
	            }
	            else{
                $this->error = "Null value given(value set not same with field given)";
		            return false;
	             }
	      }

        $cmd .= "(".$column.") ";
        $cmd .= "VALUES ".rtrim($col,',');

        $prep = $this->prepare($cmd);

        try{
            $prep->execute();
            return true;
        }
        catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Execute UPDATE query
     *
     * @since 0.1
     * @param string $table table name
     * @param array $rows array of the updated record, field name as the index. ex : array('id'=>1,'uname'=>'test)
     * @param string $where where clause (Optional)
     * @param boolean $affected return how many rows affected (Optional)
     * @return boolean true if successfully changed, false if is not, integer if $affected set to true
     **/
    public function update($table,$rows,$where=null,$affected = false){
        $cmd = "UPDATE ".$table." SET ";
        $column=null;

        if(empty($rows) || !is_array($rows)){
            $this->error = "Null Parameter Or Parameter Assignment Not An Array.";
            return false;
        }

        foreach($rows as $key =>$vl){
            $column .= ",".$key."=".$vl;
        }

        $cmd.= substr($column,1);

        if($where != null) $cmd .= " WHERE ".$where;

        $prep = $this->prepare($cmd);

        try{
            $prep->execute();

            if($affected) return $ret = $prep->rowCount();

            return true;
        }
        catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

     /**
      * Execute DELETE query
      *
      * @since 0.1
      * @param string $table table name
      * @param string $where where clause (Optional)
      * @param boolean $affected return how many rows affected (Optional)
      * @return boolean true if successfully changed, false if is not, integer if $affected set to true
      **/
    public function delete($table,$where = null,$affected = false){
      $cmd = "DELETE ";
      $cmd .= " FROM ".$table;

      if($where != null) $cmd .= " WHERE ".$where;

      $prep = $this->prepare($cmd);

      try{
        $prep->execute();

        if($affected) return $ret = $prep->rowCount();

        return true;
      }
      catch(PDOException $e){
        $this->error = $e->getMessage();
        return false;
      }

    }






















}
