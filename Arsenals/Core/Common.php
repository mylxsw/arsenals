<?php

namespace Arsenals\Core;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}

/**
 * 转换路径为命名空间.
 *
 * @param unknown_type $path
 */
function conv_path_to_ns($path)
{
    if (str_start_with($path, BASE_PATH)) {
        return str_replace('/', '\\', substr($path, strlen(BASE_PATH)));
    }

    return str_replace('/', '\\', $path);
}

/**
 * 转换类方法的字符串为call_user_func能够识别的参数类型.
 *
 * @param unknown $class_str
 *
 * @return Ambigous <unknown, multitype:string Ambigous <object, multitype:> >
 */
function conv_str_to_call_user_func_param($class_str)
{
    $validate_entity = $class_str;
    if (is_string($class_str)) {
        // 如果规则中含有@，则规则实体为对象的普通方法
        // 如果不含@和::，则说明规则实体为普通函数
        $at_pos = strpos($class_str, '@');
        if ($at_pos > 0) {
            $class_name = substr($class_str, 0, $at_pos);
            $method_name = substr($class_str, $at_pos + 1);
            $class = Registry::load($class_name);
            $validate_entity = [$class, $method_name];
        }
    }

    return $validate_entity;
}
/**
 * 正则表达式验证数组中是否含有key.
 *
 * @param unknown $search_key
 * @param unknown $array
 *
 * @return bool
 */
function array_key_exists_regexp($search_key, $array)
{
    foreach ($array as $key => $value) {
        if (preg_match($key, $search_key)) {
            return true;
        }
    }

    return false;
}
/**
 * 正则表达式匹配数组中是否含有值
 *
 * @param unknown $search
 * @param unknown $array
 *
 * @return bool
 */
function array_exists_regexp($search, $array)
{
    foreach ($array as $arr) {
        $reg = '#'.$arr.'#';
        if (preg_match($reg, $search)) {
            return true;
        }
    }

    return false;
}
/**
 * 正则表达式从数组中获取值
 *
 * @param unknown $array
 * @param unknown $key
 *
 * @return unknown|null
 */
function array_val_by_key_regexp($array, $search_key)
{
    foreach ($array as $key => $value) {
        if (preg_match($key, $search_key)) {
            return [$key, $value];
        }
    }
}
/**
 * 字符串函数： 判断字符串是否以另一字符串结尾.
 *
 * @param string $string         要进行判断的字符串
 * @param string $suffix         结尾字符串
 * @param bool   $case_sensitive 是否大小写敏感
 *
 * @return bool
 */
function str_end_with($string, $suffix, $case_sensitive = true)
{
    //return substr_compare($string, $suffix,
    //	strlen($string) - strlen($suffix), strlen($string), $case_sensitive) === 0;
    if (!$case_sensitive) {
        $string = strtolower($string);
        $suffix = strtolower($suffix);
    }

    return substr($string, -strlen($suffix)) == $suffix;
}
/**
 * 字符串函数： 判断字符串是否以某一字符串开始.
 *
 * @param string $string         要进行判断的字符串
 * @param string $prefix         开始字符串
 * @param bool   $case_sensitive 是否大小写敏感
 *
 * @return bool
 */
function str_start_with($string, $prefix, $case_sensitive = true)
{
    if (strlen($string) < strlen($prefix)) {
        return false;
    }

    return substr_compare($string, $prefix,
            0, strlen($prefix), $case_sensitive) === 0;
}

/**
 * 在对象文件的源码内容中插入内容，并返回修改后的源码
 *
 * @param string $object_file 操作的原文件名，必须只包含一个类文件
 * @param string $content     要插入的内容
 *
 * @return string 修改后的源码
 */
function source_insert($object_file, $content)
{
    $source_code = php_strip_whitespace($object_file);
    if (str_end_with($source_code, '?>')) {
        $source_code = substr($source_code, 0, -2);
    }
    if (str_end_with($source_code, '}')) {
        $source_code = substr($source_code, 0, -1);
    }
    $source_code .= $content;
    $source_code .= '}';

    return strip_whitespace($source_code);
}
/**
 * 从PHP源码中去除注释和空白.
 *
 * @param string $content
 *
 * @return string
 */
function strip_whitespace($content)
{
    $source = '';
    $last_space = false;
    $tokens = token_get_all($content);
    foreach ($tokens as $token) {
        if (is_string($token)) {
            $last_space = false;
            $source .= $token;
        } else {
            list($id, $text) = $token;
            switch ($id) {
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                case T_WHITESPACE:
                    if (!$last_space) {
                        $source .= ' ';
                        $last_space = true;
                    }
                    break;
                default:
                    $source .= $text;
                    $last_space = false;
            }
        }
    }

    return $source;
}
