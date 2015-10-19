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
{% extends "base_employer.html" %}

{% block content %}
<?php
  $sql = "SELECT * from Applications WHERE JobOffers = ".$_GET["job"];
  $stid = oci_parse($dbh, $sql);
  oci_execute($stid);
  $flag = 0;
  while (($row = oci_fetch_array($stid)) != false){
    $flag = 1;
    //Query for applicant name
    $app_sql = "SELECT name from Applicants WHERE email = '".$row["APPLICANTS"]."'";
    $app_stid = oci_parse($dbh, $app_sql);
    oci_execute($app_stid);
    $app_name = oci_fetch_array($app_stid)["NAME"];


    //output all data
    echo "<table style='padding: 10px; border: solid black 1px; border-collapse: separate; border-spacing: 10px; width:100%'>";
    echo "<tr>";
      echo "<td>";
        echo "<strong>Name: </strong> ";
        echo $app_name;
      echo "</td>";
      echo "<td>";
        echo "<strong>Email: </strong> ";
        echo $row["APPLICANTS"];
      echo "</td>";
      echo "<td>";
        echo "<strong>Date of Application: </strong> ";
        echo $row["DATE_APPLIED"];
      echo "</td>";
    echo "</tr>";
    echo "<tr>";
      echo "<td colspan = '3'>";
        echo "<strong>Writeup: </strong><br>\n ";
        echo $row["WRITEUP"];
      echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br>";
  }
  //If no applicants
  if ($flag == 0){
    echo "<p>There are no applicants for this job.</p>";
  }
?>

<?php
oci_close($dbh);
?>
{% endblock %}