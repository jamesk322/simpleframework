<?php

//Get directory listing for class folder and bring in all the files
$_sf_class_layout = scandir(_SFDIR . "lib");
unset($_sf_class_layout[0], $_sf_class_layout[1]);
foreach($_sf_class_layout as $i) {
	
	require_once _SFDIR . "lib/" . $i;
	
}
//cleanup
unset($_sf_class_layout);

?>