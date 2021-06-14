<?php

require_once '../classes/Task.php';

use Taskforce\Task;

$task = new Task();

$asserts = array(
    assert($task->getNextStatus('cancel') == Task::STATUS_CANCELLED, 'status after cancel'),
    assert($task->getNextStatus('accept') == Task::STATUS_COMPLETED, 'status after accept'),
    assert($task->getNextStatus('respond') == Task::STATUS_PROCEEDING, 'status after respond'),
    assert($task->getNextStatus('refuse') == Task::STATUS_FAILED, 'status after refuse'),
    assert($task->getAvailableActions('requester', 'new') == Task::ACTION_CANCEL, 'responder for new task'),
    assert($task->getAvailableActions('requester', 'proceeding') == Task::ACTION_ACCEPT, 'requester for proceeding task'),
    assert($task->getAvailableActions('responder', 'new') == Task::ACTION_RESPOND, 'responder for new task'),
    assert($task->getAvailableActions('responder', 'proceeding') == Task::ACTION_REFUSE, 'responder for proceeding task')
);

if (!in_array(false, $asserts)) {
    echo 'Everything works!';
}
