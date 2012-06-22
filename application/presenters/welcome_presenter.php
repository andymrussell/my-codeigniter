<?php
/**
* 
*/
class Welcome_Presenter extends Presenter
{
	
	public function name()
	{
		return (isset($this->welcome_presenter->name) ? $this->welcome_presenter->name : "Un Named");
	}

	public function email()
	{
		return $this->welcome_presenter['email'] ? : "N/A";
	}

}