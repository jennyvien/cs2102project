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
			<h1><a href="homepage.html">JobHunt</a></h1>
			<p>Subtitle</p>
		</div>
	</div>
</div>
<div id="menu-wrapper">
	<div id="menu-content">
		<ul id="menu">
			<li class="first"><a href="EmployersPortal.php" accesskey="1" title=""><span>Home</span></a></li>
			<li><a href="EmployersViewOffers.php" accesskey="2" title=""><span>My Offers</span></a></li>
			<li><a href="EmployersSubmitOffer.php" accesskey="3" title=""><span>Submit Job Offer</span></a></li>
			<li><a href="EmployersDetails.php" accesskey="4" title=""><span>Employer Details</span></a></li>
			<li><a href="Logout.php" accesskey="5" title=""><span>Logout</span></a></li>
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
	//Delete offers if delete request is present
	if (array_key_exists('Delete' ,$_POST)){
		$sql_del_apps = "DELETE FROM Applications
		WHERE joboffers=" . $_POST['JobNum'] . " AND employers = '" . $_POST['Employer'] . "'";
		$sql_del_offer = "DELETE FROM JobOffers
		WHERE jobnum=" . $_POST['JobNum'] . " AND employers = '" . $_POST['Employer'] . "'";
		$stid_del_apps = oci_parse($dbh, $sql_del_apps);
		$stid_del_offer = oci_parse($dbh, $sql_del_offer);
		oci_execute($stid_del_apps);
		oci_execute($stid_del_offer);
		oci_free_statement($stid_del_apps);		
		oci_free_statement($stid_del_offer);
	}
?>						
<?php
	$sql1 = "SELECT COUNT(*) 
			FROM JobOffers
			WHERE Employers = '" . $_SESSION["Email"] . "'";
	$sql2 = "SELECT * from JobOffers 
			WHERE Employers = '" . $_SESSION["Email"] . "'";
	
	$stid1=oci_parse($dbh, $sql1);
	oci_execute($stid1, OCI_DEFAULT);
	$count = oci_fetch_array($stid1);
	if($count[0] < 1) {
		echo "You have not submitted any offers.";
	} else {
		$stid2=oci_parse($dbh, $sql2);
		oci_execute($stid2, OCI_DEFAULT);
		while (($row = oci_fetch_array($stid2)) != false){
			//collect applicants for current job
			$app_sql = "SELECT * from Applications WHERE JobOffers = ".$row["JOBNUM"] . "AND Employers = '" . $row["EMPLOYERS"] . "'";
			$app_stid = oci_parse($dbh, $app_sql);
			oci_execute($app_stid);
			$app_count = oci_fetch_all($app_stid, $res);
			//MAKE THIS A LINK TO THE APPLICATION VIEW	
			echo "<td>";
				echo "<a href ='EmployersJobApplications.php?job=".$row["JOBNUM"]."&employer=".$row["EMPLOYERS"]."'><strong>Applicants: </strong> ".$app_count."</a>";
			echo "</td>";
			
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
					echo "<a href= EmployersUpdateOffers.php?jobNum=" . $row["JOBNUM"] . "&Employer=" . $row["EMPLOYERS"] . "> Edit </a>";
					echo "<form action = 'EmployersViewOffers.php' method='POST'>
							<input type='hidden' name='JobNum' value='" . $row["JOBNUM"] . "'>
							<input type='hidden' name='Employer' value='" . $row["EMPLOYERS"] . "'>
							<input type='submit' name='Delete' value='Delete'>
							</form>
							";
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
	}	
?>		
<?php
oci_close($dbh);
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