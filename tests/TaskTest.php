<?php

require_once '../vendor/autoload.php';

use Taskforce\Logic\Task;

$task = new Task();

$asserts = array(
    assert($task->getNextStatus('cancel') == Task::STATUS_CANCELLED, 'status after cancel'),
    assert($task->getNextStatus('accept') == Task::STATUS_COMPLETED, 'status after accept'),
    assert($task->getNextStatus('refuse') == Task::STATUS_FAILED, 'status after refuse'),
);

if (!in_array(false, $asserts)) {
    echo 'Everything works!';
}
