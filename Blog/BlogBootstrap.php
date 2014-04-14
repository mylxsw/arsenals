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
        Route::map("^category/(:num)\.html$", '\Blog\controllers\Articles@lists');
		Route::map('^home.html$', '\Blog\controllers\Index@index');
		Route::map('^article/(:num)\.html$', '\Blog\controllers\Articles@show');
        Route::map('^page/(:num)\.html$', '\Blog\controllers\Page@show');
        Route::map('^kuaijianli\.html$', '\Blog\controllers\Open@kuaijianli');
	}

}
