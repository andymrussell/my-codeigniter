<?php
/**
* 
*/
class Example_Presenter extends Presenter
{
	
	public function title()
	{
		return (isset($this->example_presenter->title) ? $this->example_presenter->title : "No Title");
	}

	public function body()
	{
		return (isset($this->example_presenter->body) ? $this->example_presenter->body : "TBC");
	}


}