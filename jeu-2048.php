<?php 
 require_once 'fonctions-2048.php';
 $score = 0;
 $grille
 ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UFT-8" />
		<?php
		// le code php se situe ici
		if ($_GET['action-joueur'] == "Nouvelle partie") {
			nouvelle_partie();
		} else {
            fichier_vers_matrice();
            fichier_vers_score();
		}
 		?>
        <title>Le Jeu 2048</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <h1>Bienvenue sur le jeu 2048.</h1>
        <div class="regles">
            <p>
                Le <b>jeu 2048</b> se joue sur une grille de 4*4. Chaque case est rempli d'une <b>puissance de deux</b>.
                <br /> On peut changer la position des cases avec les <b>boutons</b>. Si deux cases ont la <b>meme valeur</b> elles <b>s'additionneront</b>.
                <br /> L'objectif est d'obtenir le score <b>2048</b>.
                <br /> <b>Bonne chance.</b>
            </p>
		</div>
		<?php
		// le code php se situe ici4
        fichier_vers_score();
        write_log($score);
		if ($_GET['action-joueur'] == "Gauche") {
			for ($i=0; $i<4; $i++) {
				decale_ligne_gauche($i);
				fusion_ligne_gauche($i);
				decale_ligne_gauche($i);
			}
			place_nouveau_nb();
		} else if ($_GET['action-joueur'] == "Haut") {
			for ($i=0; $i<4; $i++) {
				decale_col_haut($i);
				fusion_col_haut($i);
				decale_col_haut($i);
			}
			place_nouveau_nb();
		} else if ($_GET['action-joueur'] == "Bas") {
			for ($i=0; $i<4; $i++) {
				decale_col_bas($i);
				fusion_col_bas($i);
				decale_col_bas($i);
			}
			place_nouveau_nb();
		} else if ($_GET['action-joueur'] == "Droite") {
			for ($i=0; $i<4; $i++) {
				decale_ligne_droite($i);
				fusion_ligne_droite($i);
				decale_ligne_droite($i);
			}
			place_nouveau_nb();
		} 
 		?>
        <div class="boutons"> <br/> Votre score est: <?php affiche_score() ?>. <a href=""> Recharger la page.</a> </div>
        <form class="button" name="jeu-2048" method="get" action="jeu-2048.php"> 
            <input type="submit" name="action-joueur" value="Nouvelle partie" /> </p>
        </form>
        <table>
            <tr> <?php affiche_case(0, 0) ?> <?php affiche_case(0, 1) ?> <?php affiche_case(0, 2) ?> <?php affiche_case(0, 3) ?> </tr>
            <tr> <?php affiche_case(1, 0) ?> <?php affiche_case(1, 1) ?> <?php affiche_case(1, 2) ?> <?php affiche_case(1, 3) ?> </tr>
            <tr> <?php affiche_case(2, 0) ?> <?php affiche_case(2, 1) ?> <?php affiche_case(2, 2) ?> <?php affiche_case(2, 3) ?> </tr>
            <tr> <?php affiche_case(3, 0) ?> <?php affiche_case(3, 1) ?> <?php affiche_case(3, 2) ?> <?php affiche_case(3, 3) ?> </tr>
        </table>
        <form name="jeu-2048" method="get" action="jeu-2048.php"> 
                <input class="gauche" type="submit" name="action-joueur" value="Gauche" /> </p>
                <input class="haut" type="submit" name="action-joueur" value="Haut" /> </p>
                <input class="bas" type="submit" name="action-joueur" value="Bas" /> </p>
                <input class="droite" type="submit" name="action-joueur" value="Droite" /> </p>
		</form>
		<p class="liens"> Lien de la <a href="http://perso.univ-lyon1.fr/olivier.gluck/supports_enseig.html#LIFASR2">page web de l'UE</a>. </p>
		<?php
			matrice_vers_fichier();
		?>
    </body>
</html>