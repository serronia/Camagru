<?PHP
if (isset($_POST["submit"]) && $_POST["submit"] === "deco")
	$_SESSION["log"] = NULL;

?>

<HTML>

<HEAD>
<link rel="stylesheet" href="../Database/index.css"/>
</HEAD>


<BODY style="">

	<header>

		<p style="text-align:center;">CAMAGRAM</p>
<?PHP	if (isset($_SESSION["log"]) && $_SESSION != "") : ?>
			<form method="post">
			<button  type="submit" name="submit" value="deco"><img class="deconnexion"   src="../filtres/on_off.jpg"></button>
		<a href="/Users/profile.php">Profile</a>
<?PHP	else : ?>
			<a href="/Users/connection.php">Login</a>
<?PHP	endif; ?>

		<a href="/Users/galery.php">Galery</a>
		<a href="/">Camera</a>
			</form>

	</header>
</BODY>

</HTML>
