<?PHP
include("./password.php");
include("../Database/header.php");

if (isset($_SESSION["log"]) && $_SESSION["log"] != "")
	header("Location:../index.php");

if (isset($_POST["enregistrer"], $_POST["mail"]) && $_POST["enregistrer"] == "send" && $_POST["mail"] != "")
	mail_password($_POST["mail"]);


if (isset($_GET["cle"], $_GET["log"]) && check_key($_GET["cle"], $_GET["log"]) === 1)
{
	$good_key = 1;
	$login = $_GET["log"];
	$cle = $_GET["cle"];
}

if (isset($_POST["enregistrer"], $_POST["newmdp"], $_POST["newmdp2"]) && $_POST["enregistrer"] == "enregistrer" && $_POST["newmdp"] != ""  && $_POST["newmdp2"] != "")
{
	$i = reset_passwd($_POST["newmdp"], $_POST["newmdp2"], $login);
	if ($i == 0)
			header("Location:./reset_password.php?log=$login&cle=$cle&wrong=not_same");
	else if ($i == -1)
			header("Location:./reset_password.php?log=$login&cle=$cle&wrong=not_secure");
	else if ($i == 1)
			header("Location:./reset_password.php?good=okay");
}
if (isset($_GET["wrong"]))
{
	if ($_GET["wrong"] === "not_same")
		echo "les deux mots de passe ne sont pas identiques";
	if ($_GET["wrong"] === "not_secure")
		echo "le mot de passe doit contenir au moins 8 caracteres, dont au moins une lettre et un chiffre";
}

?>


<HTML>
	<HEAD>
	</HEAD>

	<BODY>

	<?PHP if (isset($good_key) && $good_key === 1) :?>
		<form method="post">
			Nouveau mot de passe : <input type="password" name="newmdp">
			Nouveau mot de passe encore: <input type="password" name="newmdp2">
			<input type="submit" name="enregistrer" value="enregistrer"></input>
		</form>
	<?PHP endif;?>
<?PHP if (isset($_GET["good"]) && $_GET["good"] === "okay")
		echo "le mot de passe a bien ete modifie, vous pouvez aller vous connecter";
	else  if (!isset($good_key) || isset($_GET["wrong"], $_GET["good"])) :?>
		<form method="post">
			Addresse mail : <input type="text" name="mail">
			<input type="submit" name="enregistrer" value="send"></input>
		</form>
	<?PHP endif;?>
	</BODY>
</HTML>
