<?PHP
include_once("./config/setup.php");
include("./Database/ft_add_photo.php");
include("./Users/aff_all.php");

$_SESSION['page'] = 1;
$server_name = $_SERVER['REMOTE_ADDR'];
try
{
	$bdd = new PDO("mysql:host=$server_name;dbname=Camagram;charset=utf8", 'root', 'chaos', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	ft_install();
}
?>

<html>

	<head>
		<link rel="stylesheet" href="./Database/index.css"/>
	</head>

	<body class="page_container">

	<?php if (isset($_GET["register"]) && $_GET["register"] === "success"): ?>
				<p class="success">Votre compte a été créé avec succès.</p>
	<?php endif; ?>

	<?PHP  if ((!isset($_SESSION['log'])) || ($_SESSION['log'] === NULL)): ?>
				<p>Welcome To Camagram</p></br>
	<?php endif; ?>

	<?PHP  if ((isset($_SESSION['log']) && $_SESSION['log'] === "notactiv")): ?>
				<p> Veuillez confirmer votre inscription qu'on vous a envoye par mail avant d'acceder a toute les options disponible. <br /><a href="./Users/connection.php">Encore ?</a></p>
	<?PHP endif;?>
	<?PHP  if ((isset($_SESSION['log']) && $_SESSION['log'] === "wrong")): ?>
				<p> Mauvais login ou mot de passe <br /><a href="./Users/connection.php">Encore ?</a></p>
	<?PHP $_SESSION["log"] = NULL; endif;?>
	<?PHP  if ((isset($_SESSION['log']) && $_SESSION['log'] === "not activ")): ?>
				<p> Veuillez activer votre compte <br /><a href="./Users/connection.php">Encore ?</a></p>
	<?PHP $_SESSION["log"] = NULL; endif;?>

	<div class="header_container">
<?PHP include_once("./Database/header.php"); ?>
	</div>
	<?PHP if ((isset($_SESSION['log']) && $_SESSION['log'] !== "wrong" && $_SESSION['log'] !== "notactiv" && $_SESSION['log'] != NULL)): ?>
				<form class="upload_container">

					<input id="upl" value="test_alert" type="txt" name="upld" hidden="hidden"></input>
	<?php if (isset($_GET["filtre"]) && $_GET["filtre"] != "")
					echo"Tu peux upload une image : <input id=\"upload\" type=\"file\" accept=\".jpg, .png, .jpeg, .gif\" name=\"upload\">";
			else
				echo"<input id=\"upload\" type=\"file\" accept=\".jpg, .png, .jpeg, .gif\" name=\"upload\" hidden=\"hidden\">"; ?>
				</form>
			<div class="center_container">
				<video id="video" class="camera" autoplay="">  </video>
				<div class="filter_container">
				<form>
					<button class="grille" id="filtre" value="./filtres/grillage-camagram.png" type="submit"  name="filtre"></button>
					<button class="crash" id="filtre" value="./filtres/crash-camagram.png" type="submit"  name="filtre"></button>
					<button class="chou" id="filtre" value="./filtres/cauliflower-camagram.png" type="submit"  name="filtre"></button>
				</form>
	<?php if (isset($_GET["filtre"]) && $_GET["filtre"] != "")
				echo "<button id='take'>Prendre une photo</button>";
			else
				echo "<button id='take' hidden='hidden'>Prendre une photo</button>";
			?>
				<form method="post">
					<input id="image"  type="txt" name="stp" hidden="hidden"></input>
					<button id="id_tof" type="submit" name="id_tof" value="OK" hidden="hidden"> Enregistrer la photo </button>
				</form>
				</div>
				<img id="img" src="" hidden="hidden">
				<canvas class="apercu" id="canvas"></canvas>
			</div>
				</br>
	<?PHP endif;?>

	<?PHP
	if (isset($_GET["filtre"]))
			$_SESSION["filtre"] = $_GET["filtre"];

	else if (isset($_POST["id_tof"]))
		header("Location:./index.php?nofilter");

	if (isset($_POST["id_tof"], $_POST["stp"], $_SESSION["filtre"]) && $_POST["id_tof"] === "OK" && $_SESSION["filtre"] != NULL && $_POST["stp"] != NULL)
	{
		ft_create_png($_POST["stp"], $_SESSION["filtre"]);
		$_SESSION["filtre"] = NULL;
	}

	if (isset($_POST["id_tof"], $_POST["upl"], $_SESSION["filtre"]) && $_POST["id_tof"] === "OK" && $_SESSION["filtre"] != NULL)
	{
		header("Location:./index.php?nofilter");
		ft_create_png($_POST["upld"], $_SESSION["filtre"]);
		$_SESSION["filtre"] = NULL;
	}
	?>

	<form method="post" class="miniature_container">
		<?PHP
		if (isset($_POST["pic"]) && $_POST["pic"] != "")
			ft_suppr_your_photo($_POST["pic"], $_SESSION["log"]);

		if ((isset($_SESSION['log']) && $_SESSION['log'] !== "wrong" && $_SESSION['log'] !== "notactiv" && $_SESSION['log'] != NULL))
			ft_aff_your_photo();
		?>
	</form>
<?PHP if (isset($_SESSION["log"]) && $_SESSION["log"] != ""): ?>
	<script src="./Users/camera.js">
	</script>
	<?PHP endif ; ?>
		<div class="footer_container">
	<?PHP include_once("./Database/footer.php"); ?>
		</div>

</div>
	</body>
</html>
