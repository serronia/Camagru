<?PHP
include_once("../Database/ft_co_db.php");
include_once("./inscription_valide.php");

if (isset($_POST["login"], $_POST["passwd"], $_POST["passwd2"], $_POST["mail"]))
	ft_create_user($_POST["login"], $_POST["passwd"], $_POST["passwd2"], $_POST["mail"]);

?>

<html>
	<body class="page_container">
<div class="header_container">
<?PHP include_once("../Database/header.php"); ?>
</div>
		<?php if (isset($_GET["passwd_err"]) && $_GET["passwd_err"] === "not_identical"): ?>
			<p class="err">Passwords aren't identical.</p>
		<?php elseif (isset($_GET["login_err"]) && $_GET["login_err"] === "already_exists"): ?>
			<p class="err">Login or email already exists.</p>
		<?PHP elseif (isset($_GET["passwd_err"]) && $_GET["passwd_err"] === "not_secure"): ?>
			<p class="err">Password are not secured, he should have 8 characters, min 1 numeric character and min 1 alphabetic characters.</p>
		<?PHP elseif (isset($_GET["mail_err"]) && $_GET["mail_err"] === "not_ok"): ?>
			<p class="err">Your mail address are not conform.</p>
		<?php elseif (isset($_GET["bd_err"]) && $_GET["bd_err"] === "fail"): ?>
			<p class="err">Failed to connect to db or add user.</p>
		<?php endif; ?>

		<form method="post">
			Adresse Mail: <input type="email" name="mail"  required /><br />
			Identifiant: <input type="text" name="login" required /><br />
			Mot de passe: <input type="password" name="passwd" required/><br />
			Mot de passe: <input type="password" name="passwd2" required/><br />
			<input type="submit" name="submit" value="OK" />
		</form>
			<a href="../index.php"><button> Back</button></a>
		<?PHP include("../Database/footer.php"); ?>
	</body>
</html>

