<?php

namespace Demo;
use Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class DemoBootstrap extends \Arsenals\ArsenalsBootstrap {

	public function run() {
		Route::map("^articles/lists/(:num)\.html$", '\\Demo\\controllers\\Articles@lists');
		Route::map('^articles/show/(:num)\.html$', '\\Demo\\controllers\\Articles@show');
		Route::map('^page/show/(:num)\.html$', '\\Demo\\controllers\\Page@show');
	}

}
