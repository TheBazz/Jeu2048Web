<!-- fonctions-2048.php -->
<?php
    function  affiche_sept_variables () {
        echo "HTTP_USER_AGENT="; echo $_SERVER['HTTP_USER_AGENT']; echo "<br />";
        echo "HTTP_HOST="; echo $_SERVER['HTTP_HOST']; echo "<br />";
        echo "DOCUMENT_ROOT="; echo $_SERVER['DOCUMENT_ROOT']; echo "<br />";
        echo "SCRIPT_FILENAME="; echo $_SERVER['SCRIPT_FILENAME']; echo "<br />";
        echo "PHP_SELF="; echo $_SERVER['PHP_SELF']; echo "<br />";
        echo "REQUEST_URI="; echo $_SERVER['REQUEST_URI']; echo "<br />";
        echo "action-joueur="; echo $_GET['action-joueur']; echo "<br />";
        }

    function write_log ($mesg) {
        $file = 'logs-2048.txt';
        file_put_contents($file, $mesg, FILE_APPEND);
    }

    function affiche_logs ($nbl) {
        $logs = file("logs-2048.txt");
        foreach ($logs as $i => $line) {
	        echo ($i+1) . " : " . htmlspecialchars($line) . "<br />\n"; 
        }
    }

    function affiche_score () {
        global $score;
        fichier_vers_score();
        echo $score;
    }

    function score_vers_fichier () {
        global $score;
        file_put_contents("score.txt", $score);
    }

    function fichier_vers_score () {
        global $score;
        $score = file_get_contents("score.txt");
    }

    function nouvelle_partie () {
        global $grille;
        global $score;
        $score = 0;
        score_vers_fichier();
        $grille = array_fill(0, 4, array_fill(0, 4, 0));
        $pos = tirage_position_vide();
        $grille[$pos[0]][$pos[1]] = 2;
        $pos = tirage_position_vide();
        $grille[$pos[0]][$pos[1]] = 2;
        // write_log("\n");
        for ($i=0; $i<4; $i++) {
            for ($j=0; $j<4; $j++) {
                // write_log($grille[$i][$j]);
                // write_log(' ');
            }
            // write_log("   ");
        }
    }

    function matrice_vers_fichier () {
        global $grille;
        file_put_contents("grille.txt", '');
        for ($i=0; $i<4; $i++) {
            for ($j=0; $j<4; $j++) {
                file_put_contents("grille.txt", $grille[$i][$j], FILE_APPEND);
                file_put_contents("grille.txt", ' ', FILE_APPEND);
            }
            file_put_contents("grille.txt", "\n", FILE_APPEND);
        }
    }

    function fichier_vers_matrice () {
        global $grille;
        $chaine = file_get_contents('grille.txt');
        $chaine = str_replace("\n", "", $chaine);
        $valeurs = explode(' ', $chaine);
        $n = 0;
        for ($i = 0; $i < 4 ; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $grille[$i][$j] = (int) ($valeurs[$n]);
                $n++;
            }
        }
    }

    function affiche_case ($i, $j) {
        global $grille;
        //echo $grille[$i][$j];
        switch ($grille[$i][$j]) {
            case 0:
                echo ("<td>  </td>"); break;
            case 2:
                echo "<td class='c2'> 2 </td>"; break;
            case 4:
                 echo "<td class='c4'> 4 </td>"; break;
            case 8:
                 echo "<td class='c8'> 8 </td>"; break;
            case 16:
                echo "<td class='c16'> 16 </td>"; break;
            case 32:
                echo "<td class='c32'> 32 </td>"; break;
            case 64:
                echo "<td class='c64'> 64 </td>"; break;
            case 128:
                echo "<td class='c128'> 128 </td>"; break;
            case 256:
                echo "<td class='c256'> 256 </td>"; break;
            case 512:
                echo "<td class='c512'> 512 </td>"; break;
            case 1024:
                echo "<td class='c1024'> 1024 </td>"; break;
            case 2048:
                echo "<td class='c2048'> 2048 </td>"; break;
        }
        /*
        if ($grille[$i][$j]!=0) {
           echo ($grille[$i][$j]);
        } else {
            echo (' ');
        }
        */
    }

    function tirage_position_vide () {
        global $grille;
        global $val;
        do {
            $val = array_fill(0, 2, 0);;
            $val[0] = rand(0, 3);
            $val[1] = rand(0, 3);
        } while ($grille[$val[0]][$val[1]]);
        return $val;
    }

    function grille_pleine () {
        global $grille;
        for ($i = 0; $i < 4 ; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if ($grille[$i][$j]==0) {
                    return false;
                }
            }
        }
        return true;
    }

    function tirage_2ou4 () {
        $val  = rand(1, 4);
        $val = ($val==1) ? 4 : 2;
        return $val;
    }

    function place_nouveau_nb () {
        global $grille;
        if (!grille_pleine()) {
            // write_log("fonctionne ");
            $pos = tirage_position_vide();
            $grille[$pos[0]][$pos[1]] = tirage_2ou4();
        }
    }

    function decale_ligne_gauche ($l) {
        global $grille;
        $ligne = array_fill(0,4,0);
        $i = 0;
        for ($j = 0; $j < 4; $j++)
        {
            if ($grille[$l][$j] != 0)
            {
                $ligne[$i] = $grille[$l][$j];
                $i++;
            }
        }
        $grille[$l] = $ligne;
    }
    function decale_ligne_droite ($l) {
        global $grille;
        $ligne = array_fill(0,4,0);
        $i = 3;
        for ($j = 3; $j >= 0; $j--)
        {
            if ($grille[$l][$j] != 0)
            {
                $ligne[$i] = $grille[$l][$j];
                $i--;
            }
        }
        $grille[$l] = $ligne;
    }

    function decale_col_haut ($c) {
        global $grille;
        $colonne = array_fill(0, 4, 0);
        $i = 0;
        for ($j = 0; $j < 4; $j++) {
            if ($grille[$j][$c] != 0) {
                $colonne[$i] = $grille[$j][$c];
                $i++;
            }
        }
        for ($j=0; $j<4; $j++) {
            $grille[$j][$c] = $colonne[$j];
        }
    }

    function decale_col_bas ($c) {
        global $grille;
        $colonne = array_fill(0, 4, 0);
        $i = 3;
        for ($j = 3; $j >= 0; $j--) {
            if ($grille[$j][$c] != 0) {
                $colonne[$i] = $grille[$j][$c];
                $i--;
            }
        }
        for ($j=0; $j<4; $j++) {
            $grille[$j][$c] = $colonne[$j];
        }
    }

    function fusion_ligne_gauche ($l) {
        global $grille;
        global $score;
        if ($grille[$l][0] == $grille[$l][1])
        {
            $grille[$l][0] = 2 * $grille[$l][0];
            $score += $grille[$l][0];
            $grille[$l][1] = 0;
            if ($grille[$l][2] == $grille[$l][3])
            {
                $grille[$l][2] = 2 * $grille[$l][2];
                $score += $grille[$l][2];
                $grille[$l][3] = 0;		
            }		
        }
        else if ($grille[$l][1] == $grille[$l][2])
        {
            $grille[$l][1] = 2 * $grille[$l][1];
            $score += $grille[$l][1];
            $grille[$l][2] = 0;
        }	
        else if ($grille[$l][2] == $grille[$l][3])
        {
            $grille[$l][2] = 2 * $grille[$l][2];
            $score += $grille[$l][2];
            $grille[$l][3] = 0;
        }	
        score_vers_fichier($score);
    }

    function fusion_ligne_droite ($l) {
        global $grille;
        global $score;
        if ($grille[$l][0] == $grille[$l][1])
        {
            $grille[$l][1] = 2 * $grille[$l][1];
            $score += $grille[$l][1];
            $grille[$l][0] = 0;
            if ($grille[$l][2] == $grille[$l][3])
            {
                $grille[$l][3] = 2 * $grille[$l][3];
                $score += $grille[$l][3];
                $grille[$l][2] = 0;		
            }		
        }
        else if ($grille[$l][1] == $grille[$l][2])
        {
            $grille[$l][2] = 2 * $grille[$l][2];
            $score += $grille[$l][2];
            $grille[$l][1] = 0;
        }	
        else if ($grille[$l][2] == $grille[$l][3])
        {
            $grille[$l][3] = 2 * $grille[$l][3];
            $score += $grille[$l][3];
            $grille[$l][2] = 0;
        }	
        score_vers_fichier($score);
    }

    function fusion_col_haut ($c) {
        global $grille;
        global $score;
        if ($grille[0][$c] == $grille[1][$c])
        {
            $grille[0][$c] = 2 * $grille[0][$c];
            $score += $grille[0][$c];
            $grille[1][$c] = 0;
            if ($grille[2][$c] == $grille[3][$c])
            {
                $grille[2][$c] = 2 * $grille[2][$c];
                $score += $grille[2][$c];
                $grille[3][$c] = 0;		
            }		
        }
        else if ($grille[1][$c] == $grille[2][$c])
        {
            $grille[1][$c] = 2 * $grille[1][$c];
            $score += $grille[1][$c];
            $grille[2][$c] = 0;
        }	
        else if ($grille[2][$c] == $grille[3][$c])
        {
            $grille[2][$c] = 2 * $grille[2][$c];
            $score += $grille[2][$c];
            $grille[3][$c] = 0;
        }	
        score_vers_fichier($score);
    }

    function fusion_col_bas ($c) {
        global $grille;
        global $score;
        if ($grille[0][$c] == $grille[1][$c])
        {
            $grille[1][$c] = 2 * $grille[1][$c];
            $score += $grille[1][$c];
            $grille[0][$c] = 0;
            if ($grille[2][$c] == $grille[3][$c])
            {
                $grille[3][$c] = 2 * $grille[3][$c];
                $score += $grille[3][$c];
                $grille[2][$c] = 0;		
            }		
        }
        else if ($grille[1][$c] == $grille[2][$c])
        {
            $grille[2][$c] = 2 * $grille[2][$c];
            $score += $grille[2][$c];
            $grille[1][$c] = 0;
        }	
        else if ($grille[2][$c] == $grille[3][$c])
        {
            $grille[3][$c] = 2 * $grille[3][$c];
            $score += $grille[3][$c];
            $grille[2][$c] = 0;
        }	
        score_vers_fichier($score);
    }
?>