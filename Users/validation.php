<?PHP
include_once("../config/setup.php");
if (!isset($_GET["cle"]))
	header("Location:../");

$bdd = ft_connect_db();
$cle = $_GET['cle'];

$requete = $bdd->prepare("SELECT * FROM users WHERE cle LIKE ?");
$requete->execute([$cle]);

$donnee = $requete->rowCount();
	if ($donnee == 0)
	{
		echo "requete non valide\n";
		return (0);
	}
$donnee = $requete->fetch(PDO::FETCH_ASSOC);

	$actiff = $donnee['actif'];
if ($actiff == 1)
{
	echo "Votre compte est deja actif !";
	return (0);
}
else
{
	echo "\n";
		$requete = $bdd->prepare("UPDATE users SET actif = 1 WHERE cle like :cle");
		$requete->execute(array('cle' => $cle));
		if ($donnee != 0)
			echo "Votre compte a bien ete creer";
	else
		echo "Erreur ! Votre compte ne peut etre active...";
}
?>

<html>
	<body>
		</br>
		<button><a href="../index.php">Back</a></button>
	</body>
</html>
