<?php

require(__DIR__.'/../models/task.php');

class TaskController extends TaskRepository{

	public function index(){
		
		$tasks = $this->getTasks();
		require('templates/home.php');
	}
}

?>