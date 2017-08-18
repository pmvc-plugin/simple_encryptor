<?php

namespace PMVC\PlugIn\simple_encryptor;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\SimpleEncryptor';

class SimpleEncryptor extends \PMVC\PlugIn
{

    public function init()
    {
        if (!isset($this['method'])) {
            $this['method'] = 'AES-256-ECB';
        }
    }

    /**
     * @see http://micmap.org/php-by-example/en/function/openssl_encrypt
     */
    public function encode($string)
    {
        if (!isset($this['key'])) {
            return !trigger_error('Key is not setted.');
        }
        return openssl_encrypt(
            $string,
            $this['method'],
            $this['key']
        );
    }
    
    /**
     * @see http://micmap.org/php-by-example/en/function/openssl_decrypt
     */
    public function decode($string)
    {
        if (!isset($this['key'])) {
            return !trigger_error('Key is not setted.');
        }
        return openssl_decrypt(
            $string,
            $this['method'],
            $this['key']
        );
    }
}
