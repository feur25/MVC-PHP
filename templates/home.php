
<html>

    <head>
        <link rel="stylesheet" href="style.css"/> 
    </head>

    <body>
        <p class="header_titre">Todolist</p>
		
		<form class="create-task-form" method="get" action="src/controllers/task/create">
			
			<input type="text" id="description" name="description"/>
			<input type="number" id="priority" name="priority" value="1" min="1" max="3">
			<button id="envoyer">Créer</button>
			
		</form>

        <a id="download-button" href="/download">Télécharger la liste des tâches</a>

        <div>

            <table>
                <?php
                    foreach ($tasks as $task) { 
                        ?>
                            <tr>
                                <div class="task">
                                    <td>
                                        <h1 class="<?= ($task->priority == 1 ? 'vert' : ($task->priority == 2 ? 'jaune' : 'rouge')); ?>" >
                                            <?= $task->description; ?>
                                        </h1>
                                    </td>
                                    <td>
                                        <p><?= $task->priority; ?></p>
                                    </td>
                                    <td>
                                        <a href="src/controllers/task/delete?id=<?= $task->id; ?>" class="rouge warning">X</a>
                                    </td>
                                </div>
                            </tr>
                        <?php
                    }
                ?>
            </table>

        </div>
    </body>


</html>

  
  