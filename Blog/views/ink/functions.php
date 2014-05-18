<?php
/**
 * 视图函数库
 */
namespace Blog;
use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ValueStack;

$config = Config::load('config');
define('TMP_FUNC', VIEW_PATH . $config['theme'] . DIRECTORY_SEPARATOR . '@templates' . DIRECTORY_SEPARATOR);
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
	return RESOURCE_URL . 'Blog/views/ink/public/';
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
 * 顶栏菜单
 * @param string $current_nav
 * @return string
 */
function top_nav($current_nav = 'home'){
	return \Blog\common\CacheUtils::cacheFile('top-' . $current_nav, function($current_nav){
		$current_nav = func_get_arg(0);
		$navModel = Registry::load('Common\\models\\Navigator');
		$ui_top_menus = $navModel->getNavTrees(0,'top',3);
	// 	\Arsenals\Core\_D($ui_top_menus);
		$_top_menus = '<li'. ($current_nav == 'home' ? ' class="active" ' : '') .'><a href="' . url('') . '"><i class="icon-home"></i></a></li>';
		foreach($ui_top_menus as $k => $v){
			$_sub_nav = '';
            $is_current = false;//是否是当前导航
            if( isset($v['sub']) && is_array($v['sub']) && count($v['sub']) > 0){
				$_sub_nav .= "<ul class=\"submenu\">";
				foreach ($v['sub'] as $k2=>$v2){
					$_sub_nav .=
					"<li><a href=\"" . url($v2['url']) . "\">{$v2['name']}</a></li>";
                    if(is_current_nav($current_nav, $v2['url'])){
                    	$is_current = true;
                    }
                }
				$_sub_nav .= "</ul>";
			}
            
            $_top_menus .=
                "<li "  . ($is_current || is_current_nav($current_nav, $v['url']) ? ' class="active"' : '') . "><a href=\"" . url($v['url']) . "\">{$v['name']}</a>";
			$_top_menus .= $_sub_nav;
			$_top_menus .=  "</li>";
		}
		
		return $_top_menus;
	}, $current_nav);
}
/**
 * 判断是否是当前url
 * @private
 */
function is_current_nav($keyword, $url){
    return $keyword == $url;
}
/**
 * 底部导航
 * @return string
 */
function footer_nav(){
	return \Blog\common\CacheUtils::cacheFile('footer', function(){
		$navModel = Registry::load('Common\\models\\Navigator');
		$ui_footer_menus = $navModel->getNavTrees(0,'footer',3);
		
		$html = '';
		foreach($ui_footer_menus as $k => $v){
			$html .= '<div class="ftb-col">';
			$html .= '<h4>' . $v['name'] . '</h4>';
			if( isset($v['sub']) && is_array($v['sub']) && count($v['sub']) > 0){
				foreach ($v['sub'] as $k2=>$v2){
					$html .= '<li><a href="' . url($v2['url']) . "\">{$v2['name']}</a></li>";
				}
			}
			$html .= '</div>';
		}
		$html = $html == '' ? '' : "<div class=\"ft-body\">{$html}<div class=\"ink-clear\"></div></div>";
		return $html;
	});
}
/**
 * 首页轮播图
 * @return string
 */
function index_lunbo(){
	return \Blog\common\CacheUtils::cacheFile('lunbo', function(){
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
 * 最新的文章
 * @param unknown $category
 * @param number $count
 */
function new_blog($category, $count = 1){
	$articleModel = Registry::load('Common\\models\\Article');
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

function remark($article_id){
	$demo_config = Config::load('blog');
	if (!$demo_config['enable_remark']) {
		return false;
	}
	return "<div class=\"comments\"><div class='ds-thread' data-thread-key=\"art_{$article_id}\"></div></div>";
}

function custom_css(){
	return \Blog\common\CacheUtils::cacheFile('custom_css', function(){
		//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"\" />";
		$settingModel = Registry::load('Common\\models\\Setting');
		$cssSet = $settingModel->getSetting('custom_css', 'views');
		
		$css =  "<style type='text/css'>{$cssSet['setting_value']}</style>";
		// 写入缓存
		return $css;
	});
}

/**
 * 相关文章
 * @param $tags
 * @param $count
 * @return string
 */
function relate_article($article, $count){
    $tag_arr = array();
    foreach($article['tag'] as $tag){
        $tag_arr[] = $tag['id'];
    }

    $articleModel = Registry::load('Common\models\Article');
    $articles = $articleModel->getArticleRandomByTag($tag_arr, $count, $article['id']);

    $html = '';
    foreach($articles as $k=>$v){
        $html .= "<li><a href='" . url("article/{$v['id']}.html") . "'>{$v['title']}</a></li>";
    }
    if($html == ''){
        $html = '没有相关文章!';
    }
    return "<div class='relate-articles'><h4>相关文章</h4>{$html}</div>";
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

function tags_str($tags, $join_str = ','){
    if(is_null($tags) || count($tags) == 0){
        return '';
    }

    return implode($join_str, array_map(function($a){
        return $a['name'];
    }, $tags));
}