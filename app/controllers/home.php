<?php
class home extends controller{
	protected $user;

	public function __construct(){
	}

	public function isredirect($page=''){
		if(isset($_SERVER['HTTP_REFERER'])){
			if(strcmp($_SERVER['HTTP_REFERER'],'http://localhost/seo/public/home/'.$page.'/')==0)
		       return true;
			else
			   return false;
		}
		else
			return false;
	}

	public function index(){
		if($this->isloggedin()){
           header('Location:'.URL.'/dashboard/main/');
		}
		else{
			if($this->isredirect('index'))$this->view('home/index',['message'=>'Invalid Email/Password!']);
			$this->view('home/index');
		}
	}

	public function register(){
		if($this->isloggedin()){
           header('Location:'.URL.'/dashboard/main/');
		}
		else{
			if($this->isredirect('register'))$this->view('home/register',['message'=>'Server Problem!']);
			$this->view('home/register');
		}
	}

	public function login(){
		if($this->isloggedin()){
			header('Location:'.URL.'/dashboard/main/');
		}
		else{
			$this->model('user');
			if(isset($_POST['email']) AND isset($_POST['pass'])){
				$user = $this->model('user');
				$user->email = $_POST['email'];
				$user->pass = $_POST['pass'];
				if($user->authenticate()){
					header('Location:'.URL.'/dashboard/main/');
				}
				else{
					header('Location:'.URL.'/home/index/');
				}
			}else{
				echo 'Invalid Data passed';
			}
		}
	}

	public function signup(){
		if($this->isloggedin()){
			header('Location:'.URL.'/dashboard/main/');
		}
		else{
			$this->model('user');
			if(isset($_POST['user_na']) && isset($_POST['email']) && isset($_POST['pass'])){
				$user = $this->model('user');
				$user->name = $_POST['user_na'];
				$user->email = $_POST['email'];
				$user->pass = $_POST['pass'];
				if(!$user->alreadyexists()){
					if($user->insertuser())
						header('Location:'.URL.'/home/index/');
					else
						header('Location:'.URL.'/home/register/');
				}
				else{
					header('Location:'.URL.'/home/register/');
				}
			}else{
				echo 'Invalid Data passed';
			}
		}
	}
}
?>