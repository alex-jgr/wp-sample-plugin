<?php
namespace SamplePlugin\Service;

use \SamplePlugin\Core\Service;

/**
 * Description of Secure
 *
 * @author admin
 */
class Secure extends Service
{
    protected $iv;
    protected $key;
    const METHOD = 'aes-256-cbc';
    
    protected function setIv( $iv )
    {
        $this->iv = $iv;
    }
    
    protected function setKey( $key )
    {
        $this->key = $key;
    }
    
    public function encrypt($value)
    {
        
        $data = mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $this->key, $value, MCRYPT_MODE_ECB, $this->iv );
        return base64_encode( $data );
    }
    
    public function decrypt($value)
    {
        $text = base64_decode( $value );
        return trim(mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $this->key, $text, MCRYPT_MODE_ECB, $this->iv ));
    }

    public function get($key)
    {
        return $this->decrypt(get_option($key));
    }
    
    public function set($key, $value)
    {
        update_option($key, $this->encrypt($value));
    }
    
    
    
    public function ssl_encrypt($message)
    {
        if (mb_strlen($this->key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivsize);
        
        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        return $iv.$ciphertext;
    }

    public function ssl_decrypt($message)
    {
        if (mb_strlen($this->key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($message, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($message, $ivsize, null, '8bit');
        
        return openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
}