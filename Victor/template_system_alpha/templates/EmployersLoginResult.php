<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Applicant"] == 1){
	header("Location: EmployersLogin.php");
}
?>
{%extends "base_employer.html" %}

{% block content%}
<?php
	echo "Welcome ".$_SESSION["Username"].", you are now logged in.";	
?>
<meta http-equiv="refresh" content="2; url=EmployersPortal.php" />
{% endblock %}
