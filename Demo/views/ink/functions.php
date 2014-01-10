<?php
/**
 * 视图函数库
 */
namespace Demo\views\ink;
use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ValueStack;

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
	return SITE_URL . $url;
}
/**
 * 顶栏菜单
 * @param string $current_nav
 * @return string
 */
function top_nav($current_nav = 'home'){
	$menuModel = Registry::load('Demo\\models\\Menus');
	$ui_top_menus = $menuModel->getMenusTree(0,0,3);
// 	\Arsenals\Core\_D($ui_top_menus);
	$_top_menus = '<li'. ($current_nav == 'home' ? ' class="active" ' : '') .'><a href=""><i class="icon-home"></i></a></li>';
	foreach($ui_top_menus as $k => $v){
		$_top_menus .=
			'<li'. ($current_nav == $v['menu_name'] ?
				' class="active" '
				: '')
				."><a href=\"" . url($v['menu_href']) . "\">{$v['menu_show']}</a>";
		if( isset($v['sub']) && is_array($v['sub']) && count($v['sub']) > 0){
			$_top_menus .= "<ul class=\"submenu\">";
			foreach ($v['sub'] as $k2=>$v2){
				$_top_menus .=
				"<li><a href=\"" . url($v['menu_href']) . "\">{$v['menu_show']}</a></li>";
			}
			$_top_menus .= "</ul>";
		}
		$_top_menus .=  "</li>";
	}
	return $_top_menus;
}
/**
 * 最新的文章
 * @param unknown $category
 * @param number $count
 */
function new_blog($category, $count = 1){
	$blogModel = Registry::load('Demo\\models\\Blog');
	return $blogModel->getNewBlogInCategory($category, $count);	
}
/**
 * 面包屑导航
 * @param array $elements
 */
function breadcrumbs($elements = array()){
	if(!is_array($elements) || count($elements) == 0){
		return '';
	}
	$html = '<div id="main-left" ><nav class="ink-navigation"><ul class="breadcrumbs">';
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