<?php

namespace Demo;
use Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class DemoBootstrap extends \Arsenals\ArsenalsBootstrap {

	public function run() {
		Route::map("^articles/lists/(:num)", '\\Demo\\controllers\\Articles@lists');
		Route::map('^page/show/(:num)', '\\Demo\\controllers\\Page@show');
		Route::map('市场活动', '\\Demo\\controllers\\Page@show', 1);
		Route::map('^原创音乐$', function($media, $action){
			return "这里是原创音乐:{$media} {$action}";
		}, "MP3", "play");
	}

}
