<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Keyword Analysis Web application</title>
		<meta name="description" content="">
		<meta name="author" content="Om Prakash">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        

		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <link href="http://localhost/seo/public/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://localhost/seo/public/js/bootstrap.min.js"></script>
		<link href="http://localhost/seo/public/css/login.min.css" rel="stylesheet">
		<!--<script src="http://localhost/seo/public/css/login.min.js"></script>-->
	</head>
	<body>
	<div class="container">
  		<div class="row" id="pwd-container">
    		<div class="col-md-4">  
    		</div>
      			  <div class="col-md-4">
    				 <section class="login-form">
        				<form method="post" action="http://localhost/seo/public/home/login/" role="login" name="login">
        				<h4 class="text-center"><span id="message"><code><?php if(isset($data['message']))echo $data['message']; ?></code></span></h4>
         	 				<h3 class="text-center">Login</h3>
          					<input type="email" name="email" placeholder="Email" required class="form-control input-lg"/>
           					<input type="password" class="form-control input-lg" name="pass" id="pass" placeholder="Password" required=""/>
          				    <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block">
          						<div>
            						<a href="http://localhost/seo/public/home/register/">Create account</a>
          						</div>
           				</form>
     				 </section>  
      				</div>
  	    	      <div class="col-md-4">
    	  	      </div>     

  		</div>  
	</div>
	</body>
</html>