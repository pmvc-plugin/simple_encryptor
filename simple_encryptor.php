<?php

namespace PMVC\PlugIn\simple_encryptor;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\SimpleEncryptor';

class SimpleEncryptor extends \PMVC\PlugIn
{
    private $_methods;

    public function init()
    {
        if (!isset($this['method'])) {
            $this['method'] = 'aes-256-cfb';
        }
        if (!isset($this['key'])) {
            $this['key'] =
               \PMVC\plug('get')->
               get('passwordPrivateKey');
        }
    }

    public function isCipher($method)
    {
        if (empty($this->_methods)) {
            $this->_methods = array_flip(openssl_get_cipher_methods());
        }
        $method = strtolower($method);
        if (isset($this->_methods[$method])) {
            return true;
        } else {
            return false;
        }
    }

    public function genIv($method)
    {
        $iv = openssl_random_pseudo_bytes(
            openssl_cipher_iv_length($method)
        );
        return $iv;
    }

    /**
     * @see http://micmap.org/php-by-example/en/function/openssl_encrypt
     */
    public function encode($string)
    {
        if (!isset($this['key'])) {
            return !trigger_error('Key is not setted.');
        }
        if ($this->isCipher($this['method'])) {
            if (empty($this['iv'])) {
                $this['iv'] = $this->genIv($this['method']);
            }
            return 
                openssl_encrypt(
                    $string,
                    $this['method'],
                    $this['key'],
                    null,
                    $this['iv'] 
                ).
                '|'.
                base64_encode($this['iv']);
        } else {
            return openssl_encrypt(
                $string,
                $this['method'],
                $this['key']
            );
        }
    }
    
    /**
     * @see http://micmap.org/php-by-example/en/function/openssl_decrypt
     */
    public function decode($string)
    {
        if (!isset($this['key'])) {
            return !trigger_error('Key is not setted.');
        }
        $data = explode('|', $string);
        if (isset($data[1])) {
            return openssl_decrypt(
                $data[0],
                $this['method'],
                $this['key'],
                null,
                base64_decode($data[1])
            );
        } else {
            return openssl_decrypt(
                $data[0],
                $this['method'],
                $this['key']
            );
        }
    }
}
