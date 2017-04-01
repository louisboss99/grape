<?php
include 'lib/sql-connect.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
# If method isn't POST, display 404.
include 'lib/404.php'; }
else {

		if(empty($_SESSION['pid'])) {
            $error_message[] = 'You are not logged in.\nLog in to update profiles.';
			$error_code[] = '1512005';
        }
	if(!empty($error_code) || !empty($error_message) ) /*Got errors?*/
    {
		// JSON response for errors.
			http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
			print '{"success":0,"errors":[{"message":"' . $error_message[0] . '","error_code":' . $error_code[0] . '}],"code":"400"}';
			print "\n";
			exit();
    }

        $sql_update_profile = 'UPDATE grape.profiles SET profiles.favorite_screenshot = NULL WHERE profiles.pid = "'.$_SESSION['pid'].'"';	
	    $result_update_profile = mysqli_query($link, $sql_update_profile);
        if(!$result_update_profile)
        {
            //MySQL error; JSON response.
			http_response_code(400);  
			header('Content-Type: application/json; charset=utf-8');
			
			// Enable in debug
			#print $sql_update;
			#print "\n\n";			
			
			print '{"success":0,"errors":[{"message":"A database error has occurred.\nPlease try again later, or report the\nerror code to the webmaster.","error_code":160' . mysqli_errno($link) . '}],"code":"500"}';
			print "\n";
		}
		else { 
header('Content-Type: application/json; charset=utf-8');
print '{"success":1}'; 
}
}

?>