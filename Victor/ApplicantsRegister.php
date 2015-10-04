<!-- Register a new applicant -->

<html>
<head> <title> Register Applicants </title> 

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
					<form method="POST">
						Name: <input type="text" name="Name" id="Name"><br><br>
						Email: <input type="text" name="Email" id="Email"><br><br>
						Phone Number: <input type="text" name="Number" id="Number"><br><br>
						Password: <input type="text" name="Password" id="Password"><br><br>
						Resume: <br>
						<textarea rows="4" cols="50" name="Resume" id="Resume">Enter Resume here...</textarea><br>
					    <input type="submit" name="Submission" value="Submit">
					</form>
					<?php
					if(isset($_POST['Submission']))
					{
						$sql = "insert into Applicants values ('".$_POST['Name']."','".$_POST['Email']."','".$_POST['Number']."','".$_POST['Password']."','".$_POST['Resume']."')";
						$stid = oci_parse($dbh, $sql);
						oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
						oci_free_statement($stid);
						echo "<meta http-equiv=\"refresh\" content=\"0;JobOffers.php\">";	
					}
					?>
					<?php
					oci_close($dbh);
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>