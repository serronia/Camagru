<?PHP
function ft_aff_all($page)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT name, login_id FROM pictures");
	$requete->execute();
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$i = ($page - 1) * 5;
	while (isset($donnee[$i]['login_id']) && $i < ($page * 5))
	{
		$id = $donnee[$i]['login_id'];

		$requete2 = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
		$requete2->execute([$id]);
		$donnee2 = $requete2->rowCount();
		if ($donnee2 = 0)
			echo "requete non valide";
		$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);

		$login = $donnee2[0]['login'];
		echo "<div class=\"galery_pic\"></br><div class=\"login\">$login </div></br>";
		$pic = $donnee[$i]['name'];
//		like($pic);
		echo "<button id='pic' value='$pic' type='submit'  name='pic'><img src='$pic'></button>";
		echo "</br>";
		print_like($pic);
		echo "<div class=\"like_comment\"><button class=\"button\" id='like' value='$pic' type='submit' name='like'>like</button>";
		echo "<button class=\"button\"id='comment' value='$pic' type='submit' name='comment'>comment</button></br></br></div></div></br>";

		$i++;
	}
}

function ft_is_your($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT login_id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee == 0)
	{
		return (0);
	}
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$id = $donnee[0]["login_id"];
	$requete2 = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
	$requete2->execute([$id]);
	$donnee2 = $requete2->rowCount();
	if ($donnee2 = 0)
		echo "requete non valide";
	$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
	$login = $donnee2[0]["login"];
	if ($login == $_SESSION["log"])
	{
		ft_suppr_all_comment_like($pic);
		$requete3 = $bdd->prepare("DELETE FROM pictures WHERE name LIKE ?");
		$requete3->execute([$pic]);
		header("Location:./galery.php");
	}
	else
		print("tu peux pas delete ca mon gars!</br>");
}

function print_like($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$pic_id = $donnee[0]["id"];

	$requete2 = $bdd->prepare("SELECT id FROM liks WHERE pic_id LIKE ?");
	$requete2->execute([$pic_id]);
	$donnee2 = $requete2->rowCount();
	if ($donnee2 = 0)
		echo "requete non valide";
	$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
	$i = 0;
	while (isset($donnee2[$i]['id']))
	{
		$i++;
	}
	print "<div class=\"like\">like : ".$i." </div></br>";
}

function like($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee == 0)
	{
		return (0);
	}
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);


		$pic_id = $donnee[0]["id"];
		$requete2 = $bdd->prepare("SELECT login_id FROM liks WHERE pic_id LIKE ?");
		$requete2->execute([$pic_id]);
		$donnee2 = $requete2->rowCount();
		if ($donnee2 = 0)
			echo "requete non valide";
		$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
		$i = 0;
	if (isset($donnee2[0]["login_id"]))
	while (isset($donnee2[$i]["login_id"]))
	{
		$log_id = $donnee2[$i]["login_id"];

		$requete3 = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
		$requete3->execute([$log_id]);
		$donnee3 = $requete3->rowCount();
		if ($donnee3 = 0)
			echo "requete non valide";
		$donnee3 = $requete3->fetchALL(PDO::FETCH_ASSOC);

		if ($donnee3[0]['login'] === $_SESSION['log'])
			ft_delike($log_id, $pic_id);
		else
		ft_adlike($_SESSION['log'], $pic_id);
		$i++;
	}
	else 
		ft_adlike($_SESSION['log'], $pic_id);
}

function ft_delike($log_id, $pic_id)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("DELETE FROM liks WHERE login_id=? AND pic_id=?");
	$requete->execute(array($log_id, $pic_id));
}

function ft_adlike($login, $pic_id)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM users WHERE login LIKE ?");
	$requete->execute([$login]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$id_login = $donnee[0]['id'];

	if (!($bdd->exec("INSERT INTO liks (login_id, pic_id) VALUES ('$id_login', '$pic_id')")))
		echo "requete non valide";

}
?>
