<?php

namespace Taskforce\Tests;

use \PHPUnit\Framework\TestCase;
use Taskforce\Models\Task;
use Taskforce\Actions\ActionCancel;
use Taskforce\Actions\ActionRespond;
use Taskforce\Actions\ActionRefuse;
use Taskforce\Actions\ActionAccept;
use Taskforce\Actions\ActionChooseExecutor;

class TaskTest extends TestCase
{
    protected Task $task;

    protected function setUp(): void
    {
        $this->task = new Task();
        $this->task->customerID = 1;
    }

    /**
     * @dataProvider availableActionsCases
     * @param string $currentStatus
     * @param int $currentUserID
     * @param int|null $executorID
     * @param $expected
     */
    public function testGetAvailableActions(string $currentStatus, int $currentUserID, ?int $executorID, $expected): void
    {
        $this->task->executorID = $executorID;
        $this->task->currentUserID = $currentUserID;
        $this->assertEquals($expected, $this->task->getAvailableActions($currentStatus));
    }

    public function availableActionsCases(): array
    {
        $executorID = 2;

        return [
            ['new', 1, null, [new ActionCancel(), new ActionChooseExecutor()]], // новое, текущий пользователь – заказчик, исполнитель не назначен
            ['new', 2, null, new ActionRespond()], // новое, текущий пользователь – не заказчик, исполнитель не назначен
            ['new', 3, $executorID, null], // новое, текущий пользователь – не заказчик и не исполнитель, исполнитель назначен
            ['proceeding', 1, $executorID, new ActionAccept()], // в работе, текущий пользователь – заказчик, исполнитель назначен
            ['proceeding', 2, $executorID, new ActionRefuse()], // в работе, текущий пользователь – исполнитель
            ['proceeding', 3, $executorID, null], // в работе, текущий пользователь – не заказчик и не исполнитель, исполнитель назначен
        ];
    }
}
