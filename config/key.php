<?php
include 'real-config.php';
function random($length, $chars = '')
{
	if (!$chars) {
		$chars = implode(range('a','f'));
		$chars .= implode(range('0','9'));
	}
	$shuffled = str_shuffle($chars);
	return substr($shuffled, 0, $length);
}
function serialkey()
{
	return random(4).'-'.random(4).'-'.random(4).'-'.random(4);
}

for ($x = 0; $x <= 10; $x++) {
    $k = strtoupper(serialkey());
    $ip = $_SERVER['REMOTE_ADDR'];
	$name =  gethostbyaddr($ip);
   // echo $k."</br>";
  // $mysqli->query("UPDATE `ethusiast` SET `status` = 'A'");

} 

//$serial =  shell_exec('c:\path\to\wmic.exe DISKDRIVE GET SerialNumber 2>&1');$serial =  shell_exec('c:\path\to\wmic.exe DISKDRIVE GET SerialNumber 2>&1');
//echo $serial;
//echo $ip."<br>";
function check_inst($inst_name){
	include 'real-config.php';
    $query = "SELECT * FROM institute WHERE institute_name = '".$inst_name."'";
    $query_run = mysqli_query($mysqli,$query);
	if(!$query_run){
		echo    "Query Run Error".mysqli_error($mysqli);
		}else{
			$num_of_rows = mysqli_num_rows($query_run);
			if($num_of_rows == 1){
				  return true;
			}else{
				  return false;
			}
    }
}
    
check_serial()


?>

