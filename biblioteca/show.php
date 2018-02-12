<?php

header("Content-type: image/jpeg");
$jpeg = fopen("/tmp/IFoundit/tmp.jpg","r");
$image = fread($jpeg,filesize("/tmp/IFoundit/tmp.jpg"));
echo $image;

?>