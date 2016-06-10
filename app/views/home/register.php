<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Keyword Analysis Web application - Register</title>
		<meta name="description" content="">
		<meta name="author" content="Om Prakash">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        

		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

        <link href="http://localhost/seo/public/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://localhost/seo/public/js/bootstrap.min.js"></script>

	</head>
	<body>
	<h3>Register</h3>
	<span id="message"><?php if(isset($data['message']))echo $data['message']; ?></span>
	<form name="signup" action="http://localhost/seo/public/home/signup/" method="POST">
	    <input type="text" name="user_na" id="user_na" placeholder="Enter name"/>
	    <input type="text" name="email" id="email" placeholder="Enter Email"/>
		<input type="password" name="pass" id="pass" placeholder="Enter Password"/>
		<input type="submit" value="Register"/><br><a href="http://localhost/seo/public/home/index/">Login</a>
	</form>
	</body>
</html>