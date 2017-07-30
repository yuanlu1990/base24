<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/18
 * Time: 11:25
 */

class Base {

 
    /**
     * base24加密解密的字符集(可以自定义)
     * @var array
     */
    private static $base24CharacterSet = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');


    /**
     * base24 加密
     * @param string $string 待加密的字符串
     * @return string
     **/
    public static function base24_encode($string) {
        $return = '';
        $length = strlen($string);
        $charArr = self::$base24CharacterSet;
        for($i = 0;$i < $length; $i++) {
            $ascii = ord($string[$i]);
            $return .= $charArr[$ascii >> 4];
            $return .= $charArr[23 - ($ascii & 0x0f)];
        }
        return $return;
    }
    /**
     * base24 解密
     * @param string $string 待解密的字符串
     * @return string
     **/
    public static function base24_decode($string) {
        $return = '';
        $length = strlen($string);
        if(!($length % 2)) {
             $charStr = implode('',self::$base24CharacterSet);
             $loc= array();
             $n = array();
             //解密后的字符长度
             $charLen = $length / 2;
             for($i = 0; $i < $charLen; $i++) {
                $loc[0] = strpos($charStr, $string[2*$i]);
                $loc[1] = strpos($charStr, $string[(2*$i ) + 1 ]);
                if (false !== $loc[0]  && false !== $loc[1]) {
                    $n[0] = sprintf('%u',($loc[0] - $charStr));
                    $n[1] = 23 - sprintf('%u',($loc[1] - $charStr));
                    $return .= chr(sprintf('%u',(($n[0] << 4) | $n[1])));
                } else {
                    $return = '';
                    break;
                }
             }
       }
       return $return;
    }

}

$word = 'word';
//加密
$eword  = Base::base24_encode($word);
echo $eword.'<br>';
//解密
echo  Base::base24_decode($eword);
