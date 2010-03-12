<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Special thanks go out to Mike's blog:
// http://idoqa.com/blog/post/75/codeigniter-rasshirennyy-helper-url-s-vozmozhnost-yu-transliteracii

if (!function_exists('rus2translit'))
{
    function rus2translit($string)
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
}

if (!function_exists('str2url'))
{
    function str2url($str)
    {
        $str = rus2translit($str);
        $str = strtolower($str);
		$str = html_entity_decode($str, ENT_COMPAT);
        $str = preg_replace("`\[.*\]`U", "", $str);
        $str = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $str);
        $str = htmlentities($str, ENT_COMPAT);
        $str = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $str);
        $str = preg_replace(array("`[^a-z0-9]`i","`[-]+`") , "-", $str);
		
        $str = trim($str, "-");
        return $str;
    }
}

/* End of file str2url_helper.php */
/* Location: ./application/helpers/str2url_helper.php */