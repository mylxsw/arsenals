<?php
/**
 * 视图函数库
 */
namespace Demo\views\ink;
use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ValueStack;
use Arsenals\Core\str_start_with;
use Arsenals\Core\_D;

$config = Config::load('config');
define('TMP_FUNC', VIEW_PATH . $config['theme'] . DIRECTORY_SEPARATOR . '@templates' . DIRECTORY_SEPARATOR);
define('SITE_URL', $config['site_url']);
/**
 * 资源文件路径
 */
function resource_path(){
	echo SITE_URL . 'Demo/views/ink/public/';
}
/**
 * 公共资源路径
 */
function public_resource_path(){
	echo SITE_URL . 'Public/';
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
	if(\Arsenals\Core\str_start_with($url, 'http://') || \Arsenals\Core\str_start_with($url, 'https://')){
		return $url;
	}
	return SITE_URL . $url;
}
/**
 * 顶栏菜单
 * @param string $current_nav
 * @return string
 */
function top_nav($current_nav = 'home'){
	$navModel = Registry::load('Demo\\models\\Navigator');
	$ui_top_menus = $navModel->getNavTrees(0,'top',3);
// 	\Arsenals\Core\_D($ui_top_menus);
	$_top_menus = '<li'. ($current_nav == 'home' ? ' class="active" ' : '') .'><a href=""><i class="icon-home"></i></a></li>';
	foreach($ui_top_menus as $k => $v){
		$_top_menus .=
			'<li'. ($current_nav == $v['id'] ?
				' class="active" '
				: '')
				."><a href=\"" . url($v['url']) . "\">{$v['name']}</a>";
		if( isset($v['sub']) && is_array($v['sub']) && count($v['sub']) > 0){
			$_top_menus .= "<ul class=\"submenu\">";
			foreach ($v['sub'] as $k2=>$v2){
				$_top_menus .=
				"<li><a href=\"" . url($v['url']) . "\">{$v['name']}</a></li>";
			}
			$_top_menus .= "</ul>";
		}
		$_top_menus .=  "</li>";
	}
	return $_top_menus;
}
/**
 * 首页轮播图
 * @return string
 */
function index_lunbo(){
	$settingModel = Registry::load('Demo\\models\\Setting');
	$lunbos = $settingModel->getSetting('index_lunbo_imgs', 'plugin');
	$lunbo_imgs = \unserialize($lunbos['setting_value']);
	$html = "<div id='sliderPlay' style='visibility: hidden'>";
	foreach ($lunbo_imgs as $key=>$val){
		$html .= "<a href='" . url($val['url']) . "' target=\"_blank\"><img src='" . url($val['img']) . "' alt='" . $val['title'] . "' height='376px' width='940px'/></a>";
	}
	$html .= "</div>";
	return $html;
}
/**
 * 最新的文章
 * @param unknown $category
 * @param number $count
 */
function new_blog($category, $count = 1){
	$articleModel = Registry::load('Demo\\models\\Article');
	return $articleModel->getNewArticlesInCategory($category, $count);	
}
/**
 * 面包屑导航
 * @param array $elements
 */
function breadcrumbs($elements = array()){
	if(!is_array($elements) || count($elements) == 0){
		return '';
	}
	$html = '<nav class="ink-navigation"><ul class="breadcrumbs">';
	$i = 0;
	foreach ($elements as $k => $e){
		$html .= '<li' . ($i == (count($elements) - 1) ? ' class="active" ' : '') . '>';
		$html .= '<a href="' . url($e) . '">';
		$html .= $k;
		$html .= '</a>';
		$html .= "</li>";
		$i ++;
	}
	$html .= '</ul></nav>';
	
	return $html;
}