<?php
/**
 * 验证码配置信息.
 *
 * @author  管宜尧<mylxsw@126.com>
 */
return [
    'bg_width'             => 80,    // 宽度
    'bg_height'            => 30,    // 高度
    'noise_line_min'       => 1,    // 干扰线数量最小值
    'noise_line_max'       => 5,    // 干扰线数量最大值
    'noise_pixel_min'      => 5,    // 干扰点数量最小值
    'noise_pixel_max'      => 20,    // 干扰点数量最大值
    'fontsize_min'         => 14,    // 字体大小最小值
    'fontsize_max'         => 20,    // 字体大小最大值
    'code_len'             => 4,    // 验证码字符数量
    'font'                 => '',    // 使用字体（必须为绝对路径）
    'seed'                 => 'abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ', // 随机数种子
    ];
