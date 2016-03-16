<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

 $pression = array();
 


         try
          {
  // On se connecte à MySQL
          //Enregistrement en BDD
		$Bdd_hote='localhost';
		$Bdd_port='3306';
		$Bdd_nom_bd='test1';
		$Bdd_user='root';
		$Bdd_mot_de_passe='';

		$connexion= new PDO('mysql:host='.$Bdd_hote.';port='.$Bdd_port.';dbname='.$Bdd_nom_bd,$Bdd_user,$Bdd_mot_de_passe);
	
          }
          catch(Exception $e)
          {
  // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
          }

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table jeux_video
          $reponse = $connexion->query('SELECT * FROM meteo');

// On affiche chaque entrée une à une
          $i = 0 ;
          while ($donnees = $reponse->fetch())
          {
          $pression[$i] = $donnees['pression']/100;
//		  $temp_out[$i] = $donnees['temp_out']/100;
          $i++; 
		  }



$temp_ext = array(12,10,5,4,-1,-2,0,6,10,15,17,23); // Tableau de valeurs températures extérieures
$temp_int = array(18,17,15,14,14,12,13,15,18,19,20,20.5); // Tableau de valeurs températures extérieures
$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_pression = new LinePlot($pression);
$courbe_pression->setColor('red');
$courbe_pression->setLegend('temp_ext');
/*$courbe_temp_int = new LinePlot($temp_in);
$courbe_temp_int->setColor('green');
$courbe_temp_int->setLegend('temp_int');*/

$graphe->add($courbe_pression);    // Ajout des courbes au graphique
//$graphe->add($courbe_temp_int); 
// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Pression atmosphérique")); 
$graphe->yaxis->setTitle(utf8_decode("Pression"));
$graphe->xaxis->setTitle("minutes");
$graphe->xaxis->setTicklabels($temps);  // Echelle axe des abscisses

$graphe->stroke();  // Affichage du graphique
?>