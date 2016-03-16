<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

$pression=array();

$file=fopen("releves.json","rb");
$str=fread($file,filesize("releves.json"));
$temp=json_decode($str);

fclose($file);

for($i=1;$i<4;$i++)
{
	$pression[$i-1]=$temp->releve[$i]->Pression;

}

$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_baro = new LinePlot($pression);
$courbe_baro->setColor('red');



$graphe->add($courbe_baro);    // Ajout des courbes au graphique
// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Pression atmosphérique")); 
$graphe->yaxis->setTitle(utf8_decode("Pression"));
$graphe->xaxis->setTitle("minutes");
$graphe->xaxis->setTicklabels($temps);  // Echelle axe des abscisses

$graphe->stroke();  // Affichage du graphique
?>