<?php
namespace myorg;

require_once __DIR__ . '/vendor/autoload.php';

use myorg\general\User;
use myorg\general\Task;
//use myorg\actions\Action;
use myorg\actions\AddAction;

$sustomer = new User(false);
$task = new Task(1);
//$action = new Action();
$addAction = new AddAction();


//var_dump($task->customerId);
//var_dump($task->status);
//var_dump($task->getStatuses());
//var_dump($task->getStatuses());
//var_dump($sustomer->role);
//var_dump($task->status);
var_dump($task->getNextActions($sustomer));
//var_dump($task->getNextStatus('action_cancel'));

//var_dump($task->getActions());

//var_dump($action);

