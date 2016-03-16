<?php
require_once("Graphiques/src/jpgraph.php");  // Attention au sous-répertoire utilisé
require_once("Graphiques/src/jpgraph_line.php");

$uv=array();
$soleil=array();

$file=fopen("releves.json","rb");
$str=fread($file,filesize("releves.json"));
$temp=json_decode($str);

fclose($file);

for($i=1;$i<4;$i++)
{
	$uv[$i-1]=$temp->releve[$i]->UV;

	$soleil[$i-1]=$temp->releve[$i]->Soleil;
}

$temps = array(1,2,3,4,5,7,8,9,10,11,12,14); //Temps d'acquisition
$largeur = 350;
$hauteur = 200;

$graphe = new Graph($largeur, $hauteur);  // Création du graphique

$graphe->setScale("intint"); // Echelle abscisse [entiers]  les valeurs min et max seront determinees automatiquement
// Creation des deux  courbes : couleurs et légendes
$courbe_uv = new LinePlot($uv);
$courbe_uv->setColor('red');
$courbe_uv->setLegend('UV');
$courbe_soleil = new LinePlot($soleil);
$courbe_soleil->setColor('green');
$courbe_soleil->setLegend('rad solaire');

$graphe->add($courbe_uv);     // Ajout des courbes au graphique
$graphe->add($courbe_soleil);
// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Soleil : UV et taux de radiations")); 
$graphe->yaxis->setTitle(utf8_decode("Soleil"));
$graphe->xaxis->setTitle("minutes");
$graphe->xaxis->setTicklabels($temps);  // Echelle axe des abscisses

$graphe->stroke();  // Affichage du graphique
?>