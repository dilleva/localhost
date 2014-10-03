<?php
session_start();

if(isset($_POST['email'])){

	include ('connect.php');

	# make a variable out of the username that was posted in the index-page.

	$email = $_POST['email'];

	# I am not sure what this thing makes.. but it has something with safety to do.

	$escaped_username = mysql_real_escape_string($email);

	# make a md5 password.

	$md5_password = md5(mysql_real_escape_string($_POST['password']));

	$sql = "select * from user where email = '".$email."' and pass = '".$md5_password."' LIMIT 0, 1";
	//echo $sql;
	//exit;
	
	$query = mysql_query($sql);

	if(mysql_num_rows($query) == 1){
		$result = mysql_fetch_assoc($query);	
		while ($row = $result) {		
		$_SESSION['user']['id'] = $row["id"];
		$_SESSION['user']['first'] = $row["first"];	
		$_SESSION['user']['last'] = $row["last"];	
		$_SESSION['user']['phone'] = $row["phone"];	
		$_SESSION['user']['email'] = $row["email"];	
		$_SESSION['user']['credits'] = $row["balance"];	
				
		//header("Location: /");
		?><script>
			window.parent.location.reload();
		</script><?php
		exit;
		}
	}
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="reset.css" />
	<link rel="stylesheet" href="login-dark.css" />
	
	<!--[if lt IE 9]>
	    	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	    	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	
	<div id="loginform">
		<form action="" class="login-form tbbar dblue" method="POST">
			<h3 class="tbar"><strong>Server</strong> Login</h3>
			
			<label for="username">Email</label>
			<input type="email" name="email" autofocus class="login-input" autocomplete="off" required />
			
			<label for="password">Password</label>
			<input type="password" name="password" class="login-input" autocomplete="off" required />
			
			<div class="bbar">
				<!--<span class="forgot">Forgot <a href="#">Username</a> / <a href="#">Password</a></span>-->
				
				<a href="../" target="_parent"><input type="button" class="login-btn" value="Cancel"/></a>
				<input type="submit" class="login-btn" value="Login" required />
			</div>
		</form>
	</div>
	
	<script src="js/jquery.min.js"></script>
	<script src="js/placeholder.js"></script>
	<script>
		$(function(){
			if( !$.browser.firefox ) {
				$('form.login-form').each(function(){
					$(this).find('input.login-input').bind('invalid', function(){
						$(this).addClass('invalid');
					});
				});
			}
		});
	</script>
	
	
</body>
</html>