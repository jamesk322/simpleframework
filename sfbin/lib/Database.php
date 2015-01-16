<?php

class DB {
	
	public static function query($query, $args = array(), $db_obj = "") {
		
		//Check if database connection object has been injected or requires initilisation
		$db_obj_provided = true;
		if(empty($db_obj)) {
			
			$db_obj = self::connect();
			$db_obj_provided = false;
			
		}
		
		//Get arg placeholders and replace them with the sanitised version
		if(strpos($query, "?")) {
			
			$query_explode = explode("?", $query);
			$query_and_args = "";
			for($i = 0; $i <= count($query_explode) - 1; $i ++) {
				
				if($i == count($query_explode) - 1) {
					
					$query_and_args .= $query_explode[$i];
					
				} else {
					
					$query_and_args .= $query_explode[$i] . "'" . $db_obj->real_escape_string($args[$i]) . "'";
					
				}
				
			}
			
			$query = $query_and_args;
			
		}
		
		$db_query = $db_obj->query($query);
		
		//Display errors
		echo $db_obj->error;
		
		//Check if the database object should be closed or left open
		if($db_obj_provided === false) {
			
			DB::close($db_obj);
			
		}
		
		return $db_query;
		
	}
	
	public static function connect() {
		
		//Create mysqli object with config args
		global $_sf_db;
		return new mysqli($_sf_db["host"], $_sf_db["username"], $_sf_db["password"], $_sf_db["database"]);
		
	}
	
	public static function close($db_obj) {
		
		$db_obj->close();
		
	}
	
}

?>