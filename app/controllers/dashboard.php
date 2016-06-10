<?php
class dashboard extends controller{
	public function main(){
		if($this->isloggedin()){
			$this->view('dashboard/main');
		}else{
			header('Location:'.URL.'/home/index/');
		}
	}

	public function logout(){
		//session_start();
		session_destroy();
		header('Location:'.URL.'/home/index/');
	}
}
?>