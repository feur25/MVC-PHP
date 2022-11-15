<?php

require_once('./src/controllers/taskController.php');


$taskController = new TaskController();
$taskController->index();


?>