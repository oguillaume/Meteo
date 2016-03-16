<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

$hum_int=array();
$hum_out=array();

$file=fopen("releves.json","rb");
$str=fread($file,filesize("releves.json"));
$temp=json_decode($str);

fclose($file);

for($i=1;$i<4;$i++)
{
	$hum_int[$i-1]=$temp->releve[$i]->Hum_int;

	$hum_out[$i-1]=$temp->releve[$i]->Hum_ext;
}

$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_hum_ext = new LinePlot($hum_out);
$courbe_hum_ext->setColor('red');
$courbe_hum_ext->setLegend('hum_ext');
$courbe_hum_int = new LinePlot($hum_int);
$courbe_hum_int->setColor('green');
$courbe_hum_int->setLegend('hum_int');

$graphe->add($courbe_hum_ext);    // Ajout des courbes au graphique
$graphe->add($courbe_hum_int);
// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Humidités extérieure & intérieure")); 
$graphe->yaxis->setTitle(utf8_decode("Humidité"));
$graphe->xaxis->setTitle("minutes");
$graphe->xaxis->setTicklabels($temps);  // Echelle axe des abscisses

$graphe->stroke();  // Affichage du graphique
?>