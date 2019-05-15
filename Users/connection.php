<?PHP
include("../config/setup.php");
include("../Database/ft_co_db.php");
	if(isset($_SESSION["log"]) && $_SESSION["log"] != "")
		header("Location:../");
	if(isset($_POST["login"], $_POST["passwd"]))
		ft_connection($_POST["login"], $_POST["passwd"]);
?>

<html>
	<body class="page_container">
<div class="header_container">
<?PHP include("../Database/header.php");?>
</div>
</br>
		<form  method="post">
			Identifiant: <input type="text" name="login" /><br />
			Mot de passe: <input type="password" name="passwd" /><br />
			<input type="submit" name="submit" value="OK" />
			<button><a href="../index.php">Back</a></button>
		</form>
		<a href="./reset_password.php">Mot de passe oublie</a>
		</br>
		<a>Pas encore inscrit sur Camagram ? Clique ici : </a>
		<a href="./inscription.php">Inscription</a>
		</br>
		<?PHP include("../Database/footer.php"); ?>
	</body>
</html>
