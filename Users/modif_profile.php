<?PHP
include_once("../config/setup.php");
include_once("../Database/ft_co_db.php");

function ft_modif_mdp($mdp, $newmdp, $newmdp2)
{
	if ($newmdp !== $newmdp2)
		return (0);
	if (!(ft_secure_passwd($newmdp)))
		return (-1);
	else
	{
		$bdd = ft_connect_db();
		$login = $_SESSION['log'];
		$requete = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
		$requete->execute([$login]);

		$donnee = $requete->rowCount();
		if ($donnee = 0)
			echo "requete non valide";
		$donnee = $requete->fetch(PDO::FETCH_ASSOC);
		$mdp = hash("whirlpool", $mdp);
		$newmdp = hash("whirlpool", $newmdp);
		if ($mdp !== $donnee['mdp'])
			return (-2);
		else 
		{
			$requete = $bdd->prepare("UPDATE users SET mdp = :nvmdp WHERE login = :log");
			$requete->execute(array('nvmdp' => $newmdp, 'log' => $login));
		}
	}
	return (1);
}

function ft_modif_mail($mail)
{
	$bdd = ft_connect_db();
	$login = $_SESSION['log'];
	if (!(ft_good_mail($mail)))
		return (-1);
	if ((ft_mail_exists($mail)))
		return (-2);
	$requete = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
	$requete->execute([$login]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	if ($login !== $donnee['login'])
		return (0);
	else 
	{
		$requete = $bdd->prepare("UPDATE users SET mail = :nvmail WHERE login = :log");
		$requete->execute(array('nvmail' => $mail, 'log' => $login));
	}
	return (1);
}

function ft_modif_login($login)
{
	$login = htmlspecialchars($login);
	$bdd = ft_connect_db();
	$old_login = $_SESSION['log'];
	if ((ft_login_exists($login)))
		return (-1);
	$requete = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
	$requete->execute([$old_login]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	if ($old_login !== $donnee['login'])
		return (0);
	else
	{
		$requete = $bdd->prepare("UPDATE users SET login = :nvlog WHERE login = :log");
		$requete->execute(array('nvlog' => $login, 'log' => $old_login));
		$_SESSION['log'] = $login;
	}
	return (1);
}

function ft_modif_send_mail($bool)
{
	if ($bool === "ok")
		$bool = 0;
	else if ($bool === "no")
		$bool = 1;
	$bdd = ft_connect_db();
	$login = $_SESSION['log'];
	$requete = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
	$requete->execute([$login]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	if ($login !== $donnee['login'])
		return (0);
	else
	{
		$requete = $bdd->prepare("UPDATE users SET send_mail = :nvnb WHERE login = :log");
		$requete->execute(array('nvnb' => $bool, 'log' => $login));
	}
}
?>
