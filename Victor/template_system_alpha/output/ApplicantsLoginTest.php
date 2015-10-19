<?php
	session_start();
 ?>
<?php
$ora_acc = file_get_contents('oracle_acc.ini');
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon($ora_acc, 'crse1510', '(DESCRIPTION =
	(ADDRESS_LIST =
	 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
	)
	(CONNECT_DATA =
	 (SERVICE_NAME = sid3.comp.nus.edu.sg)
	)
  )');
?>
 
<html>
<head> <title> Applicant Login </title> 

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
				<h1 class="title"> Applicant Login</h1>
			</div>
			<div class="row">
				<div class="col-xs-offset-2 col-xs-8">
					<?php
						if ($_SESSION["LoggedIn"] == 1){
							echo "Welcome ";
							echo $SESSION["Username"];
							echo ", You are now Logged in";
						}
						else {
							echo "You are not logged in, access denied"
						}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>