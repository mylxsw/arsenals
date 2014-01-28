<?php
namespace Admin;
use Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class AdminBootstrap extends \Arsenals\ArsenalsBootstrap {

	public function run() {
		Route::map('/', 'Admin\\controllers\\Index@main');
	}

}