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
Welcome to the employer portal.
{% endblock %}
