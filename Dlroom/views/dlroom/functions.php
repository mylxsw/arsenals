<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 14-5-12
 * Time: 下午11:19
 */
/**
 * 视图函数库
 */
namespace Dlroom;
use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ValueStack;

$config = Config::load('config');
define('TMP_FUNC', VIEW_PATH . $config['theme'] . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR);
define('SITE_URL', $config['site_url']);
define('RESOURCE_URL', IS_SAE ? 'http://agiledev.sinaapp.com/' : $config['site_url']);
/**
 * 资源文件路径
 */
function resources(){
    return RESOURCE_URL . 'Resources/';
}
/**
 * 资源文件路径
 */
function resource_path(){
    return RESOURCE_URL . 'Dlroom/views/dlroom/public/';
}
/**
 * 站点网址
 */
function site_url(){
    return SITE_URL;
}
/**
 * 公共资源路径
 */
function public_resource_path(){
    return RESOURCE_URL . 'Public/';
}
/**
 * 页面头部内容
 */
function header($load_css = array()){
    @extract(ValueStack::gets());
    include TMP_FUNC . 'header.php';
}
/**
 * 页面尾部内容
 */
function footer(){
    @extract(ValueStack::gets());
    include TMP_FUNC . 'footer.php';
}
/**
 * 页面头部内容
 */
function header_html($load_css = array()){
    @extract(ValueStack::gets());
    include TMP_FUNC . 'header_html.php';
}
/**
 * 页面尾部内容
 */
function footer_html(){
    @extract(ValueStack::gets());
    include TMP_FUNC . 'footer_html.php';
}
/**
 * 移除Html中的标签
 * @param string $html
 * @return string
 */
function htmlToText($html){
    return strip_tags($html);
}
/**
 * 解析超链接
 * @param unknown $url
 */
function url($url){
    if(trim($url) == '#'){
        return "javascript:void(0)";
    }
    $split_pos = strpos($url, '?');
    $new_url = $split_pos ? (substr($url, 0, $split_pos). '?' . str_replace('?', '&', substr($url, $split_pos + 1))) : $url;

    if(\Arsenals\Core\str_start_with($url, 'http://') || \Arsenals\Core\str_start_with($url, 'https://')){
        return $new_url;
    }

    return SITE_URL . $new_url;
}

/**
 * 首页轮播图
 * @return string
 */
function index_lunbo(){
    return \Dlroom\common\CacheUtils::cacheFile('lunbo', function(){
        $settingModel = Registry::load('Common\\models\\Setting');
        $lunbos = $settingModel->getSetting('index_lunbo_imgs', 'plugin');
        $lunbo_imgs = \json_decode($lunbos['setting_value']);
        $html = "<div id='sliderPlay' style='visibility: hidden'>";
        foreach ($lunbo_imgs as $key=>$val){
            $html .= "<a href='" . url($val->url) . "' target=\"_blank\"><img src='" . url($val->img) . "' alt='" . $val->title . "' height='376px' width='940px'/></a>";
        }
        $html .= "</div>";
        return $html;
    });

}

/**
 * 分页
 * @param string $url
 * @param number $totals
 * @param number $page_count
 * @param number $current
 * @param number $show_offset 当前页码前后显示的页码数量
 * @return string
 */
function pagination($url, $totals, $page_count, $current, $show_offset = 3){
    if($page_count <= 1){
        return '';
    }

    $current = intval($current);
    if($current < 1 || $current > $page_count){
        $current = 1;
    }

    $html = '<nav class="ink-navigation">
				<ul class="pagination">';

    // 是否显示上一页
    if($current > 1){
        $html .= '<li class="previous"><a href="' . url("{$url}?p=" . ($current - 1)) . '">上一页</a></li>';
    }

    $start = 1;
    if($current - $show_offset > 0){
        $start = $current - $show_offset;
    }

    $end = $page_count;
    if($current + $show_offset < $page_count){
        $end = $current + $show_offset;
    }

    for($i = $start; $i <= $end; $i ++){
        $html .= '		<li ' . ($current != $i ? '' : ' class="active" ' ) . '><a href="' . url($url . '?p=' . $i) . '">' . $i . '</a></li>';

    }

    // 是否显示下一页
    if($current < $page_count){
        $html .= '<li class="next"><a href="' . url("{$url}?p=" . ($current + 1)) . '">下一页</a></li>';
    }

    $html .= '	</ul>
			</nav>';
    return $html;
}

/**
 * 为文件名添加前缀
 * @param $filename
 * @param $prefix
 */
function filename_prefix($filename, $prefix){
    $filename = str_replace('\\', '/', $filename);
    $last_pos = strrpos($filename, '/');

    $path = substr($filename, 0, $last_pos + 1);
    $name = substr($filename, $last_pos + 1);

    return $path . $prefix . $name;
}

/**
 * 载入照片
 * @param $tag
 * @param int $cnt
 * @return mixed
 */
function loadPhotos($tag, $cnt= 5){
    $photoModel = Registry::load('\Common\models\Photos');
    $data = $photoModel->getAllPhotos(1, $tag, '', $cnt);
    return $data['data'];
}

/**
 * 最新的文章
 * @param unknown $category
 * @param number $count
 */
function new_blog($category, $count = 1){
    $articleModel = Registry::load('Common\\models\\Article');
    return $articleModel->getNewArticlesInCategory($category, $count);
}