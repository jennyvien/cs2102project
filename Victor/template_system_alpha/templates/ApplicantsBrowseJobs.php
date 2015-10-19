<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page

session_start();

if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0){
	header("Location: ApplicantsLogin.php");
}

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
{%extends "base_applicant.html" %}

{%block content%}
<!-- Display all jobs with a link to the job page -->
<?php
	$sql = 'SELECT * FROM  JobOffers';
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
?>
<table id="table">
	<tr>
		<th>Title</th>
		<th>Company</th>
		<th>Salary</th>
		<th>Location</th>
	</tr>
<?php
	
	while ($row = oci_fetch_array($stid)){
		//Get company from employers
		$sql1="SELECT * FROM employers e WHERE e.email='" .$row["EMPLOYERS"]. "'";
		$stid1=oci_parse($dbh, $sql);
		oci_execute($stid1, OCI_DEFAULT);
		$employerInfo = oci_fetch_array($stid1);
		
		//Replace spaces with %20
		$job_title=str_replace(' ', '%20', $row["TITLE"]);
		$company=str_replace(' ', '%20', $employerInfo["COMPANY"]);
		$job_description=str_replace(' ', '%20', $row["DESCRIPTION"]);
		$city=str_replace(' ', '%20', $row["CITY"]);
		$country=str_replace(' ', '%20', $row["COUNTRY"]);
		$pos_type=str_replace(' ', '%20', $row["POS_TYPE"]);
		$employer = str_replace(" ", '%20', $row['EMPLOYERS']);
		$salary=$row["SALARY"];
		$jobnum=$row[7];
		
		//Start printing table
		echo "<tr>\n";
		
		echo "<td>".$row["TITLE"]."</td>\n";
		echo "<td>".$employerInfo["COMPANY"]."</td>\n";
		echo "<td>"."$".$row["SALARY"]."/year"."</td>\n";
		echo "<td>".$row["CITY"].", ".$row["COUNTRY"]."</td>\n";
		
		// URL for link to the specific job
		echo "<td>";
		echo "<a href=JobOfferDescription.php?";
		echo "job_title=";
		echo $job_title;
		echo "&company=";
		echo $company;
		echo "&jobnum=";
		echo $row["JOBNUM"];
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
		echo "&employer=";
		echo $employer;			
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
{% endblock %}