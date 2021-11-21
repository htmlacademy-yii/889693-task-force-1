<?php

namespace Taskforce\Tests;

use \PHPUnit\Framework\TestCase;
use Taskforce\Models\Task;
use Taskforce\Actions\ActionCancel;
use Taskforce\Actions\ActionRespond;
use Taskforce\Actions\ActionRefuse;
use Taskforce\Actions\ActionAccept;
use Taskforce\Actions\ActionStart;
use Taskforce\Exceptions\ExceptionNotFound;
use Taskforce\Exceptions\ExceptionInvalidData;

/**
 * Class TaskTest
 * @package Taskforce\Tests
 */
class TaskTest extends TestCase
{
    protected Task $task;

    /**
     * @dataProvider availableActionsCases
     * @param string $currentStatus
     * @param int $currentUserID
     * @param int|null $executorID
     * @param $expected
     * @throws ExceptionNotFound
     */
    public function testGetAvailableActions(string $currentStatus, int $currentUserID, ?int $executorID, $expected): void
    {
        $task = new Task($executorID, 1, $currentUserID, $currentStatus);
        $this->assertEquals($expected, $task->getAvailableActions($currentStatus));
    }

    public function availableActionsCases(): array
    {
        $executorID = 2;

        return [
            ['new', 1, null, [new ActionCancel(), new ActionStart()]], // новое, текущий пользователь – заказчик, исполнитель не назначен
            ['new', 2, null, [new ActionRespond()]], // новое, текущий пользователь – не заказчик, исполнитель не назначен
            ['proceeding', 1, $executorID, [new ActionAccept()]], // в работе, текущий пользователь – заказчик, исполнитель назначен
            ['proceeding', 2, $executorID, [new ActionRefuse()]], // в работе, текущий пользователь – исполнитель
        ];
    }

    public function testThrowInvalidStatus(): void
    {
        $task = new Task(1, 2, 2);

        $this->expectException(ExceptionInvalidData::class);
        $task->getAvailableActions('invalid');
    }

    /**
     * @dataProvider actionsNotFoundCases
     * @param string $currentStatus
     * @param int $currentUserID
     * @param int|null $executorID
     * @throws ExceptionNotFound
     * @throws ExceptionInvalidData
     */
    public function testThrowActionsNotFound(string $currentStatus, int $currentUserID, ?int $executorID): void
    {
        $task = new Task($executorID, 1, $currentUserID, $currentStatus);

        $this->expectException(ExceptionNotFound::class);
        $task->getAvailableActions($currentStatus);
    }

    public function actionsNotFoundCases(): array
    {
        $executorID = 2;

        return [
            ['new', 3, $executorID], // новое, текущий пользователь – не заказчик и не исполнитель, исполнитель назначен
            ['proceeding', 3, $executorID], // в работе, текущий пользователь – не заказчик и не исполнитель, исполнитель назначен
            ['cancelled', 1, $executorID], // отмененное задание
            ['completed', 1, $executorID], // выполненное задание
            ['failed', 1, $executorID], // проваленное задание
        ];
    }

    public function testThrowInvalidAction(): void
    {
        $task = new Task(1, 2, 1);

        $this->expectException(ExceptionInvalidData::class);
        $task->getNextStatus('invalid');
    }
}
