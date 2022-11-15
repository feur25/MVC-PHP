<?php

require(__DIR__.'/src/controllers/taskController.php');


$tmpName = tempnam(sys_get_temp_dir(), 'tasks');
$file = fopen($tmpName, 'w');

$tasks = (new TaskController)->getTasks();
foreach ($tasks as $task) {
    fwrite($file, "Nom de la tâche : " . $task->description . " - " . "Priorité de la tâche : " . $task->priority . PHP_EOL);
}

fclose($file);

header('Content-Description: File Transfer');
header('Content-Type: text/txt');
header('Content-Disposition: attachment; filename=tasks.txt');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpName));

ob_clean();
flush();

readfile($tmpName);
unlink($tmpName);

header('Location: /');

?>