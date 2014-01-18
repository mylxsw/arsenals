<?php

namespace Demo;
use Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class DemoBootstrap extends \Arsenals\ArsenalsBootstrap {

	public function run() {
		Route::map("art", '\\Demo\\controllers\\Articles@lists');
		Route::map("articles/lists", function ($input){
			return $input->get("cat");
		});
	}

}
