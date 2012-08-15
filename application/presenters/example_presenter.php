<?php
/**
* 
*/
class Example_Presenter extends Presenter
{
	
	public function title($key = 0)
	{
		return (isset($this->data[$key]->title) ? $this->data[$key]->title : "No Title");
	}

	public function body($key = 0)
	{
		return (isset($this->data[$key]->body) ? $this->data[$key]->body : "TBC");
	}

	public function user_name($key =0)
	{
		if(!isset($this->data[$key]->user->name) || $this->data[$key]->user->name == '')
		{
			return 'NO USER!';
		}
		else
		{
			return $this->data[$key]->user->name;
		}
	}

}