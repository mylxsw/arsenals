<?php
namespace Arsenals\Libraries\Twig;

use \Arsenals\Core\Views\View;
use \Arsenals\Core\Config;
/**
 * Twig 视图层实现
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class TwigView implements View {
	private $_twig;
	public function __construct(){
		!defined('TWIG_LIB') && define('TWIG_LIB', ARSENALS_LIBRARIES_PATH . 'Twig' . DIRECTORY_SEPARATOR . 'Twig' . DIRECTORY_SEPARATOR . 'Autoloader.php'); 
		include TWIG_LIB;
		\Twig_Autoloader::register();
		$this->_twig = new \Twig_Environment(new \Twig_Loader_Filesystem(VIEW_PATH),
						array(
							'debug'		=> true,
							'charset'	=> 'utf-8',
							'base_template_class'	=> 'Twig_Template',
							'cache'					=> APP_PATH . 'caches',
							'auto_reload'			=> true,
							'strict_variables'		=> false,
							'autoescape'			=> true,
							'optimizations'			=> -1
						));
	}

	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Views\View::parse()
	 */
	public function parse(\Arsenals\Core\Views\ViewAndModel $vm) {
		$config = Config::load('config');
		$_view_path = VIEW_PATH . ($config['multi_theme'] ? $config['theme'] . DIRECTORY_SEPARATOR : '');
		if(file_exists("{$_view_path}functions.php")){
			include "{$_view_path}functions.php";
		}
		return $this->_twig->render($config['theme'] . DIRECTORY_SEPARATOR . $vm->getView() . '.html', $vm->getDatas());		
	}


	
}