<?PHP
function ft_mail($login_hash, $mail, $cle, $login)
{
	$server_name = $_SERVER['REMOTE_ADDR'];
	$destinataire = $mail;
	$sujet = "Activer votre compte";
	$entete = "From: inscription@camagram.com";

	$message = "Bienvenue sur Camagram $login,
 
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou copier/coller dans votre navigateur internet.
 
http://localhost:8033/Users/validation.php?cle=$cle;
 
 
---------------
Ceci est un mail automatique, Merci de ne pas y répondre.";
mail($destinataire, $sujet, $message, $entete);
}
?>

<HTML>
	<BODY>
		<?php if (isset($_GET["inscription"]) && $_GET["inscription"] === "ok"): ?>
		<p class="success">Votre inscription a ete accepte, vous devez maintenant activer votre compte en cliquant sur le liens qui vous a ete envoye par mail.</p>
		<a href="./connection.php">Login</a>
		<?php endif; ?>
	</BODY>
</HTML>
