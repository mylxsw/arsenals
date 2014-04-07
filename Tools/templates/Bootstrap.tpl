<?php
namespace [[namespace]];
use Arsenals\ArsenalsBootstrap;
use \Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class Bootstrap extends ArsenalsBootstrap{
	/* (non-PHPdoc)
	 * @see \Arsenals\ArsenalsBootstrap::run()
	 */
	public function run() {
		Route::map('', function(){

		});
		
	}
}