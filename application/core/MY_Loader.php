<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	public function test($class = '', $data = array()) {
		
		if (file_exists(APPPATH."presenters/".strtolower($class).EXT)) {  
			@include_once(APPPATH."presenters/".strtolower($class).EXT);  
		}

		return new $class($data);
	}

}