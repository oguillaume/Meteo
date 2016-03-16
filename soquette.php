

<html>
	<head>
		<meta http-equiv="refresh" content="3000">
	</head><body>

<?php
echo "<h1> Relev&eacute;s m&eacute;t&eacute;orologiques</h1>";
//choix de la connection
if (isset($_POST["adresse"]) && !empty($_POST["adresse"]))
{
	$adresse=$_POST["adresse"];
	
}
$address=$adresse;

$port = 10001;
echo "Connexion via ".$address.":".$port." <br>";
$compteur=0;
do{

	// cr�ation de la connexion	
	try{
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) { 
			throw new Exception('socket create() a &eacute;chou�e');
		} else { echo '<br>'; }
		$result = socket_connect($socket, $address, $port);
		if ($result === false) { 
			throw new Exception('socket_connect() a &eacute;chou&eacute;e') ;
		} else { echo "<br>"; }
	} catch (Exception $e){
		echo 'Exception :',$e->getMessage(), "\n";
		socket_close($socket);
		exit("Connexion � la station non r&eacute;alis&eacute;e");
	} finally{

	$rev = "\n";
	$cpt =0;
	//reveil de la station
	do { socket_write($socket, $rev, strlen($rev));
		usleep(1200000); // 1.2 secondes
		$bytes = socket_recv($socket, $out, 2048, 0x2) ;
		$out= socket_read($socket,$bytes);
		$cpt++;
	} while((ord($out[0])!=10 || ord($out[1])!= 13) && $cpt != 3); // ord retourne le code ASCII d'un caract�re
	if((ord($out[0])==10  && ord($out[1])== 13)) 
	{
		echo "connexion � la station en cours<br>";// test connexion
	
		// Requ�te LOOP 1
		$rev2="LOOP 1\n";
		socket_write($socket,$rev2,strlen($rev2));
		usleep(1200000); // 1.2 secondes
		$bytes = socket_recv($socket, $out, 2048, 0x2) ;

		// R�cup�ration des donn�es brutes
		$loop1=socket_read($socket,$bytes);
	/*	if ($loop1[0]!=0x6 || $loop1[1]!='L' || $loop1[2]!='O' || $loop1[3]!='O'){
			echo 'probleme r�ception trame : $loop = / '.$loop1[0].'/'.$loop1[1].'/'.$loop1[2].'/'.$loop1[3];
		} else {*/
		$pression=ord($loop1[8])+ord($loop1[9])*256;
		$temp_in=ord($loop1[10])+ord($loop1[11])*256;
		$hum_in=ord($loop1[12]);
		$temp_out=ord($loop1[13])+ord($loop1[14])*256;
		$vent_vit=ord($loop1[15]);
		$vent_dir=ord($loop1[17])+ord($loop1[18])*256;
		$hum_out=ord($loop1[34]);
		$h_pluie=ord($loop1[42])+ord($loop1[43]);
		$uv=ord($loop1[44]);
		$solrad=ord($loop1[45])+ord($loop1[46])*256;
	
		// Traduction des donn�es
		$pression1=(int)(100*$pression*33.863/1000);
		$pression2=$pression1/100;
		echo 'Pression='.$pression2.'hPa <br>';
		$temp_in1=(int)(100*5/9*($temp_in/10-32));
		$temp_in2=$temp_in1/100;
		echo 'Temperature int�rieure : '.$temp_in2.'�C <br>'; 
		echo 'Humidit� int�rieure= '.$hum_in.' %<br>';
		$temp_out1=(int)(100*5/9*($temp_out/10-32));
		$temp_out2=$temp_out1/100;
		echo 'Temperature ext�rieure= '.$temp_out2.' �C <br>';
		echo 'Vitesse du vent= '.$vent_vit.' km/h <br> ';
		echo 'Direction vent= '.$vent_dir.' <br>';
		echo 'Humidit� ext�rieure= '.$hum_out.' %<br>';
		echo 'Hauteur pluie= '.$h_pluie.' mm<br>';
		echo 'taux UV= '.$uv.' %<br>';
		echo 'radiation solaire= '.$solrad.'W/m�<br>';

		//Enregistrement en BDD
		$Bdd_hote='localhost';
		$Bdd_port='3306';
		$Bdd_nom_bd='test1';
		$Bdd_user='root';
		$Bdd_mot_de_passe='';

		$connexion= new PDO('mysql:host='.$Bdd_hote.';port='.$Bdd_port.';dbname='.$Bdd_nom_bd,$Bdd_user,$Bdd_mot_de_passe);
		$date=date("d-m-Y H:i:s"); // recup date et heure de relev�
		echo $date." <br>";
		$requete_insert = "INSERT INTO meteo(date,pression,temp_in,temp_out,vent_dir,vent_vit,hum_in,hum_out,fac_uv,h_pluie,solar_rad) 
			VALUES('$date','$pression1','$temp_in1','$temp_out1','$vent_dir','$vent_vit','$hum_in','$hum_out','$uv','$h_pluie','$solrad')";
		//echo $requete_insert;
		$connexion->exec($requete_insert); 
		$compteur++;
		//} 
	}else echo "cpt=".$cpt;
	}
	$tempsdodo=date("d-m-Y H:i:s")+strtotime("+5 min");
	//echo $tempsdodo;
	while (time()<$tempsdodo) time_sleep_until($tempsdodo);
	
} while ($compteur < 100); // on prend une centaine de valeurs au max 


?>
</body>
</html>