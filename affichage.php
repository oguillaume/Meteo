<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

		<style type="text/css">
		h1.cjk { font-family: "SimSun" }
		h1.ctl { font-family: "Mangal" }
		table.ctl { font-family: "Times New Roman", font-size: "18"}
	</style>
	</head>
<body lang="fr-FR" dir="ltr" style="background: #123456 ; color : #ffffff ;text-valign: middle">
<?php
//Enregistrement en BDD
$Bdd_hote='localhost';
$Bdd_port='3306';
$Bdd_nom_bd='test1';
$Bdd_user='root';
$Bdd_mot_de_passe='';


$connexion= new PDO('mysql:host='.$Bdd_hote.';port='.$Bdd_port.';dbname='.$Bdd_nom_bd,$Bdd_user,$Bdd_mot_de_passe);
$requete="SELECT * FROM meteo ORDER BY date DESC LIMIT 1";
$forme_resultats=$connexion->query($requete);
$forme_resultats->setFetchMode(PDO::FETCH_OBJ);


while( $resultat = $forme_resultats->fetch() )
{ 
	$pression=$resultat->pression/100;
	$temp_in=(int)($resultat->temp_in/100);	
	$temp_out=(int)($resultat->temp_out/100);
	
	echo'<p align="center"><b>
				<table width="600" style="font-size: 23px">
				<col width="300"/>
				<col width="200"/>
				<tr>
				<td width="300">Le</td><td width="200">'.$resultat->date.'</td>
				</tr><tr>
				<td width="300">Pression atmosph&eacute;rique</td><td width="200">'.$pression.' hPa</td>
				</tr><tr>
				<td width="300">Temp&eacute;rature int&eacute;rieure</td><td>'.$temp_in.'&#176;C </td>
				</tr><tr>
				<td width="300">Humidit&eacute; int&eacute;rieure</td><td>'.$resultat->hum_in.'%</td>
				</tr><tr>
				<td width="300">Temp&eacute;rature ext&eacute;rieure</td><td>'.$temp_out.'&#176;C </td>
				</tr><tr>
				<td width="300">Humidit&eacute; ext&eacute;rieure</td><td>'.$resultat->hum_out.'%</td>
				</tr><tr>
				<td width="300">Vitesse du vent</td><td>'.$resultat->vent_vit.' km/h</td>
				</tr><tr>
				<td width="300">Direction du vent</td><td>'.$resultat->vent_dir.'</td>
				</tr><tr>
				<td width="300">Hauteur de pluie</td><td>'.$resultat->h_pluie.' mm</td>
				</tr><tr>
				<td width="300">Facteur UV</td><td>'.$resultat->fac_uv.'</td>
				</tr><tr>
				<td width="300">Radiations solaires</td><td>'.$resultat->solar_rad.' W/m&#178;</td>
				</tr>
				</table>
				</b></p>';	
}
$forme_resultats->closeCursor(); 
?>			
</body>
</html>