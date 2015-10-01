//Start the session for php
<?php session_start() ?>
<html>
<body>
THIS IS THE USERNAME <br>
<?php
echo $_SESSION["username"];
?>
</body>
</html>
