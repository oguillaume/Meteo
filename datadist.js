
  function ConstruireCarte()
  {
	var maLatLng1={lat:48.0833,lng:-1.6833}; //SAINT-MALO
	var optionsGoogleMap={zoom: 8,
							center:maLatLng1,
							mapTypeId: google.maps.MapTypeId.ROADMAP}
	var maCarteMeteo=new google.maps.Map(document.getElementById("maCarte"),optionsGoogleMap);
	var Marqueur=new google.maps.Marker({
			position : maLatLng1,
			map : maCarteMeteo,
			title :"Position station meteo"});
  }
  function getReleves()
  { 
    var Releve = new XMLHttpRequest();
     Releve.open('GET','relevesdist.json',false);
     Releve.send(null);alert(Releve.responseText);
     var relevem= JSON.parse(Releve.responseText);
	 /*alert(Releve.responseText); */
     document.getElementById("pression").innerHTML=relevem.releve[1].Pression;
	 document.getElementById("date").innerHTML=relevem.releve[1].Date;
	 document.getElementById("hum_in").innerHTML=relevem.releve[1].Hum_int;
	 document.getElementById("hum_out").innerHTML=relevem.releve[1].Hum_ext;
	 document.getElementById("temp_in").innerHTML=relevem.releve[1].Temp_int;
	 document.getElementById("temp_out").innerHTML=relevem.cc.tmp;
	 document.getElementById("rad").innerHTML=relevem.releve[1].Soleil;
	 document.getElementById("dir_vent").innerHTML=relevem.cc.wind.d;
	 document.getElementById("vit_vent").innerHTML=relevem.cc.wind.s*1.6093;
	 document.getElementById("uv").innerHTML=relevem.releve[1].UV;
	 ConstruireCarte();
   
  } 