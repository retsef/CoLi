<?php

class crypt_manager {
    
    public $public;
    public $private;
    
    function __construct() {
        $path = "./";
        
        $fpriv = "privkey.key";
        $fpubl = "publkey.key";
        
        $fname = $path . $fpriv;
        
        $file = fopen($fname, "r");
        $this->private = fread($file, filesize($fname));
        fclose($file);
        
        $fname = $path . $fpubl;
        
        $file = fopen($fname, "r");
        $this->public = fread($file, filesize($fname));
        fclose($file);
        
    }

    public function encrypt($data) {
        if (!$publicKey = openssl_pkey_get_public($this->public))
            throw new Exception('Unable to get the publickey');
        if (openssl_public_encrypt($data, $encrypted, $publicKey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data.');

        return $data;
    }

    public function decrypt($data) {
        if (!$privateKey = openssl_pkey_get_private($this->private))
            throw new Exception('Unable to get the privatekey');
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privateKey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }

}
