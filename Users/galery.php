<?PHP
include("./aff_all.php");
include("../Database/ft_co_db.php");
include("../Database/ft_add_photo.php");
?>

<HTML>

	<head>
		<link rel="stylesheet" href="../Database/index.css"/>
	</head>
<div class="header_container">
<?PHP include("../Database/header.php"); ?>
</div>
	<BODY class="page_container">

		</br>

		<form class="page_container" method="post">

			<?PHP
			if (isset($_POST['page']))
			{
				if ($_SESSION['page'] > 1 && $_POST['page'] === "previous")
					$_SESSION['page'] = $_SESSION['page'] - 1;
				if ($_SESSION['page'] >= 1 && $_SESSION['page'] < ($_SESSION['nb_pic'] / 5) && $_POST['page'] === "next")
					$_SESSION['page'] = $_SESSION['page'] + 1;
			}

			if (isset($_POST["comment"], $_SESSION["log"]) && $_POST["comment"] != "" && $_SESSION["log"] != "")
			{
				$_SESSION["pic"] = $_POST["comment"];
				header("Location:./pic_page.php");
			}

			if (isset($_POST["like"], $_SESSION["log"]) && $_POST["like"] != "" && $_SESSION["log"] != "")
				like($_POST["like"]);

			if (isset($_POST["pic"], $_SESSION["log"]) && $_POST["pic"] != "" && $_SESSION["log"] != "")
				ft_is_your($_POST["pic"], $_SESSION["log"]);

			ft_aff_all($_SESSION['page']);
			ft_count_all();
			?>

		</form>

		<form class="previous_next" method='post'>
		<?PHP if ($_SESSION["page"] !== 1):?>
			<button class="prev" name="page" type='submit' value='previous'> << </button>
		<?PHP endif;?>
			<?php  echo"<div class=\"nb_page\">". $_SESSION['page'] ."</div>"   ?>
		<?PHP if ((($_SESSION["page"]) < ($_SESSION['nb_pic'] / 5))):?>
			<button class="prev" name="page" type='submit' value='next'> >> </button>
		<?PHP endif; ?>
		</form>

		<?PHP include("../Database/footer.php"); ?>
	</BODY>

</HTML>
