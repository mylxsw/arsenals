<?php

namespace Blog;
use Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class BlogBootstrap extends \Arsenals\ArsenalsBootstrap {

	public function run() {
        /*
		header("Access-Control-Allow-Origin: *");
		Route::map("^$", '\Demo\controllers\Index@basic');
		Route::map(".html$", '\Demo\controllers\Index@basic');
		*/
        Route::map("^category_(:num)\.html$", '\\Demo\\controllers\\Articles@lists');
		Route::map('^home.html$', '\Demo\controllers\Index@index');
		Route::map('^article_(:num)\.html$', '\\Demo\\controllers\\Articles@show');
		Route::map('^page_(:num)\.html$', '\\Demo\\controllers\\Page@show');
	}

}
