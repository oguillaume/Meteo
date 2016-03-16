<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>Station Meteo Lycée Maupertuis</title>
	</head>
	<body lang="fr-FR" dir="ltr" style="background: #123456 ; color : #ffffff">
		<h1 align="center">Relev&eacute;s de la station</h1>
		<table width="1500" style="border:1px solid" align="center">
			<tr align="center">
				<td width="150">Date</td>
				<td width="150">Pression atmo</td>
				<td width="150">Température intérieure</td>
				<td width="150">Humidité intérieure</td>
				<td width="150">Tempérarature extérieure</td>
				<td width="150">Humidité extérieure</td>
				<td width="150">Vitesse vent</td>
				<td width="150">Sens vent</td>
				<td width="100">Hauteur pluie</td>
				<td width="100">Facteur UV</td>
				<td width="100">Radiation solaire</td>
			</tr>

<?php
//Enregistrement en BDD
$Bdd_hote='localhost';
$Bdd_port='3306';
$Bdd_nom_bd='test1';
$Bdd_user='root';
$Bdd_mot_de_passe='';


$connexion= new PDO('mysql:host='.$Bdd_hote.';port='.$Bdd_port.';dbname='.$Bdd_nom_bd,$Bdd_user,$Bdd_mot_de_passe);
$requete="SELECT * FROM meteo";
$forme_resultats=$connexion->query($requete);
$forme_resultats->setFetchMode(PDO::FETCH_OBJ);


while( $resultat = $forme_resultats->fetch() )
{ 
	$pression=$resultat->pression/100;
	$temp_in=(int)($resultat->temp_in/100);	
	$temp_out=(int)($resultat->temp_out/100);
	switch ($resultat->vent_dir){
		case 0 : $vent_dir='N'; break;
		case 22 :$vent_dir='NNE';break;
		case 45 : $vent_dir='NE';break;
		case 67 : $vent_dir='ENE';break;
		case 90 : $vent_dir='E';break;
		case 112 : $vent_dir='ESE'; break;
		case 135 : $vent_dir='SE';break;
		case 157 : $vent_dir='SSE';break;
		case 180 : $vent_dir='S';break;
		case 202 : $vent_dir='SSO';break;
		case 225 : $vent_dir='SO';break;
		case 247 : $vent_dir='OSO'; break;
		case 270 : $vent_dir='O';break;
		case 292 : $vent_dir='ONO';break;
		case 315 : $vent_dir='NO';break;
		case 337 : $vent_dir='NNO';break;
		default: $vent_dir=$resultat->vent_dir;
	}
	echo'	<tr align="center">	
				<td width="150" style="border:1px solid">'.$resultat->date.'</td>
				<td width="150" style="border:1px solid">'.$pression.' hPa</td>
				<td width="150" style="border:1px solid">'.$temp_in.'&#176;C </td>
				<td width="150" style="border:1px solid">'.$resultat->hum_in.'%</td>
				<td width="150" style="border:1px solid">'.$temp_out.'&#176;C </td>
				<td width="150" style="border:1px solid">'.$resultat->hum_out.'%</td>
				<td width="150" style="border:1px solid">'.$resultat->vent_vit.'km/h</td>
				<td width="150" style="border:1px solid">'.$resultat->vent_dir.'</td>
				<td width="10" style="border:1px solid">'.$resultat->h_pluie.'mm</td>
				<td width="10" style="border:1px solid">'.$resultat->fac_uv.'</td>
				<td width="100" style="border:1px solid">'.$resultat->solar_rad.'W/m²</td>
			</tr>';	
}
$forme_resultats->closeCursor(); 
?>			
		</table>
	</body>
</html>

					
					
