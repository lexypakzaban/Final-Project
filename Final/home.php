<!DOCTYPE html>
<html>
<head>
<title>Home Page</title>
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
	table { border-spacing: 0;
			text-align: center;}
	td { border: 1px solid black;
		padding: 20px;}
	table.center {
		margin-left:auto; 
		margin-right:auto;}
		
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

echo("<h1>POST IT</h1>");

//---------------------------------
// DECIDE WHAT THE COMMAND IS...
if(ISSET($_REQUEST['command']))
{
	$command = $_REQUEST['command'];
}

else 
{
	$command = "None";
}

//IF COMMAND IS "SEARCH"...
if($command == "Search") 
{
	$target = $_REQUEST['target'];
	echo("<h2>Seaching for $target</h2>\n");
	$query = "SELECT * FROM posts INNER JOIN users USING (user_id) WHERE message LIKE '%$target%';";
}
else 
{
	$query = "SELECT * FROM posts INNER JOIN users USING (user_id)";
}
	
//IF COMMAND IS "POST"...
if($command == "Post")
{
	$message_to_post = $_REQUEST['message'];
	//$username_to_post = $_REQUEST['username'];
	$date_to_post = date("Y-m-d h:i:s");
	
	$add_query = "INSERT INTO posts (message, user_id, date) VALUES ('$message_to_post', '$user_id', '$date_to_post');";
	$add_succeeded = mysqli_query($db_connection, $add_query);
}

// IF COMMAND IS "YES, DELETE"...
if($command == "Yes, Delete")
{
	$id = $_REQUEST['post_id'];
	$delete_query = "DELETE FROM posts WHERE post_id = $id ;";
	
	$delete_succeeded = mysqli_query($db_connection, $delete_query);
	if ($delete_succeeded == true)
	{
		echo("<p>Deleted.</p>\n");
	}
	
}

//------------ DISPLAY THE POSTS

//$query = "SELECT * FROM posts INNER JOIN users USING (user_id)";
$query_result = mysqli_query($db_connection, $query);
echo("<form method='get' action = 'create.php'>\n");
echo("<table class='center'>\n");
echo("<tr><th>Select</th><th>Message</th><th>User</th><th>Date</th></tr>\n");
while($row=mysqli_fetch_array($query_result))
{
	$id = $row['post_id'];
	$message = $row['message'];
	$username = $row['username'];
	$date = $row['date'];
	
	echo("<tr><td><input type='radio' name='selection' value='$id'></td><td>$message</td><td>$username</td><td>$date</td></tr>\n");
}
echo ("</table>");
echo("<input type = 'submit' name='command' value = 'Delete' />
		<input type = 'submit' name='command' value = 'Post' />\n");
echo("</form>\n");

?>

<form method="get" action="">
Search for: <input type="search" name="target" />
<input type="submit" name="command" value="Search" />
<input type="submit" name="command" value="Show All" />
</form>

</body>
</html>