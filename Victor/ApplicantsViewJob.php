<?php
	session_start();
	if($_SESSION["Failed"] == 1){
		$fail_flag = 1;
		$_SESSION["Failed"] = 0;
	}
	else{
	}

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
					putenv('ORACLE_HOME=/oraclient');
					$dbh = ocilogon('a0110801', 'crse1510', '(DESCRIPTION =
						(ADDRESS_LIST =
						 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
						)
						(CONNECT_DATA =
						 (SERVICE_NAME = sid3.comp.nus.edu.sg)
						)
					  )');
					?>
					<?php
						if ($fail_flag == 1){
							echo "Incorrect login details.";
						}
						if (isset($_SESSION["TestData1"])){
							echo $_SESSION["TestData1"];

						}
					?>
					<form method="POST">
						Email: <input type="text" name="Email" id="Email"><br><br>
						Password: <input type="text" name="Password" id="Password"><br><br>
						<input type="submit" value = "Submit", name="Submit">
					</form>

					<!--TESTING-->

					<?php
						


						oci_free_statement($stid);
						oci_close($dbh);
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>