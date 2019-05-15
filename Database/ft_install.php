<?PHP
/*
function	ft_create_table($server, $rootuser, $rootpswd)
{
	$bdd = ft_connect_db();
	$sql = "create table users (
<button><a href="../index.php">Back</a></button>
		id int(255) not null auto_increment primary key,
		login varchar(20) not null,
		mdp varchar(256) not null,
		mail varchar(256) not null,
		cle varchar(32) not null,
		actif int(1),
		send_mail int(1),
		is_admin int(255))";
	if(($bdd->exec($sql)))
		return (0);

	$sql = "create table pictures (
		id int(255) not null auto_increment primary key,
		name mediumtext not null,
		login_id int(255) not null,
		date datetime not null,
		lik int(255),
		FOREIGN KEY (login_id) REFERENCES users(id))";
	if(($bdd->exec($sql)))
		return (0);

$sql = "create table comment (
		id int(255) not null auto_increment primary key,
		pic_id int(255) not null,
		comment varchar(256) not null,
		date datetime not null,
		login_id int(255) not null,
		FOREIGN KEY (pic_id) REFERENCES pictures(id),
		FOREIGN KEY (login_id) REFERENCES users(id))";
	if(($bdd->exec($sql)))
		return (0);

$sql = "create table liks (
		id int(255) not null auto_increment primary key,
		login_id int(255) not null,
		pic_id int (255) not null,
		FOREIGN KEY (pic_id) REFERENCES pictures(id),
		FOREIGN KEY (login_id) REFERENCES users(id))";
	if(($bdd->exec($sql)))
		return (0);

	return (1);
}

function	ft_make_admin($login, $passwd, $mail)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$passwd = hash("whirlpool", $passwd);
	if (($bdd->exec("INSERT INTO users (login, mdp, mail, cle, actif, send_mail,is_admin) VALUES ('$login', '$passwd', '$mail','qwer', '1', '1', '1')")))
		return (FALSE);
	return (TRUE);
}

function	ft_install()
{
	$rootuser = "root";
	$rootpswd = "chaos";
	$server_name = "mysql";
try
{
	$bdd = new PDO("mysql:host=$server_name;charset=utf8", $rootuser, $rootpswd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	echo "je peux pas me connecter sans db?\n";
	die('Erreur : ' . $e->getMessage());
}
	$bdd->exec("CREATE DATABASE Camagram");
	if (!ft_connect_db())
	{
		echo "Loupe";
		return (0);
	}

	if (!ft_create_table($server_name, $rootuser, $rootpswd))
		return (0);
	if (!ft_make_admin("jdarko", "trouve", "jevtiarko.3@gmail.com"))
		return (0);
}*/
?>

