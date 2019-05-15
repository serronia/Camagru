<?PHP
function ft_create_png($photo, $filtre)
{
	if ($filtre != "./filtres/grillage-camagram.png" && $filtre != "./filtres/crash-camagram.png" && $filtre != "./filtres/cauliflower-camagram.png")
		header("Location:../");
	$image_part = explode(";base64,", $photo);
	$tof = $image_part[1];
	$tof = base64_decode($tof);
	if (!file_exists("./photos/"))
		mkdir("./photos/");
	$nom_photo = uniqid() . ".png";
	file_put_contents("./photos/" . $nom_photo, $tof);
	$source = imagecreatefrompng($filtre);
	$toof = imagecreatefrompng("./photos/". $nom_photo);
	$largeur_source = 640;
	$hauteur_source = 450;
	$sourceX = 0;
	$sourceY = 0;
	imagecopy($toof, $source, $sourceX, $sourceY, 0, 0, $largeur_source, $hauteur_source);
	$ok = imagepng($toof, "./photos/" . $nom_photo);
	$path = "./photos/".$nom_photo ;
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM users WHERE login LIKE ?");
	$requete->execute([$_SESSION["log"]]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	$id = $donnee['id'];
	if (!($bdd->exec("INSERT INTO pictures (name, login_id, date) VALUES ('$base64', '$id', NOW())")))
		return (FALSE);
}

function ft_aff_your_photo()
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM users WHERE login LIKE ?");
	$requete->execute([$_SESSION["log"]]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	$id = $donnee['id'];
	$requete = $bdd->prepare("SELECT name FROM pictures WHERE login_id LIKE ?");
	$requete->execute([$id]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetchALL(PDO::FETCH_ASSOC);
	$i = 0;
	while (isset($donnee[$i]['name']))
	{
		$pic = $donnee[$i]['name'];
		echo "<div class=\"miniature_suppr\">";
		echo "<button class=\"suppr\" id='pic' value='$pic' type='submit' name='pic'></button>";
		echo "<img src='$pic' class=\"miniature\"></br>";
		echo "</div>";
		$i++;
	}
}

function ft_suppr_your_photo($pic, $login)
{
	ft_suppr_all_comment_like($pic);
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("DELETE FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	header("Location:./index.php");
}

function ft_suppr_all_comment_like($pic)
{
	if (($bdd = ft_connect_db()) === FALSE)
		return (FALSE);
	$requete = $bdd->prepare("SELECT id FROM pictures WHERE name LIKE ?");
	$requete->execute([$pic]);
	$donnee = $requete->rowCount();
	if ($donnee = 0)
		echo "requete non valide";
	$donnee = $requete->fetch(PDO::FETCH_ASSOC);
	$id_pic = $donnee["id"];

	$requete2 = $bdd->prepare("DELETE FROM comment WHERE pic_id LIKE ?");
	$requete2->execute([$id_pic]);
	$requete3 = $bdd->prepare("DELETE FROM liks WHERE pic_id LIKE ?");
	$requete3->execute([$id_pic]);
}
?>
