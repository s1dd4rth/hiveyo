<?php
session_start();
include_once('./class.php');
$obj = new hive;
$obj->username = "root";
$obj->password="";
$obj->servername="localhost";
$obj->dbname="hiveyox";
$obj->connect();
$logincode = $obj->logincode();
if((!$_POST) && (!isset($_SESSION['username'])))
{
echo <<< THEHTML
<html>
<head>
<link rel="stylesheet" href="hive_style.css" type="text/css" />
<title>Hiveyo</title>
</head>
<body>
<div id="header">
<h1 class="header">
Hive
<div onclick="alert('dropdown')" id="arrow"></div>
</h1>
</div>
<div id="content">
$logincode
THEHTML;
//echo $obj->images();
echo <<< THEFOOTER
</div>
</body>
</html>
THEFOOTER;
} else {
$username = htmlspecialchars(trim($_POST['username']));
$password = htmlspecialchars(trim($_POST['password']));
if(isset($_POST['username']))
	$_SESSION['username']=$username;
echo <<< THEHTML
<html>
<head>
<title>Homepage</title>
</head>
<body>
THEHTML;
echo "You have been logged in Mr.".$_SESSION['username'];
echo <<< THECODE
<a style="margin-left:80%" href="logout.php">Logout</a>
</body>
</html>
THECODE;
}
?>