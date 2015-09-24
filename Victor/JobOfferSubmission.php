<html>
<head> <title> Create Job Offer </title> </head>

<body bgcolor="#9F81F7">
<table>
<tr> <td column = '100'>
<h1> Create Job Offer</h1>
</td> </tr>
</table>

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

<form>
	Email:<input type="text" name="Email" id="Email"><br><br>
	Password:<input type="text" name="Password" id="Password"><br><br>

	Description:<br>	
	<textarea rows="4" cols="50" name="Description" id="Description">
Enter Resume here...</textarea><br>
<input type="submit" name="formSubmit" value="Submit">
</form>

