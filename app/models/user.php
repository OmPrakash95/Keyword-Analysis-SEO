<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class user extends Eloquent{
	public $id;
	public $name;
	public $email;
	public $pass;
	protected $timestamp = [];
	protected $fillable=['id','name','email','pass'];
	protected $table = 'users';
	public function authenticate(){
		if(isset($this->email)&&isset($this->pass)){
			try{
				$users = user::where('email',$this->email)->firstOrFail();
				$record = $users->getAttributes();
				$ret_email = $record['email'];
			    $ret_pass = $record['pass'];
			    $mdfied = md5($this->pass);
			    if(strcmp($ret_pass, $mdfied)==0){
			    	$_SESSION['token']=md5($record['email']);
			    	$_SESSION['id']=$record['id'];
			    	$_SESSION['name']=$record['name'];
					return true;
				}
				else 
					return false;
			}catch(Exception $e){
				return false;
				//echo "Exception caught:".$e->getMessage();
			}
		}
		else return false;
	}

	public function insertuser(){
		if(isset($this->name)&&isset($this->email)&&isset($this->pass)){
			try{
				echo $this->name.' '.$this->email.' '.$this->pass;
				$result = $this->create([
			           		'name'=>$this->name,
							'email'=>$this->email,
							'pass'=>md5($this->pass)
							]);
				if($result)return true;
			}catch(Exception $e){
				echo $e->getMessage();
				return false;
			}
		}
		else
			return false;
	}

	public function alreadyexists(){
		if(isset($this->name)&&isset($this->email)&&isset($this->pass)){
			try{
				$users = user::where('email',$this->email)->first();
				if($users){
					return true;
				}else return false;
			}catch(Exception $e){
				echo "Gone";
			}
		}
		else return false;
	}

}
?>