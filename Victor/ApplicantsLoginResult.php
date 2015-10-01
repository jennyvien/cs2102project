<?php session_start()?>
<html>
<head> <title> Welcome </title> 

<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container-fluid tiffblue">
		<div class="col-xs-offset-3 col-xs-6">
			<div class="row">
				<h1 class="title"> Register as Applicants</h1>
			</div>
			<div class="row">
				<div class="col-xs-offset-2 col-xs-8">
					<?php
						
							echo "Welcome ".$_SESSION["Username"].", you are now logged in."
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>