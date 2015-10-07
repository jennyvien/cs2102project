<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Applicant"] == 1){
    header("Location: EmployersLogin.php");
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
<html>
<head> <title> Submit Job Offer as Employer </title>
<body bgcolor="pink">
<table>
    <tr> <td column = '100'>
            <h1> Submit Job Offer as Employer </h1>
        </td> </tr>
</table>

<form>
    Title of the job:<input type="text" name="title" id="title"><br><br>
    Some keywords about this job:<input type="text" name="keywords" id="keywords"><br><br>
    City:<input type="text" name="city" id="city"><br><br>
    Country:<input type="text" name="country" id="country"><br><br>
    Area Code:<input type="number" name="area_code" id="area_code"><br><br>
    Part Time or Full Time:<input type="text" name="pos_type" id="pos_type"><br><br> <!--Maybe change into choices later?-->
    Salary:<input type="number" name="salary" id="salary"><br><br>
    Job Description:<br>
				<textarea rows="50" cols="50" name="description" id="description">Describe the job in 250 words... </textarea><br>
    <input type="submit" name="jobSubmit" value="Submit">
</form>
<?php
    echo $_SESSION['Email'];
?>
<?php
if(isset($_GET['jobSubmit']))
{
    
    //GET THE JOBNUMBER FIRST
    //$jobnum_sql = "SELECT (*) from Joboffers";
    //replace with this when tables are remade to integer
    $jobnum_sql = "SELECT count(jobnum) from Joboffers";
    $jobnum_stid = oci_parse($dbh, $jobnum_sql);
    oci_execute($jobnum_stid, OCI_COMMIT_ON_SUCCESS);
    $jobnumrow = oci_fetch($jobnum_stid);
    oci_free_statement($jobnum_stid);

  //  $sql2 = "Insert into JobOffers Values (:jobnum, ':employers', ':title', ':keywords', ':description', ':city', ':country', :area_code, ':pos_type,' :salary)";
  //  oci_bind_by_name($stid, ":jobnum", $jobnumrow[0]);
  //  oci_bind_by_name($stid, ":employers", $_SESSION["Email"]);
  //  oci_bind_by_name($stid, ":title", $_GET["title"]);
  // oci_bind_by_name($stid, ":keywords", $_GET["keywords"]);
   // oci_bind_by_name($stid, ":description", $_GET["description"]);
  //  oci_bind_by_name($stid, ":city", $_GET["city"]);
  // oci_bind_by_name($stid, ":country", $_GET["country"]);
  //  oci_bind_by_name($stid, ":area_code", $_GET["area_code"]);
  //  oci_bind_by_name($stid, ":pos_type", $_GET["pos_type"]);
 //   oci_bind_by_name($stid, ":salary", $_GET["salary"]);
    $sql2 = "Insert into JobOffers Values (".$jobnumrow.",'".$_SESSION['Email']."','".$_GET['title']."','".$_GET['keywords']."','".$_GET['description']."','".$_GET['city']."','".$_GET['country']."','".$_GET['area_code']."','".$_GET['pos_type']."','".$_GET['salary']."')";
    $stid = oci_parse($dbh, $sql2);
    oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stid2);
    
    echo $jobnumrow;
    echo $sql2;
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
