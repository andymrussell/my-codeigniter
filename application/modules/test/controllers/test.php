<?php
/**
* 
*/
class Test extends MY_Controller
{
	
	function index()
	{
		$this->data['title'] = 'testingmore';
		$data->{'names'} = 'Andy';
		$data->{'email'} = 'email!!';
		$this->data['temp'] = $this->load->presenter('Test_Presenter',$data);
	}
}