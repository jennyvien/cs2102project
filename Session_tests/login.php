<?php session_start(); ?>

<html>
<body>
THIS IS TEXT
<?php
$_SESSION["username"] = $_POST["username"];
echo "SESSION variable"."<br>";

echo $_SESSION["username"]."<br>";
?>

<a href="test.php">TEST</a>
</body>
</html>