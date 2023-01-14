<?php
/**
 * 
 */
class Chatuser
{
	private $user_id;
	private $user_name;
	private $user_fname;
	private $user_lname;
	private $user_email;
	private $user_mobile;
	private $user_password;
	private $user_profile;
	private $user_status;
	private $user_verification_code;
	private $user_login_status;
	private $user_created_on;
	public $connect;

	
	function __construct()
	{
		// code...
		require_once('dbconn.php');
		 $db_obj= new Database_connection;
		 $this->connect=$db_obj->connect();
	}
	function setUserId($user_id){
		$this->user_id=$user_id;
	}
	function getUserId(){
		 return $this->user_id;
	}
	function setUserName($user_name){
		$this->user_name=$user_name;
	}
	function getUserName(){
		 return $this->user_name;
	}
	function setUserFname($user_fname){
		$this->user_fname=$user_fname;
	}
	function getUserFname(){
		 return $this->user_fname;
	}
	function setUserLname($user_lname){
		$this->user_lname=$user_lname;
	}
	function getUserLname(){
		 return $this->user_lname;
	}
	function setUserEmail($user_email){
		$this->user_email=$user_email;
	}
	function getUserEmail(){
		 return $this->user_email;
	}
	function setUserMobile($user_mobile){
		$this->user_mobile=$user_mobile;
	}
	function getUserMobile(){
		 return $this->user_mobile;
	}
	function setUserPwd($user_password){
		$this->user_password=$user_password;
	}
	function getUserPwd(){
		 return $this->user_password;
	}
	function setUserProfile($user_profile){
		$this->user_profile=$user_profile;
	}
	function getUserProfile(){
		 return $this->user_profile;
	}
	function setUserStatus($user_status){
		$this->user_status=$user_status;
	}
	function getUserStatus(){
		 return $this->user_status;
	}
	function setVerifyCode($user_verification_code){
		$this->user_verification_code=$user_verification_code;
	}
	function getVerifyCode(){
		 return $this->user_verification_code;
	}
	function setUserLoginStatus($user_login_status){
		$this->user_login_status=$user_login_status;
	}
	function getUserLoginStatus(){
		 return $this->user_login_status;
	}
	function setUserCreatedOn($user_created_on){
		$this->user_created_on=$user_created_on;
	}
	function getUserCreatedOn(){
		 return $this->user_created_on;
	}

	function get_user_data_by_email(){
		$query="SELECT * FROM user_info where user_email=:user_email ";

		$statement =$this->connect->prepare($query);

		$statement->bindParam(':user_email',$this->user_email);

		if($statement->execute()){
			$user_data=$statement->fetch(PDO::FETCH_ASSOC);
		}
		return $user_data;
	}

	function uniq_user(){
		$query = "SELECT * FROM user_info WHERE user_name = :user_name";
    	$statement=$this->connect->prepare($query);
    	
    	$statement->bindParam(':user_name',$this->user_name);
    	if($statement->execute()){
        // $exists = true;
    		$user_data=$statement->fetch(PDO::FETCH_ASSOC);
    		$user=(is_array($user_data)&& count($user_data)>0)?true:false;
    		return $user;

       }
	}
	function save_Data(){
		$query="INSERT INTO user_info (user_name,user_email,user_password,user_status,user_created_on,user_verification_code) VALUES (:user_name,:user_email,:user_password,:user_status,:user_created_on,:user_verification_code)";
		$statement=$this->connect->prepare($query);

		$statement->bindParam(':user_name',$this->user_name);

		$statement->bindParam(':user_email',$this->user_email);

		$statement->bindParam(':user_password',$this->user_password);

		$statement->bindParam(':user_status',$this->user_status);

		$statement->bindParam(':user_created_on',$this->user_created_on);

		$statement->bindParam(':user_verification_code',$this->user_verification_code);

		if($statement->execute()){
			return true;
		}
		else{
			return false;		}

	}
	function is_code_verified(){
		$query="SELECT * FROM user_info where user_verification_code=:user_verification_code";

		$statement=$this->connect->prepare($query);

		$statement->bindParam(':user_verification_code',$this->user_verification_code);

		$statement->execute();

		$statement->fetch(PDO::FETCH_ASSOC);

		if($statement->rowCount()>0){
			return true;
		}
		
		else{
			return false;		}

	}
	function enable_account(){
		
		$query="UPDATE user_info SET user_status=:user_status where user_verification_code=:user_verification_code";

		$statement=$this->connect->prepare($query);

		$statement->bindParam(':user_verification_code',$this->user_verification_code);

		$statement->bindParam(':user_status',$this->user_status);

		if($statement->execute()){
			return true;
		}
		else{
			return false;
		}

	}
}
?>