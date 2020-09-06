<!DOCTYPE html>
<html>
<head>
<title>Content Page Example</title>
</head>
<body>
<?php
   // ----------------------------------------------------------------------------------------------------------------------
	// >>>>>>>> START code to check that user is logged in   <<<<<<<<<<
	$LOGIN_PAGE_URL = "Login.php";  // YOU SHOULD DO THIS --- update this with the url of your login page.	
	session_start();  // turn on the "session" - the server is storing information about this browser session for this user.
	
	if (isset($_SESSION['user_id'])) // 'user_id' is the piece of information we saved on the login page...
	{
		$user_id = $_SESSION['user_id']; // ... and we can use it in PHP queries for this user!
	}
	else
	{
		header("Location:".$LOGIN_PAGE_URL ); // jump NOW to the login page.
	}
	// >>>>>>>> END code to check that user is logged in   <<<<<<<<<<	
   // ----------------------------------------------------------------------------------------------------------------------
	// if the user isn't logged in, then they won't get here....	
		
		echo("Congrats! You have logged in."); // obviously optional.
		
	// here's a link that will let the user log out. (Also, if they quit their browser...)	You could also do this in the html section of this page.
	echo("<br /><a href='$LOGIN_PAGE_URL?command=logout'>Log out</a>");
?>

</body>
</html> 