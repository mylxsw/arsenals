<?php
namespace Blog\controllers;
use Arsenals\Core\Abstracts\Controller;
use Arsenals\Core\Registry;

abstract class CoreController extends Controller{
	protected function model($model_name){
		if(!Registry::exist($model_name)){
			if (\Arsenals\Core\str_start_with($model_name, '\\')){
				$model = $model_name;
			}else{
				$model = 'Common\\models\\' . ucfirst($model_name);
			}
			Registry::register($model_name, new $model);
		}
		return Registry::get($model_name);
	}
}