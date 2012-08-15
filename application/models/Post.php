<?php

/**
* 
*/
class Post extends ActiveRecord\Model
{
	static $belongs_to = array(
		array('user', 'class_name' => 'User')
	);
}