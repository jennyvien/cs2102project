<?php
session_start();
if($_SESSION["Failed"] == 1){
    $fail_flag = 1;
    $_SESSION["Failed"] = 0;
}
elseif($_SESSION["LoggedIn"]==1 and $_SESSION["Employer"] == 1){
    header("Location: EmployersPortal.php");
}
else{
}

?>
<html>
<head> <title> Offers Submitted </title>
<body bgcolor="pink">
<table>
    <tr> <td column = '100'>
            <h1> Offers Submitted </h1>
        </td> </tr>
</table>

<?php
/**
 * This page is used to
 * show a list of offers
 * a specific employer
 * had committed before
 * and an option to submit
 * another.
 * This page will be shown
 * after log in.
 *
 */

putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('e0009149', 'crse1510', '(DESCRIPTION =
	(ADDRESS_LIST =
	 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
	)
	(CONNECT_DATA =
	 (SERVICE_NAME = sid3.comp.nus.edu.sg)
	)
  )');
?>

<form>

    <button type="button">Submit New Offer</button> <!-- This button is linked to Employer Submit Offer page>
</form>

<?php
{
    $sql1 = "SELECT * FROM JobOffers j Where Employers = (SELECT email FROM Employers WHERE email = '".$_GET['email']."') ORDER BY j.jobnum";
    $stid=oci_parse($dbh, $sql);
    oci_execute($stid, OCI_DEFAULT);
    while($row = oci_fetch_array($stid)) {
        echo '<tr>';
        foreach($row as $field) {
            echo '<td>' . htmlspecialchars($field) . '</td>';
        }
        echo '</tr>';
    }

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