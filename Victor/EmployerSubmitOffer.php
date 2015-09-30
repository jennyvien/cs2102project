<html>
<head> <title> Submit Job Offer as Employer </title>
<body bgcolor="pink">
<table>
    <tr> <td column = '100'>
            <h1> Submit Job Offer as Employer </h1>
        </td> </tr>
</table>
<?php
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('e0009809', 'crse1510', '(DESCRIPTION =
	(ADDRESS_LIST =
	 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
	)
	(CONNECT_DATA =
	 (SERVICE_NAME = sid3.comp.nus.edu.sg)
	)
  )');
?>

<form>
    Login via Email: <input type="text" name="email" id="email"><br><br>
    Password:<input type="text" name="Password" id="Password"><br><br>
    Create a job number:<input type="number" name="jobnum" id="jobnum"><br><br> <!--Should generate automatically later-->
    Your name:<input type="text" name="Employers" id="Employers"><br><br> <!--Maybe indicate name after login?-->
    Title of the job:<input type="text" name="title" id="title"><br><br>
    Some keywords about this job:<input type="text" name="keywords" id="keywords"><br><br>
    City:<input type="text" name="city" id="city"><br><br>
    Country:<input type="text" name="country" id="country"><br><br>
    Area Code:<input type="number" name="area_code" id="area_code"><br><br>
    Part Time or Full Time:<input type="text" name="pos_type" id="pos_type"><br><br> <!--Maybe change into choices later?-->
    Salary:<input type="number" name="salary" id="salary"><br><br>
    Job Description:<br>
				<textarea rows="50" cols="50" name="description" id="description">
			Describe the job in 250 words... </textarea><br>
    <input type="submit" name="jobSubmit" value="Submit">
</form>

<?php
if(isset($_GET['jobSubmit']))
{
    $sql1 = "Select count(*) From employers Where email='".$_POST['email']."' And password='".$_POST['password']."'";
    $stid1 = oci_parse($dbh, $sql1);
    oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stid1);
    $result = oci_num_rows($sql1);
    if($result<0){
        echo "Incorrect Email or Password";
    }

    $sql2 = "Insert into JobOffers Values ('".$_GET['jobnum']."','".$_GET['Employers']."','".$_GET['title']."','".$_GET['keywords']."','".$_GET['description']."','".$_GET['city']."','".$_GET['country']."','".$_GET['area_code']."','".$_GET['pos_type']."','".$_GET['salary']."')";
    $stid2 = oci_parse($dbh, $sql);
    oci_execute($stid2,OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stid2);
}
?>

<?php
oci_close($dbh);
?>
</div>
</div>
</div>
</body>
</html>