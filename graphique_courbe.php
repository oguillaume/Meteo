<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

$temp_ext = array(12,10,5,4,-1,-2,0,6,10,15,17,23); // Tableau de valeurs températures extérieures
$temp_int = array(18,17,15,14,14,12,13,15,18,19,20,20.5); // Tableau de valeurs températures extérieures
$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_temp_ext = new LinePlot($temp_ext);
$courbe_temp_ext->setColor('red');
$courbe_temp_ext->setLegend('temp_ext');
$courbe_temp_int = new LinePlot($temp_int);
$courbe_temp_int->setColor('green');
$courbe_temp_int->setLegend('temp_int');

$graphe->add($courbe_temp_ext);    // Ajout des courbes au graphique
$graphe->add($courbe_temp_int);
// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Températures extérieure & intérieure")); 
$graphe->yaxis->setTitle(utf8_decode("Température"));
$graphe->xaxis->setTitle("minutes");
$graphe->xaxis->setTicklabels($temps);  // Echelle axe des abscisses

$graphe->stroke();  // Affichage du graphique
?>