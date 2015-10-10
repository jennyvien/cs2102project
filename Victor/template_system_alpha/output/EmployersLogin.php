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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	Maximus4T by 4Templates | http://www.4templates.com/free/ | @4templates
	Licensed under the Creative Commons Attribution 3.0 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TITLE OF JOBOFFER SITE</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet" type="text/css" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="jquery.dropotron-1.0.js"></script>
<script type="text/javascript" src="init.js"></script>
</head>
<body>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="#">JOBOFFERTHING</a></h1>
			<p>SUBTITLE IF ANY</p>
		</div>
	</div>
</div>
<div id="menu-wrapper">
	<div id="menu-content">
		<ul id="menu">
			<li class="first"><a href="#" accesskey="1" title=""><span>Home</span></a></li>
			<li><a href="EmployersViewOffers.php" accesskey="2" title=""><span>My Offers</span></a></li>
			<li><a href="EmployersSubmitOffer.php" accesskey="3" title=""><span>Submit Job Offer</span></a></li>
		</ul>
	</div>
	<div id="search">
		<form method="get" action="">
			<fieldset>
				<input type="text" name="s" id="search-text" title="Search our website" size="15" value="" />
				<input type="submit" id="search-submit" value="GO" />
			</fieldset>
		</form>
	</div>
</div>
<div id="banner-wrapper">
	<div id="banner">
		<div class="image"><a href="#"><img src="images/pics02.jpg" width="900" height="257" alt="" /></a></div>
		<div class="border"></div>
	</div>
</div>
<div id="page">
	<div class="bgtop"></div>
	<div class="content-bg">
		<div id="content">
			<div class="post">
				<h1 class="ctitle"> </h2>
				<div class="entry">
					
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
	Password: <input type="text" name="Password" id="Password"><br><br>
	<input type="submit" value = "Submit", name="Submit">
	</form>
<?php
	echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';
	echo "POST: <br>";
	echo '<pre>';
	var_dump($_POST);
	echo '</pre>';
	//Currently might be vulnerable to SQL injection
	$sql = "SELECT * FROM Employers";
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
	$sql = 'SELECT * FROM  Employers
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
		$_SESSION["Company"] = "PLACEHOLDER_IN_EMPLOYERS_LOGIN";
		$_SESSION["Applicant"] = 0;
		$_SESSION["Employer"] = 1;

		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=EmployersLoginResult.php">';
	}
	else{
		$_SESSION["Failed"] = 1;
	}
	oci_free_statement($stid);
	oci_close($dbh);
}


?>

				</div>
			</div>
		</div>
	</div>
	<div class="bgbtm"></div>
</div>
<div id="footer-content">
	<div class="bgtop"></div>
	<div class="content-bg">
		<div id="column1">
			<div class="box1">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
			</div>
			<div class="box2">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
			</div>
		</div>
		<div id="column2">
			<div class="box3">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
			</div>
		</div>
	</div>
	<div class="bgbtm"></div>
</div>
<div id="footer">
	<p><a href="http://www.4templates.com/free/">4Templates</a>  |  Photos by <a href="http://fotogrph.com/">Fotogrph</a></p>
</div>
</body>
</html>