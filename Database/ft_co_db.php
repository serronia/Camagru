<?PHP
include_once("../config/setup.php");
function ft_add_user($login, $passwd, $mail)
{
	$bdd = ft_connect_db();
	$passwd = hash("whirlpool", $passwd);
	try
	{
		$other = $bdd->prepare("INSERT INTO users(login, mdp, mail, cle, actif, send_mail ,is_admin) VALUES(:login, :passwd, :mail, :cle, 0, 1 ,0)");
		$other->execute(array(
			'login' => $login,
			'passwd' => $passwd,
			'mail' => $mail,
			'cle' => $cle=md5(microtime(TRUE) * 100000)));
		$login_hash = hash("whirlpool", $login);
		if (ft_mail($login_hash, $mail, $cle, $login))
			header("Location:inscription_valide.php?inscription=ok");
	}
	catch (Exception $e)
	{
		echo "zxcvbnmzxcvbnm";
		return (FALSE);
	}
	return (TRUE);
}

function ft_count_all()
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT name, login_id FROM pictures");
	$requete->execute();
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$i = 0;
	while (isset($donnee[$i]['login_id']))
	{
		$id = $donnee[$i]['login_id'];

		$requete2 = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
		$requete2->execute([$id]);
		$donnee2 = $requete2->rowCount();
		if ($donnee2 = 0)
			echo "requete non valide";
		$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
		$i++;
	}
	$_SESSION['nb_pic'] = $i;
}

function ft_login_exists($login)
{
	$bdd = ft_connect_db();
	$other = $bdd->prepare("SELECT * FROM users WHERE login LIKE ?");
	$other->execute([$login]);
	$donnees = $other->fetch(PDO::FETCH_ASSOC);
	if (empty($donnees))
		return (FALSE);
	return (TRUE);
}

function ft_mail_exists($mail)
{
	$bdd = ft_connect_db();
	$other = $bdd->prepare("SELECT * FROM users WHERE mail LIKE ?");
	$other->execute([$mail]);
	$donnees = $other->fetch(PDO::FETCH_ASSOC);
	if (empty($donnees))
		return (FALSE);
	return (TRUE);
}

function ft_user_exists($login, $mail)
{
	if (ft_login_exists($login))
		return (TRUE);
	if (ft_mail_exists($mail))
		return (TRUE);
	return (FALSE);
}

function ft_secure_passwd($pw)
{
	if (strlen($pw) < 8)
		return (FALSE);
	$Syntaxe='/[^a-zA-Z]/';
	if(!preg_match($Syntaxe,$pw))
		return (FALSE);
	if (ctype_digit($pw) === TRUE)
		return (FALSE);
	return (TRUE);
}

function ft_good_mail($mail)
{
	if (!preg_match("#^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$#", $mail))
		return (FALSE);
	return (TRUE);
}

function ft_create_user($login, $passwd, $passwd2, $mail)
{
	$login = htmlspecialchars($login);
	$ret = (ft_secure_passwd($passwd));
	$pw = hash("whirlpool", $passwd);
	if ($passwd !== $passwd2)
		header("Location:inscription.php?passwd_err=not_identical");
	else if ($ret === FALSE)
		header("Location:inscription.php?passwd_err=not_secure");
	else if (ft_user_exists($login, $mail) === TRUE)
		header("Location:inscription.php?login_err=already_exists");
	else if (ft_good_mail($mail) === FALSE)
		header("Location:inscription.php?mail_err=not_ok");
	else if (ft_add_user($login, $passwd, $mail) === FALSE)
		header("Location:connection.php?bd_err=fail");
	else
		header("Location:inscription_valide.php?inscription=ok");
	exit();
}

function ft_connection($login, $passwd)
{
	$bdd = ft_connect_db();
	if ((isset($passwd) && $passwd !== ""))
		$passwd = hash("whirlpool", $passwd);
	$log = $bdd->prepare("SELECT mdp, actif FROM users WHERE login like :login");
	$log->execute(array('login' => $login));
	while ($donnees = $log->fetch())
	{
		$pw = $donnees['mdp'];
		$actif = $donnees['actif'];
	}
	if ($pw === $passwd && $actif == 1)
	{
		ft_count_all();
		$_SESSION['log'] = $login;
		$_SESSION['page'] = 1;
		header("Location:../");
	}
	else if (!(isset($passwd, $login)) || $passwd === "" && $login === "")
	{
		$_SESSION['log'] = NULL;
		header("Location:../index.php");
	}
	else if ($pw !== $passwd)
	{
		$_SESSION['log'] = "wrong";
		header("Location:../index.php");
	}
	else
	{
		$_SESSION['log'] = "not activ";
		header("Location:../?connection=notactiv");
	}
}
?>
