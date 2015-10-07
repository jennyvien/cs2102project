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
<!-- Apply for a specific job (from browse screen) -->
<html>
<head> <title> Job Application </title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body bgcolor="#D8D8D8">
<table>
<tr> <td column = '100'>
<h1> Job Application</h1>
</td> </tr>
</table>

<form method="POST">

	Email: <input type="text" name="Email" id="Email"> <br><br>
	Password: <input type="text" name ="Password" id = "Password"><br><br>
	Write Up:<br>	
	<textarea rows="4" cols="50" name="WriteUp" id="WriteUp">
	Write up..</textarea><br>
	<input type="submit" name="formSubmit" value="Submit">
</form>

<?php

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
?>

<?php
if(isset($_POST['formSubmit']))
{
	$jobnum = $_GET['jobnum'];
	date_default_timezone_set('UTC');


	$sql1 = "select count(*) from applicants where email='".$_POST['Email']."' and password='".$_POST['Password']."'";
	$stid1 = oci_parse($dbh, $sql1);
	oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
	$row = oci_fetch_array($stid1);
	echo "still okay";


	if ($row>0){

		$sql = "Insert into Applications values('".$_POST['Email']."',sysdate,'".$_POST['WriteUp']."','".$_GET['employer']."', '".$_GET['jobnum']."')";
		$stid= oci_parse($dbh, $sql);
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
	}else{
		echo "Cannot find user";
	}
	oci_free_statement($stid1);

	echo "<meta http-equiv=\"refresh\" content=\"0;JobOffers.php\">";	
}
?>
<?php
oci_close($dbh);
?>

</body>
</html>