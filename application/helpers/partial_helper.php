<?php


function partial($name, $data, $loop = FALSE)
{
	$module = FALSE;
	if(strpos('/',$name) === FALSE)
	{
		//Check if HMVC rquest and set the correct file name
		if(strpos(get_instance()->router->directory, 'modules'))
		{
			$module = TRUE;
			$module_dir = get_instance()->router->directory;
			$module_dir = str_replace('controllers/', '', $module_dir);
			$module_dir = str_replace('../', '', $module_dir);
			
			$name = '/'.get_instance()->router->class .'/_'.$name;
		}
		else
		{
			$name = get_instance()->router->directory . get_instance()->router->class .'/_'.$name;
		}

	}
	else
	{
		$parts = explode('/',$name);
		$last = count($parts) - 1;

		$parts[$last] = (strpos('_', $parts[$last]) === 0) ? $parts[$last] : '_'.$parts[$last];
		$name = implode('/', $parts);
	}


	$output = "";
	if($loop && is_array($data))
	{
		foreach($data as $row)
		{
			if($module == TRUE)
            {
                get_instance()->load->_ci_view_path = APPPATH.$module_dir;
            }
			$output .= get_instance()->load->view($name, array('row' => $row), TRUE);

            if($module == TRUE)
            {
                unset(get_instance()->load->_ci_view_path);
            }
		}
	}
	else
	{
		if($module == TRUE)
        {
            get_instance()->load->_ci_view_path = APPPATH.$module_dir;
        }
		$output .= get_instance()->load->view($name, $data, TRUE);	

        if($module == TRUE)
        {
            unset(get_instance()->load->_ci_view_path);
        }		
	}
	return $output;
}