<?php
/**
* 
*/
class Orm extends ActiveRecord\Model
{
	
	/**
	 * Override default Active Record date to use timestamp instead 
	 * Updates a model's timestamps.
	 */
	public function set_timestamps()
	{
		$now = time();

		if (isset($this->updated_at))
			$this->updated_at = $now;

		if (isset($this->created_at) && $this->is_new_record())
			$this->created_at = $now;
	}

}