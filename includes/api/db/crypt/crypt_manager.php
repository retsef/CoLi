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
        if (!$publicKey = openssl_pkey_get_public($this->public))
            throw new crypt_exception('Unable to get the publickey');
        if (openssl_public_encrypt($data, $encrypted, $publicKey))
            $data = base64_encode($encrypted);
        else
            throw new crypt_exception('Unable to encrypt data.');

        return $data;
    }

    public function decrypt($data) {
        if (!$privateKey = openssl_pkey_get_private($this->private))
            throw new crypt_exception('Unable to get the privatekey');
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privateKey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }

}
