

	$tab1=file('http://wxdata.weather.com/wxdata/weather/local/FRXX0076?cc=*&unit=d&dayf=4');
	$tab2=file('http://xml.weather.com/weather/local/FRXX0076?cc=*&unit=d&dayf=4');
	//$tab3=file('http://ouest-france.fr');
	//$tab2=file('C:\\wamp\\www\\php\\TD-meteo\\releves.json');
	
	//$str2=implode($tab3);
	//echo $str2;
	//echo 'coco';
	$str=implode($tab1);
	$data=simplexml_load_string($str);
	$file=fopen("relevesdist.json","a+");
	fwrite($file,$data);
	fclose($file);
	
	$file=fopen("relevesdist.json","rb");
	$str=fread($file,filesize("relevesdist.json"));
	$temp=json_decode($str);

	fclose($file);
	
	
