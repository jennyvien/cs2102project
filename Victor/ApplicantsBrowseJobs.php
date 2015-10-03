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
<head> <title> All Jobs </title> 

<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<style>
	#table, #table tr, #table td, #table th {
		border: 1px solid black;
		padding: 0.4em;
	}
</style>
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
					<!-- Display all jobs with a link to the job page -->
					<?php
						/*$sql = "INSERT INTO JobOffers
						(EMPLOYERS, TITLE, KEYWORDS, DESCRIPTION, CITY, COUNTRY, AREA_CODE,
						POS_TYPE, SALARY)
						VALUES
						'esyir', 'esyir_title', 'key', 'description', 'city', 'country', 20, 'part',
						1000000 ";*/
						$sql = 'SELECT * FROM  JobOffers';
						$stid = oci_parse($dbh, $sql);
						oci_execute($stid);

					?>
					<table id="table">
						<tr>
							<th>Title</th>
							<th>Employer</th>
							<th>Salary</th>
							<th>Location</th>
						</tr>
					<?php
						
						while ($row = oci_fetch_array($stid)){
							//var_dump($row);
							$job_title=str_replace(' ', '%20', $row["TITLE"]);
							$employer=str_replace(' ', '%20', $row["EMPLOYERS"]);
							$job_description=str_replace(' ', '%20', $row["DESCRIPTION"]);
							$city=str_replace(' ', '%20', $row["CITY"]);
							$country=str_replace(' ', '%20', $row["COUNTRY"]);
							$pos_type=str_replace(' ', '%20', $row["POS_TYPE"]);
							$salary=$row["SALARY"];
							$jobnum=$row[7];
							echo "<tr>\n";

							echo "<td>".$employer."</td>\n";
							echo "<td>".$job_title."</td>\n";
							echo "<td>".$salary."</td>\n";
							echo "<td>".$city.", ".$country."</td>\n";
							
							// URL for link to the specific job
							echo "<td>";
							echo "<a href=JobOfferDescription.php?";
							echo "job_title=";
							echo $job_title;
							echo "&employer=";
							echo $employer;
							echo "&jobnum=";
							echo bin2hex($row["JOBNUM"]);
							echo "&description=";
							echo $job_description;
							echo "&city=";
							echo $city;
							echo "&country=";
							echo $country;
							echo "&pos_type=";
							echo $pos_type;	
							echo "&salary=";
							echo $salary;			
							echo ">"; 
							echo "LINK";
							echo "</a>";
							echo "</td>";
							echo "</td>\n";

							echo "</tr>\n";
						}
						
						oci_free_statement($stid);
						oci_close($dbh);
					?>
					</table>

					<?php
					if(isset($_POST['Submit']))
					{
						//Not vulnerable to sql injection
						$sql = 'SELECT * FROM  Applicants
								WHERE email = :email and
								password = :password' ;
						$stid = oci_parse($dbh, $sql);
						oci_bind_by_name($stid, ":email", $_POST["Email"]);
						oci_bind_by_name($stid, ":password", $_POST["Password"]);
						oci_execute($stid);
						$data = oci_fetch_array($stid);
						if (count($data) >1)
						{
							$_SESSION["LoggedIn"] = 1;
							$_SESSION["Username"] = $data["NAME"];
							$_SESSION["Email"] = $data["EMAIL"];
							echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ApplicantsLoginResult.php">';
						}
						else{
							$_SESSION["Failed"] = 1;
						}
						oci_free_statement($stid);
						oci_close($dbh);
					}
				

					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>