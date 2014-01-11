<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Registry;
/**
 * 抽象Service
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
abstract class Service extends Arsenals {
	
	protected function model($model_name){
		if(!Registry::exist($model_name)){
			$model = MODEL_NAMESPACE . ucfirst($model_name);
			Registry::register($model_name, new $model);
		}
		return Registry::get($model_name);
	}
}
