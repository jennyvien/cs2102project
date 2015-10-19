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
{% extends "base_employer.html"%}

{% block content %}
<?php
$sql = "SELECT * from JobOffers WHERE Employers = '".$_SESSION["Email"]."'";
$stid=oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
//catch null values here

//Iterate through the whole table, print needed data
$flag = 0;
//echo var_dump(oci_fetch_array($stid));
while (($row = oci_fetch_array($stid)) != false){
  $flag = 1;
  echo "<table style='padding: 10px; border: solid black 1px; border-collapse: separate; border-spacing: 10px; width:100%'>";
  echo "<tr>";
    echo "<td>";
      echo "<strong>Title: </strong> ";
      echo $row["TITLE"];
    echo "</td>";
    echo "<td>";
      echo "<strong>Location: </strong> ";
      echo $row["CITY"].", ".$row["COUNTRY"];
    echo "</td>";
    echo "<td>";
      echo "<strong>Position: </strong> ";
      echo $row["POS_TYPE"];
    echo "</td>";
    echo "<td>";
      echo "<strong>SALARY: </strong> ";
      echo "$".$row["SALARY"];
    echo "</td>";
  
    echo "<td style='text-align:right;'>";
    echo "<a href ='#'><strong>Applicants: </strong> ". "0</a>";
    echo "</td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td colspan = '4'>";
      echo "<strong>Description: </strong><br>\n ";
      echo $row["DESCRIPTION"];
    echo "</td>";
  echo "</tr>";
  echo "</table>";
  echo "<br>";
}
if ($flag = 0){
  echo "<p>You have not submitted any offers.</p>";
}
?>

<?php
oci_close($dbh);
?>
{% endblock %}