<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	public function presenter($class = '', $data = array()) {
		

		$module_dir = $this->router->directory;
		$module_dir = str_replace('controllers/', '', $module_dir);
		$module_dir = str_replace('../', '', $module_dir);

		$found_path = FALSE;

		if (file_exists(APPPATH."presenters/".strtolower($class).EXT))
		{  
			$found_path = APPPATH."presenters/".strtolower($class).EXT;
		}
		elseif (file_exists(APPPATH.$module_dir."presenters/".strtolower($class).EXT))
		{
			$found_path = APPPATH.$module_dir."presenters/".strtolower($class).EXT;
		}

		if($found_path !== FALSE)
		{
			@include_once($found_path);
			return new $class($data);
		}


		// if (file_exists(APPPATH."presenters/".strtolower($class).EXT)) {  
		// 	@include_once(APPPATH."presenters/".strtolower($class).EXT);  
		// }

		// return new $class($data);
	}

}