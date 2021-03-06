<?php

namespace Mvc\Controllers;

use Mvc\Models\Task;

use Mvc\Core\Controller;

use Mvc\Models\TaskRepository;

class TasksController extends Controller
{

    private $TaskRepository;

    public function __construct(){
        $this->TaskRepository = new TaskRepository();
    }

    function index()
    {
        $newTask = new Task();
        $d['tasks'] = $this->TaskRepository->getAll($newTask);
        $this->set($d);
        $this->render("index");
    }

    function create()
    {
        if (isset($_POST["title"]))
        {
            $task= new Task();
            $task->setTitle($_POST["title"]);
            $task->setDescription($_POST["description"]);
            $task->setCreatedAt($_POST["created_at"]);

            if ($this->TaskRepository->add($task))
            {
                header("Location: " . WEBROOT . "tasks/index");
            }
        }

        $this->render("create");
    }

    function edit($id)
    {
        $task= new Task();
        $task->setId($id);

        if (isset($_POST["title"]))
        {
            $task->setTitle($_POST["title"]);
            $task->setDescription($_POST["description"]);
            $task->setUpdatedAt($_POST["updated_at"]);

            if ($this->TaskRepository->update($task))
            {
                header("Location: " . WEBROOT . "tasks/index");
            }
        }

        $d["task"] = $this->TaskRepository->showTask($id);

        $this->set($d);
        $this->render("edit");
    }

    function delete($id)
    {
        $task = new Task();
        $task->setId($id);
        if ($this->TaskRepository->delete($task))
        {
            header("Location: " . WEBROOT . "tasks/index");
        }
    }
}
