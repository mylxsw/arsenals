<?php

namespace Dlroom;
use Arsenals\Core\Registry;
use \Arsenals\Core\Router as Route;

require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';

class DlroomBootstrap extends \Arsenals\ArsenalsBootstrap {

    public function run() {

        Route::map("^$", '\Dlroom\controllers\Index@index');
        Route::stop();
    }

}
