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
        if (openssl_public_encrypt($data, $encrypted, $this->public))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data.');

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
