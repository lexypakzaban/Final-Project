<!DOCTYPE html>
<html>
<head>
<title>Create Page</title>
<meta name="author" content="Lexy Pakzaban" >
	<link rel="stylesheet"type="text/css" href="style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Assistant|Playfair+Display" rel="stylesheet">
<style type="text/css">
	h1 {
		font-size: 50px;
		font-family: 'Playfair Display', serif;
		font-weight: 100;
		text-align: center;
		color: #ff3399;
	}

	h2 {
		font-family: 'Playfair Display', serif;
		font-weight: 100;
		color: #ff3399;
		}
		
	body {
		padding-bottom: 30px;
		padding-left: 30px;
		padding-right: 30px;
		color: black;
		font-size: 17px;
		font-family: 'Assistant', sans-serif;
		max-width: 1000px;
		margin-left: auto;
		margin-right: auto;
		}
		
	#menu li{
			display: inline
			}

	#menu{
			text-align: center;
	
			}
	
	#menu li a{
		font-family: 'Assistant', sans-serif;
		color: hotpink;
		font-weight: 100;
		font-size: 30px;
		text-decoration: none
		}
		
</style>
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
	
require("../social_media_connector.php");
//$command = $_REQUEST['command'];

echo("<h1>POST IT</h1>");

echo("<h2>Create A Post</h2>");

//------------------------------------------------

$command = $_REQUEST['command'];

if($command == "Delete")
{
	
	if (ISSET($_REQUEST['selection']))
	{
		$id = $_REQUEST['selection'];
		$query = "SELECT * FROM posts WHERE post_id = $id;";
		$query_result = mysqli_query($db_connection, $query);
		$row = mysqli_fetch_array($query_result);
		$message = $row['message'];
		$user_id = $row['user_id'];
		$date = $row['date'];
		
		echo("<form method = 'get' action = 'home.php'>\n");
		echo("<input type = 'hidden' name = 'post_id' value = '$id' />\n");
		echo("Are you sure you want to delete?\n");
		echo("<p><input type = 'submit' name = 'command' value = 'Cancel' />
					<input type = 'submit' name = 'command' value = 'Yes, Delete' /></p>\n");
		echo("</form>");
	}
	else 
	{ 
		echo("You need to select a post. <br /> <a href = 'home.php'>Return</a>");
	}
}

elseif($command == "Post")
{
	
	echo('<form method="get" action="home.php">');
	echo('<table class="center">');
	echo('<tr><td>Message</td><td><input type="text" name = "message" /></td></tr>');
	echo('</table>');
	echo('<input type="submit" name="command" value="Cancel" />');
	echo('<input type="submit" name="command" value="Post" />');
	echo('</form>');
}	
?>
</body>
</html>