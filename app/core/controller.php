<?php
class controller{
	public function model($model){
		require_once '../app/models/'.$model.'.php';
		return new $model();
	}

	public function view($view,$data = []){
		require_once '../app/views/'. $view . '.php';
	}

	public function isloggedin(){
		if(isset($_SESSION['token'])&&!empty($_SESSION['token']))
			 return true;
		else return false;
	}
}
?>