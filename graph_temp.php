<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

$temp_int=array();
$temp_out=array();

$file=fopen("releves.json","rb");
$str=fread($file,filesize("releves.json"));
$temp=json_decode($str);

fclose($file);

for($i=1;$i<4;$i++)
{
	$temp_int[$i-1]=$temp->releve[$i]->Temp_int;

	$temp_out[$i-1]=$temp->releve[$i]->Temp_ext;
}

$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_temp_ext = new LinePlot($temp_out);
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