<?php

namespace Arsenals\Core\Abstracts;

use \Arsenals\Core\Registry;

if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 抽象Service
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
abstract class Service extends Arsenals {
	/**
	 * 加载模型
	 * 
	 * 如果模型名是以\\开头，则说明指定了命名空间，不再使用默认命名空间
	 * @param string $model_name
	 * @return Ambigous <object, mixed, multitype:>
	 */
	protected function model($model_name){
		if(!Registry::exist($model_name)){
			if (\Arsenals\Core\str_start_with($model_name, '\\')){
				$model = $model_name;
			}else{
				$model = MODEL_NAMESPACE . ucfirst($model_name);
			}
			Registry::register($model_name, new $model);
		}
		return Registry::get($model_name);
	}
}
