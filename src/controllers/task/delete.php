<?php

require(__DIR__.'/../taskController.php');

if (isset($_GET)) {
    if ($_GET['id'] !== '') {
        $taskController = new TaskController();
        $taskController->deleteTask($_GET['id']);
    }
}
header('Location: /');

?>