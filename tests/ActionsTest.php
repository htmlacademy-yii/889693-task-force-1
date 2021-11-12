<?php

require_once '../vendor/autoload.php';

use Taskforce\Logic\Task;

$task = new Task();

echo '<pre>';
echo 'Текущий пользователь – исполнитель';
$task->customerID = 1;
$task->executorID = 2;
$task->currentUserID = 2;
echo '<br>';
var_dump($task->getAvailableActions('new'));
var_dump($task->getAvailableActions('proceeding'));

echo 'Текущий пользователь – заказчик';
$task->customerID = 1;
$task->executorID = 2;
$task->currentUserID = 1;
echo '<br>';
var_dump($task->getAvailableActions('new'));
var_dump($task->getAvailableActions('proceeding'));

echo 'Текущий пользователь – не заказчик, исполнитель не назначен';
$task->customerID = 1;
$task->executorID = null;
$task->currentUserID = 2;
echo '<br>';
var_dump($task->getAvailableActions('new'));
var_dump($task->getAvailableActions('proceeding'));

echo 'Текущий пользователь – не заказчик, не исполнитель, исполнитель назначен';
$task->customerID = 1;
$task->executorID = 3;
$task->currentUserID = 2;
echo '<br>';
var_dump($task->getAvailableActions('new'));
var_dump($task->getAvailableActions('proceeding'));
echo '</pre>';
