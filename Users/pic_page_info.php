<?PHP
include("../config/setup.php");
function login_pic($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT login_id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$login_id = $donnee[0]["login_id"];

	$requete = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
	$requete->execute([$login_id]);
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$login = $donnee[0]["login"];
	print $login;
}

function check_pic($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee == 0)
	{
		echo "requete non valide";
		return (0);
	}
	return (1);
	}

function aff_comment($pic)
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

	$requete = $bdd->prepare("SELECT id, comment, login_id FROM comment WHERE pic_id LIKE ?");
	$requete->execute([$pic_id]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);

	$i = 0;
	while (isset($donnee[$i]['comment']))
	{
		$login_id = $donnee[$i]["login_id"];
		$requete2 = $bdd->prepare("SELECT login FROM users WHERE id LIKE ?");
		$requete2->execute([$login_id]);
		$donnee2 = $requete2->rowCount();
		if ($donnee2 = 0)
			echo "requete non valide";
		$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
		print ("<form class=\"log_comment\"method='post'>".$donnee2[0]["login"] . " : \"" . $donnee[$i]["comment"] . "\"<button div class=\"suppr\" id='sup' value='".$donnee[$i]["id"]."' type='submit' name='sup'></button></form>");
//			echo "<div class=\"miniature_suppr\">";
//				echo "<button class=\"suppr\" id='pic' value='$pic' type='submit' name='pic'></button>";
//						echo "</div>";
		$i++;
	}
}

function add_comment($pic, $login, $comment)
{
	$comment = htmlspecialchars($comment);
	if (!isset($_SESSION["log"]) || $_SESSION["log"] == "")
		return (0);
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$pic_id = $donnee[0]["id"];

	$requete = $bdd->prepare("SELECT id FROM users WHERE login LIKE ?");
	$requete->execute([$login]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$login_id = $donnee[0]["id"];

	$requete = $bdd->prepare("INSERT INTO comment (pic_id, comment, date, login_id) VALUES (:pic, :com, NOW(), :login)");
	if (!($requete->execute(array('pic' => $pic_id, 'com' => $comment, 'login' => $login_id))))
		return (FALSE);
	comment_mail($pic);
}

function del_comment($id, $pic)
{
	if (!isset($_SESSION["log"]) || $_SESSION["log"] == "")
		return (0);
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$pic_id = $donnee[0]["id"];

	$requete2 = $bdd->prepare("SELECT id FROM users WHERE login LIKE ?");
	$requete2->execute([$_SESSION["log"]]);
	$donnee2 = $requete2->rowCount();
	if ($donnee2 = 0)
		echo "requete non valide";
	$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
	$id_login = $donnee2[0]["id"];

	$requete3 = $bdd->prepare("SELECT login_id FROM comment WHERE id=? AND pic_id=?");
	$requete3->execute(array($id, $pic_id));
	$donnee3 = $requete3->rowCount();
	if ($donnee3 == 0)
	{
//		echo "requete non valide";
		return (0);
	}
	$donnee3 = $requete3->fetchALL(PDO::FETCH_ASSOC);
	$id_login2 = $donnee3[0]["login_id"];



	if ($id_login === $id_login2)
	{
		$requete = $bdd->prepare("DELETE FROM comment WHERE id=? AND pic_id=?");
		$requete->execute(array($id, $pic_id));
	}
}

function comment_mail($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT login_id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$login_id = $donnee[0]["login_id"];

	$requete2 = $bdd->prepare("SELECT mail, send_mail FROM users WHERE id LIKE ?");
	$requete2->execute([$login_id]);
	$donnee2 = $requete2->rowCount();
	if ($donnee2 = 0)
		echo "requete non valide";
	$donnee2 = $requete2->fetchALL(PDO::FETCH_ASSOC);
	$mail = $donnee2[0]["mail"];
	$send = $donnee2[0]["send_mail"];
	if ($send == 1)
	{
		$destinataire = $mail;
		$sujet = "Nouveau commentaire";
		$entete = "From: notification@camagram.com";

		$message = "Vous avez recu un nouveau commentaire sur une de vos photos! A bientot sur votre site prefere :D
			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.";
	mail($destinataire, $sujet, $message, $entete);
	}
}
?>
