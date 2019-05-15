<?PHP
session_start();
include("./pic_page_info.php");
include("./aff_all.php");
include("../Database/ft_co_db.php");

if (!isset($_SESSION["log"]) || $_SESSION["log"] == "")
	header("Location:../");
if (check_pic($_SESSION["pic"]) != 1)
	header("Location:./galery.php");
$pic = $_SESSION["pic"];
//login_pic($pic);
//echo "</br><img src='$pic'></br>";
//print_like($pic);
//if (isset($_POST["comment"]) && $_POST["comment"] != "")
//	add_comment($pic, $_SESSION["log"], $_POST["comment"]);
//if (isset($_POST["sup"]) && $_POST["sup"])
//	del_comment($_POST["sup"], $pic);
//aff_comment($pic);

?>

<HTML>
	<head>
		
	</head>

	<BODY class="page_container">
<div class="header_container">
<?PHP include_once("../Database/header.php"); ?>
	</div>

<?PHP
echo "</br><div class=\"login\">";
login_pic($pic);
echo "</div>";
echo "</br><img src='$pic'></br>";
print_like($pic);
if (isset($_POST["comment"]) && $_POST["comment"] != "")
	add_comment($pic, $_SESSION["log"], $_POST["comment"]);
if (isset($_POST["sup"]) && $_POST["sup"])
	del_comment($_POST["sup"], $pic);
?>

<div class="comment">
<?php aff_comment($pic);?>
		<form class="log_comment" method="post">
			Commenter : <input name="comment" type="text">
		</form>
</div>
		<?PHP include("../Database/footer.php"); ?>
	</BODY>

</HTML>

