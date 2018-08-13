<?php
include_once 'sh-config.php';

function login($username, $password, $mysqli) {
    if ($stmt = $mysqli->prepare("SELECT id, username, dwp, institute_instituteID FROM users WHERE username = ? LIMIT 1")) {
        $stmt->bind_param('s', $username);  // Bind "$username" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $inst_id);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
              // Account is locked 
              // Send an email to user saying their account is locked
              return false;
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
              } else {
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/","",$username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                 return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts (users_id, time, users_institute_instituteID)VALUES ('$user_id', '$now', '$inst_id')");
                            return false;                         
                }
              }
        }else{
               // No user exists.
               return false;  
        }
    }else{
      return false;  
    }
  } 
function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'],$_SESSION['username'],$_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if ($stmt = $mysqli->prepare("SELECT dwp FROM users WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function getfield($field,$mysqli)
{
    $query = "SELECT `$field` FROM `users` WHERE `id` = '".$_SESSION['user_id']."'";
    //Run the query.
    if($query_run = mysqli_query($mysqli,$query)){
        //If the result exists. Pick the result.
        if($query_result = mysqli_fetch_assoc($query_run)){
            return $query_result[$field];  //Return the field that has been input. Remember not to enclose the field within quotes.
        }
    }
}//End

function logout($par){
    if (!$par == false){
        // Unset all session values 
        $_SESSION = array();
        
        // get session parameters 
        $params = session_get_cookie_params();
        
        // Delete the actual cookie. 
        setcookie(session_name(),
                '', time() - 42000, 
                $params["path"], 
                $params["domain"], 
                $params["secure"], 
                $params["httponly"]);
        
        // Destroy session 
        session_destroy();
        header('Location:./sims/?this=dXNldGhpc3RvbG9naW4=');
    }
    
}