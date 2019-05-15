<?PHP
include_once("../config/setup.php");
include_once("../Database/ft_co_db.php");
function mail_password($mail)
{
	$cle=md5(microtime(TRUE) * 100000);

	$bdd = ft_connect_db();
	$requete = $bdd->prepare("SELECT login FROM users WHERE mail = :mail");
	$requete->execute(array('mail' => $mail));
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	$login = $donnee["login"];


	$requete2 = $bdd->prepare("UPDATE users SET cle = :cle WHERE mail = :mail");
	$requete2->execute(array('cle' => $cle, 'mail' => $mail));

	$server_name = $_SERVER['REMOTE_ADDR'];
	$destinataire = $mail;
	$sujet = "Mot de passe oublie";
	$entete = "From: mdp@camagram.com";

	$message = "Mince, vou avez perdu votre mot de passe, pas de probleme, cliquez sur le lien si dessous et changez le de suite

http://localhost:8033/Users/reset_password.php?log=$login&cle=$cle;


---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
mail($destinataire, $sujet, $message, $entete);
echo "un mail vous a ete envoye";
}

function check_key($cle, $login)
{
	$bdd = ft_connect_db();
	$requete = $bdd->prepare("SELECT cle FROM users WHERE login = :login");
	$requete->execute(array('login' => $login));
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	$key = $donnee["cle"];
	if ($key === $cle)
		return (1);
	return (0);
}

function reset_passwd($mdp, $mdp2, $login)
{
	if ($mdp !== $mdp2)
		return (0);
	if (!(ft_secure_passwd($mdp)))
		return (-1);
	else
	{
		$bdd = ft_connect_db();
		$mdp = hash("whirlpool", $mdp);
			$requete = $bdd->prepare("UPDATE users SET mdp = :nvmdp WHERE login = :log");
			$requete->execute(array('nvmdp' => $mdp, 'log' => $login));
	}
	return (1);
}
?>
