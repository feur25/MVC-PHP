<?php

class Task {
    public int $id;
    public string $description;
    public int $priority;
    
    public function __construct(int $id, string $description, int $priority) {
        $this->id = $id;
        $this->description = $description;
        $this->priority = $priority;
    }
}

class TaskRepository {

    public PDO $connection;

    public function __construct() {
        $this->connection = new PDO("mysql:dbname=todolist;host=localhost", "root", "");
    }


    private function logTask(string $entry){
        $path = __DIR__ . '/../../log.txt';
        if (file_exists($path)) {
            $fp = fopen($path, "a");
            fwrite($fp, $entry);
        } else {
            file_put_contents($path, file_get_contents($path) . $entry);
        }
    }

    public function createTask(string $description, int $priority) {

        // log
        $this->logTask("ADD " . $this->displayTask($description, $priority));

        
        // check in db if task already exists
        $statement = $this->connection->prepare("SELECT * FROM tasks WHERE description = :description");
        $statement->execute(['description' => $description]);

        if ( $statement->rowCount() > 0 ) {
            return;
        }
            
        $statement = $this->connection->prepare("INSERT INTO tasks (description, priority) VALUES (:description, :priority)");
        $statement->execute([
            'description' => $description,
            'priority' => $priority
        ]);
    }

    public function deleteTask(int $id) {
        // check in db if task already exists
        $statement = $this->connection->prepare("SELECT * FROM tasks WHERE id = :id");
        $statement->execute(['id' => $id]);

        $task = $statement->fetch();
        
        if ($task) {

            $this->logTask("DEL " . $this->displayTask($task['description'], $task['priority']));
    
            $statement = $this->connection->prepare("DELETE FROM tasks WHERE id = :id");
            $statement->execute([
                'id' => $id
            ]);
        }

    }

    public function getTasks() : array {
        $statement = $this->connection->prepare("SELECT * FROM tasks ORDER BY priority DESC");
        $statement->execute();

        $tasks = $statement->fetchAll();

        $taskList = [];

        foreach ($tasks as $task) {
            $taskList[] = new Task($task['id'], $task['description'], $task['priority']);
        }

        return $taskList;
    }

    public function displayTask(string $description, int $priority) : string {
        return "[" . date("d/m/Y H:i:s") . "] " . $_SERVER['REMOTE_ADDR'] . " : " . $description . " - " . $priority . PHP_EOL;
    }
}