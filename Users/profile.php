<?PHP
include("./modif_profile.php");

if (!(isset($_SESSION["log"]) && $_SESSION["log"] != ""))
	header("Location:../");
if (isset($_POST["mdp"], $_POST["newmdp"], $_POST["newmdp2"]) && $_POST['mdp'] !== "" && $_POST['newmdp'] !== "" && $_POST['newmdp2'] !== "")
	$modif_mdp = ft_modif_mdp($_POST['mdp'], $_POST['newmdp'], $_POST['newmdp2']);
if (isset($_POST["newmail"]) && $_POST['newmail'] !== "")
	$modif_mail = ft_modif_mail($_POST['newmail']);
if (isset($_POST["newlog"]) && $_POST['newlog'] !== "")
	$modif_log = ft_modif_login($_POST["newlog"]);
if (isset($_POST["send_mail"]) && $_POST['send_mail'] === 'ok')
{
	ft_modif_send_mail($_POST["send_mail"]);
	$_POST['send_mail'] = NULL;
}
else if (isset($_POST['submit']) && $_POST['submit'] === "Save")
	ft_modif_send_mail("no");

$bdd = ft_connect_db();
$login = $_SESSION['log'];
$requete = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
$requete->execute([$login]);
$donnee = $requete->rowCount();
if ($donnee = 0)
	echo "requete non valide";
$donnee = $requete->fetch(PDO::FETCH_ASSOC);
$send_mail = $donnee['send_mail'];
?>

<html>
	<body class="page_container">
<div class="header_container">
<?PHP include("../Database/header.php"); ?>
</div>
		Sur cette page, vous pouvez modifier votre profil.
		<form method="post">
			</br>
			Mot de passe : <input type = "password" name="mdp">
			Nouveau mot de passe : <input type="password" name="newmdp">
			Nouveau mot de passe encore: <input type="password" name="newmdp2">
			</br></br>
			Nouveau Login : <input type="text" name="newlog">
			</br>
			Nouveau mail : <input type="mail" name="newmail">
			</br>
			Desactiver les notifications par mail: <input type="checkbox" name="send_mail" value="ok" <?PHP if ($send_mail === "0") echo "checked" ?>>
			<input type="submit" name="submit" value="Save"/>
		</form>
		</br>
		</br>
		<?PHP  if (isset($modif_mdp) && $modif_mdp === -1) echo "Le mot de passe doit contenir au moins 8 caracteres dont au moins un chiffre et un caractere alphabetique.\n"?>
		<?PHP  if (isset($modif_mdp) && $modif_mdp === 0) echo "Les deux mots de passe ne sont pas identiques.\n"?>
		<?PHP  if (isset($modif_mdp) && $modif_mdp === -2) echo "Vous n'avez pas rentre votre bon mot de passe.\n"?>
		<?PHP  if (isset($modif_mdp) && $modif_mdp === 1) echo "Votre mot de passe a bien ete modifie.\n"?>
		<?PHP  if (isset($modif_mail) && $modif_mail === 1) echo "Votre mail a bien ete modifie.\n"?>
			<?PHP  if (isset($modif_mail) && $modif_mail === -1) echo "Votre mail n'est pas valide.\n"?>
		<?PHP  if (isset($modif_mail) && $modif_mail === -2) echo "Le mail existe deja.\n"?>
		<?PHP  if (isset($modif_mail) && $modif_mail === 0) echo "Une erreur est survenue, veuillez reessayer.\n"?>
		<?PHP  if (isset($modif_log) && $modif_log === -1) echo "Le login existe deja.\n"?>
		<?PHP  if (isset($modif_log) && $modif_log === 0) echo "Une erreur est survenue, veuillez reessayer.\n"?>
		<?PHP  if (isset($modif_log) && $modif_log === 1) echo "Votre login a bien ete modifier.\n"?>

		<?PHP include("../Database/footer.php"); ?>
	</body>
</html>
