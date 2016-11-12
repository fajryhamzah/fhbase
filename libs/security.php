<?php
/**
 *                FH Base System
 *           http://www.fajryhamzah.com
 *
 * Security class require Mcrypt to work
 *
 * @since 0.1
 **/

class security{
    private $key;
    private $cipher_type = 'tripledes';
    private $mode = 'ecb';
    private $hash;

    function __construct(){

        if(!function_exists("mcrypt_encrypt")) {
          die("Mcrypt does not installed on this computer");
        }

        $this->key = get_config('encrypt_key');
        $this->hash = get_config('hash_pass');
    }

    /**
     * Hash a data
     *
     * @since 0.1
     * @param string $data
     * @return string hashed data
     **/
    private function HashKey($data){
        return md5(sha1($data));
    }

    /**
     * Hashkey for encryption
     *
     * @since 0.1
     * @param string $data
     * @return string hashed data and a salt
     **/
    function CM_hash($data){
        if(strlen($data)>strlen($this->key)){
            $salt = hash('sha256', $this->key);
        }
        else{
            $salt = hash('sha256', substr($this->key,0,strlen($data)-strlen($this->key)));
        }


        return $this->HashKey($salt.$data);
    }

    /**
     * Encrypt a data
     *
     * @since 0.1
     * @param string $data unencrypted data
     * @param string $key the key to encrypt(DEFAULT: key from config file)
     * @return string encrypted data
     **/
    public function encrypt($data,$key=""){
        $this->key = ($key != "")? $key:$this->key;
        $maxkey =  mcrypt_get_key_size($this->cipher_type,$this->mode);

        if(strlen($this->key) > $maxkey){
            $this->key = substr($this->key,0,$maxkey);
        }
        else{
            while(strlen($this->key) < $maxkey){
                $this->key .= substr($this->key,0,$maxkey-strlen($this->key));
            }
        }

        $encrypt = mcrypt_encrypt($this->cipher_type, $this->key, $data, $this->mode);

        if($this->hash){
            return $this->HashKey($encrypt);
        }
        else{
            return base64_encode($encrypt);
        }
    }

    /**
     * Decrypt an encryption
     *
     * @since 0.1
     * @param string $data encrypted data
     * @param string $key the key to decrypt(DEFAULT: key from config file)
     * @param string $cipher cipher type(DEFAULT: cipher from config file)
     * @param string $mode mode type(DEFAULT: mode from config file)
     * @return string decrypted data
     **/
    public function decrypt($data,$key=null,$cipher=null,$mode=null){
        if($cipher==null) $cipher = $this->cipher_type;
        if($mode==null) $mode = $this->mode;
        if($key==null) $key = $this->key;

        $maxkey =  mcrypt_get_key_size($cipher,$mode);

        if(strlen($key) > $maxkey){
            $key = substr($key,0,$maxkey);
        }
        else{
            while(strlen($key) < $maxkey){
                $key .= substr($key,0,$maxkey-strlen($key));
            }
        }



       return mcrypt_decrypt($cipher,$key,$data,$mode);
    }

    /**
     * Sanitation the input from xss and sqli
     *
     * @since 0.1
     * @param string $input raw user input
     * @return string input after sanitation
     **/
    public function filter($input){ //Filter input from all user, filtered from sqli,and xss
            $filter = addslashes(trim(stripslashes(strip_tags($input))));
            return $filter;
    }


    /**
     * Validation email format
     *
     * @since 0.1
     * @param string $email email address
     * @return boolean
     **/
    function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

}
