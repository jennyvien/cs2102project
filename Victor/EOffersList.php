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
 */

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
    Password:<input type="text" name="password" id="password"><br><br>
    <button type="button">Submit New Offer</button> <!-- This button is linked to Employer Submit Offer page>
</form>

<?php
{
    $sql1 = "Select count(*) From employers Where email='".$_POST['email']."' And password='".$_POST['password']."'";
    $stid1 = oci_parse($dbh, $sql1);
    oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stid1);
    $result = oci_num_rows($sql1);
    if($result<1){
        echo "Incorrect Email or Password";
    }

    $sql1 = "SELECT * FROM JobOffers j Where Employers = (SELECT email FROM Employers WHERE email = '".$_GET['email']."')";
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