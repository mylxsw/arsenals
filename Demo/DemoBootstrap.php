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

	// public function clear(){
		
	// 	$classStr = "<?php class Category_override extends \\Common\\models\\Category{";
	// 	$reflectionClass = new \ReflectionClass('\Common\models\Category');
	// 	$methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

	// 	$file = file(BASE_PATH . '/Common/models/Category.ts');
	// 	$trans = array();
	// 	foreach($file as &$line){
	// 		$doc_pos = strpos($line, '#');
	// 		$content = trim(substr($line, 0, $doc_pos === false ? strlen($line) : $doc_pos));
	// 		if($content != ''){
	// 			array_push($trans, $content);
	// 		}
	// 	}

	// 	foreach ($methods as $key => $value) {
	// 		$method_name = $value->getName();
	// 		if(in_array($method_name, $trans)){
	// 			$params = $value->getParameters();
	// 			$p_html_1 = '';
	// 			$p_html_2 = '';
	// 			foreach($params as $k=>$v){
	// 				$p_html_1 .= '$' . $v->getName();
	// 				$p_html_2 .= '$' . $v->getName();
	// 				if($v->isOptional()){
	// 					$p_html_1 .= '=' . var_export($v->getDefaultValue(), true);
	// 				}
	// 				$p_html_1 .= ',';
	// 				$p_html_2 .= ',';
	// 			}
	// 			$p_html_1 = trim($p_html_1, ',');
	// 			$p_html_2 = trim($p_html_2, ',');

	// 			$classStr .= "public function " . $method_name . " ( $p_html_1 ){";
	// 			$classStr .= "try{ \$this->_conn->trans(false);";
	// 			$classStr .= "\$res =  parent::" . $method_name . "($p_html_2); \$this->_conn->commit();";
	// 			$classStr .= "}catch(\\Exception \$e){ \$this->_conn->rollback();}";

	// 			$classStr .= "} ";
	// 		}
	// 	}

	// 	echo $classStr . "}";
	// }
}
