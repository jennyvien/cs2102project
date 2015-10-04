<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Applicant"] == 1){
	header("Location: EmployersLogin.php");
}
?>

<!-- Basic portal style access for applicants. Is a placeholder till we get proper sidebars -->

<html>
<head> <title> Employer portal </title> 

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
				<h1 class="title"> Employer Portal</h1>
			</div>
			<div class="row">
				<div class="col-xs-offset-2 col-xs-8">
					<?php
							echo "Welcome, applicant ".$_SESSION["Username"].".<br>";
					?>
					 <a href="EmployerSubmitOffer.php">Submit a job offer</a> <br>
					 <a href="EmployerViewApplications" >View applications to your job offers</a> <br>
					 <a href="Logout.php"> Logout </a> <br>
				</div>
			</div>
		</div>
	</div>
</body>
</html>