<?php
include ("Graphiques/src/jpgraph.php");
include ("Graphiques/src/jpgraph_radar.php");
include ("Graphiques/src/jpgraph_log.php");

$girouette=array();
// On se connecte à MySQL
 try
          {
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
		  $girouette[$i] = $donnees['vent_dir'];
          $i++; 
		  }
		// tableau pour nombres d'entrées par secteur de vent (i.e 'ENE')
		  $vent_direc=array();
		  //initialisation du tableau
		  for($i=0;$i<16;$i++){
			  $vent_direc[$i]=0;
		  }
		  // on recherche pour chaque secteur combien de fois le vent y a tourné
		  for($i=0;$i<sizeof($girouette);$i++){
			  for($j=0;$j<16;$j++){
				if($j*(360/16)<$girouette[$i]&& $girouette[$i]<(($j+1)*(360/16)))
				  $vent_direc[$j]=$vent_direc[$j]+1;
				}
			  
		  }
	
$largeur = 350;
$hauteur = 200;
$secteur=array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSO','SO','OSO','O','ONO','NO','NNO');
$graphe = new RadarGraph($largeur, $hauteur);  // Création du graphique

// Titre du graphique et des échelles
$graphe->title->set(utf8_decode("Direction du vent")); 
$graphe->title->setFont(FF_VERDANA,FS_NORMAL,12);
$graphe->setTitles($secteur);

$graphe->SetCenter(0.35,0.55);

$graphe->SetColor('#cccccc@0.3');
$graphe->axis->SetColor('blue@0.5');
$graphe->grid->SetColor('blue@0.5');
//$graphe->grid->Show();
//$graphe->axis->title->Setfont(FF_ARIAL,FS_NORMAL,10);
//$graphe->axis->title->SetMargin(5);

//tracé des résultats
$plot1=new RadarPlot($vent_direc);
$plot1->SetColor('red');
$plot1->SetLineWeight(1);
$plot1->SetFillColor('red@0.8');
$plot1->mark->SetType(MARK_SQUARE);

$graphe->Add($plot1);

$graphe->stroke();  // Affichage du graphique
?>