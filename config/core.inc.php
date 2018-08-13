<?php
	session_start();//Starting a session
	ob_start();
	$current_file = $_SERVER['SCRIPT_NAME'];
	
	/*
	*	Log in function for the administrators and the function
	* that grabs their information to help display it in their accounts
	*/
	function loggedin()
	{	
		//Check if the session has been created and it's not empty.
		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
			return true;
		}else{
			return false;
		}
	}
	
	function getfield($field)
	{
		require 'conn.php';	//Make the connection visible in the function so that we can access the database.
		$query = "SELECT `$field` FROM `user` WHERE `user_id` = '".$_SESSION['user_id']."'";
		//Run the query.
		if($query_run = mysqli_query($con,$query)){
			//If the result exists. Pick the result.
			if($query_result = mysqli_fetch_assoc($query_run)){
				return $query_result[$field];  //Return the field that has been input. Remember not to enclose the field within quotes.
			}
		}
	}//End
?>