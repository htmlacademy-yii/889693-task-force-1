<?php

require_once '../vendor/autoload.php';

use Taskforce\Logic\Task;

$task = new Task();

$asserts = array(
    assert($task->getAvailableActions('new')),
    assert($task->getAvailableActions('proceeding')),
);

if (!in_array(false, $asserts)) {
    echo 'Everything works!';
}
