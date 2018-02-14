<?php

header("Content-type: image/jpeg");
$jpeg = fopen("/home/ifoundit/tmp.jpg","r");
$image = fread($jpeg,filesize("/home/ifoundit/tmp.jpg"));
echo $image;

?>