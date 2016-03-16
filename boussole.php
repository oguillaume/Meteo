<?php
$largeur = 150;
$hauteur = 150;
$originex=75;
$originey=75;
$posy=50;
$posy=50;

$image= new \ImagickDraw();


$image->setFontSize(12);
$image->setStrokeWidth(2);
$image->setStrokeColor(256);
$image->circle($originex,$originey,$posx,$posy);

$imagick = new \Imagick();
$imagick->newImage($largeur,$hauteur,'cyan');
$imagick->setImageFormat("png");
$imagick->drawImage($image);

header("Content-Type: image/png");
echo $imagick->getImageBlob();
?>