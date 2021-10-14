<?php
namespace App\Helpers;

Trait generator {

    public function generateSecureRef(Int $number)
    {
        return $this->getHashedToken($number);
    }


    private static function getPool($type = 'alnum')
    {
        switch ($type) {
            case 'alnum':
                $pool = '01234vwxyzABCD';
                break;
            case 'alpha':
                $pool = 'abcxyzABCDEFG';
                break;
            case 'hexdec':
                $pool = '012def';
                break;
            case 'numeric':
                $pool = '0189';
                break;
            case 'nozero':
                $pool = '129';
                break;
            case 'distinct':
                $pool = '2345UVWXYZ';
                break;
            default:
                $pool = (string) $type;
                break;
        }

        return $pool;
    }

    /**
     * Generate a random secure crypt figure
     * @param  integer $min
     * @param  integer $max
     * @return integer
     */
    public static function secureCrypt($min, $max)
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min; // not so random...
        }

        $log    = log($range, 2);
        $bytes  = (int) ($log / 8) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    /**
     * Finally, generate a hashed token
     * @param  integer $length
     * @return string
     */

    public static function getHashedToken($length = 10)
    {
        $token = "";
        $max   = strlen(static::getPool());
        for ($i = 0; $i < $length; $i++) {
            $token .= static::getPool()[static::secureCrypt(0, $max)];
        }

        return $token;
    }

}