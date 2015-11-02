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
if(isset($_GET['jobSubmit']))
{
    
    //GET THE JOBNUMBER FIRST
    //$jobnum_sql = "SELECT (*) from Joboffers";
    //replace with this when tables are remade to integer
    $jobnum_sql = "SELECT max(jobnum) from Joboffers";
    $jobnum_stid = oci_parse($dbh, $jobnum_sql);
    oci_execute($jobnum_stid, OCI_COMMIT_ON_SUCCESS);
    $jobnumrow = oci_fetch($jobnum_stid);
    $j=1+$jobnumrow;
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
    $sql2 = "Insert into JobOffers Values (".($j).",'".$_SESSION['Email']."','".$_GET['title']."','".$_GET['keywords']."','".$_GET['description']."','".$_GET['city']."','".$_GET['country']."','".$_GET['area_code']."','".$_GET['pos_type']."','".$_GET['salary']."')";
    $stid = oci_parse($dbh, $sql2);
    oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
    oci_free_statement($stid);

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