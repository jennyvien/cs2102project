<?php
	session_start();
	if($_SESSION["Failed"] == 1){
		$fail_flag = 1;
		$_SESSION["Failed"] = 0;
	}
	elseif($_SESSION["LoggedIn"]==1 and $_SESSION["Applicant"] ==1){
		header("Location: ApplicantsPortal.php");
	}
	else{
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

{%block content %}
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
	Password: <input type="password" name="Password" id="Password"><br><br>
	<input type="submit" value = "Submit", name="Submit">
	testtesttest
</form>

<!--TESTING-->

<?php
	echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';
	echo "POST: <br>";
	echo '<pre>';
	var_dump($_POST);
	echo '</pre>';
	//Currently might be vulnerable to SQL injection
	$sql = "SELECT * FROM Applicants";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid);
	echo oci_num_rows($stid);
	if (oci_execute($stid)){ 
    usleep(100); 
    echo "<TABLE border \"1\">"; 
    $first = 0; 
    while ($row = @oci_fetch_assoc($stid)){ 
            if (!$first){ 
                    $first = 1; 
                    echo "<TR><TH>"; 
                    echo implode("</TH><TH>",array_keys($row)); 
                    echo "</TH></TR>\n"; 
            } 
            echo "<TR><TD>"; 
            echo @implode("</TD><TD>",array_values($row)); 
            echo "</TD></TR>\n"; 
    } 
    echo "</TABLE>"; 
}
$email = "asd";
$password = "ddd";
$sql = "SELECT * FROM  Applicants
			WHERE email = :email and
			password = :password";
	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ":email", $email);
	oci_bind_by_name($stid, ":password", $password);
	oci_execute($stid);
	$data = oci_fetch_array($stid);
	var_dump($data);
	echo count($data);
?>

<?php
if(isset($_POST['Submit']))
{
	//Currently might be vulnerable to SQL injection
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
		$_SESSION["Applicant"] = 1;
		$_SESSION["Employer"] = 0;

		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ApplicantsLoginResult.php">';
	}
	else{
		$_SESSION["Failed"] = 1;
	}
	oci_free_statement($stid);
	oci_close($dbh);
}


?>
{% endblock%}