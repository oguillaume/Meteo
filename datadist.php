<?php

	$tab1=file('http://wxdata.weather.com/wxdata/weather/local/FRXX0076?cc=*&unit=d&dayf=4');
	//$tab2=file('http://xml.weather.com/weather/local/FRXX0076?cc=*&unit=d&dayf=4');
	
	$str=implode($tab1);
	echo $str;
	$data=simplexml_load_string($str);
	echo 'babla';
	echo $data;
	$file=fopen("relevesdist.json","w+");
	$data=json_encode($data);
	fputs($file,$data);
	fclose($file);
	
	$file1=fopen("relevesdist.json","rb");
	$str=fread($file1,filesize("relevesdist.json"));
	$temp=json_decode($str);

	fclose($file1);
	
	
?>