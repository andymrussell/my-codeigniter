<?php

/**
* 
*/
class Post extends ActiveRecord\Model
{
	static $belongs_to = array(
		array('user', 'class_name' => 'User')
	);

	static $validates_presence_of = array(
		array('title', 'body')
	);

	public function get_title()
	{
		return strtoupper($this->read_attribute('title'));
	}
}