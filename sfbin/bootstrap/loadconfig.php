<?php

//Get directory listing for config folder and bring in all the files
$_sf_config_layout = scandir(_SFDIR . "config");
unset($_sf_config_layout[0], $_sf_config_layout[1]);
foreach($_sf_config_layout as $i) {
	
	require_once _SFDIR . "config/" . $i;
	
}
//cleanup
unset($_sf_config_layout);

?>