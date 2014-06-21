<?php

include_once 'crypt_config.php';

class crypt_manager {
    
    private $public;
    private $private;
    
    function __construct() {
        global $_CRYPT;
        
        $this->private = $_CRYPT['private_key'];
        $this->public = $_CRYPT['public_key'];
    }

    public function encrypt($data) {
        if (openssl_public_encrypt($data, $encrypted, $this->public))
            $data = base64_encode($encrypted);
        else
            throw new crypt_exception('Unable to encrypt data.');

        return $data;
    }

    public function decrypt($data) {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->private))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }

}
