<?php

require_once '../vendor/autoload.php';

use Taskforce\Logic\Task;

$task = new Task();

$asserts = array(
    assert($task->getNextStatus('cancel') == Task::STATUS_CANCELLED, 'status after cancel'),
    assert($task->getNextStatus('accept') == Task::STATUS_COMPLETED, 'status after accept'),
    assert($task->getNextStatus('refuse') == Task::STATUS_FAILED, 'status after refuse'),
    assert($task->getAvailableActions('customer', 'new') == Task::ACTION_CANCEL, 'customer for new task'),
    assert($task->getAvailableActions('customer', 'proceeding') == Task::ACTION_ACCEPT, 'customer for proceeding task'),
    assert($task->getAvailableActions('executor', 'new') == Task::ACTION_RESPOND, 'executor for new task'),
    assert($task->getAvailableActions('executor', 'proceeding') == Task::ACTION_REFUSE, 'executor for proceeding task')
);

if (!in_array(false, $asserts)) {
    echo 'Everything works!';
}
