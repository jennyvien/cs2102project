<?php 
	session_start();
	session_destroy();
	echo 'You are now logged out.';
	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=homepage.html">';
?>

