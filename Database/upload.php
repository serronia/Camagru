<?php
if (!isset($_SESSION["log"]) || $_SESSION["log"] == "")
	header("Location:../");
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// On regarde si le file est bien une image
if(isset($_POST["submit"]))
{
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		echo "Le file est une image - " . $check["mime"] . ".";
		$uploadOk = 1;
	}
	else
	{
		echo "Le file n'est pas une image";
		$uploadOk = 0;
	}
}

// Est-ce qu'il existe ?
if (file_exists($target_file))
{
	echo "L'image existe deja";
	$uploadOk = 0;
}

// Taille
if ($_FILES["fileToUpload"]["size"] > 700000)
{
	echo "Ton image est trop grande";
	$uploadOk = 0;
}

// Verification du format
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" )
{
	echo "Seul les JPG, JPEG, PNG et GIF sont autorises.";
	$uploadOk = 0;
}

// Verification si erreur
if ($uploadOk == 0)
{
	echo "Une erreur est survenue";
	// Tout est bon on essaye d'upload
}
else
{
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	}
	else
	{
		echo "Une erreur est survenue durant l'uplaod";
	}
}

$tof = imagecreatefromstring(file_get_contents(("./uploads/". $_FILES["fileToUpload"]["name"])));
$tof = base64_encode($tof);
?>
