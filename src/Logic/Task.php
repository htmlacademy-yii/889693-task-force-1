<?php

namespace Taskforce\Logic;

class Task
{
    // возможные статусы задания
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PROCEEDING = 'proceeding';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    // возможные действия с заданием
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_ACCEPT = 'accept';
    const ACTION_REFUSE = 'refuse';

    // роли пользователей
    const ROLE_EMPLOYER = 'employer';
    const ROLE_EMPLOYEE = 'employee';

    // карта статусов
    private $statusesMap = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELLED => 'Отменённое',
        self::STATUS_PROCEEDING => 'В работе',
        self::STATUS_COMPLETED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено'
    ];

    // карта действий
    private $actionsMap = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_ACCEPT => 'Выполнено',
        self::ACTION_REFUSE => 'Отказаться',
    ];

    public $employerID = null; // id заказчика
    public $employeeID = null; // id исполнителя

    public function _construct(?int $employerID, ?int $employeeID)
    {
        $this->employerID = $employerID;
        $this->employeeID = $employeeID;
    }

    // получение карты статусов
    public function getStatusesMap(): array
    {
        return $this->statusesMap;
    }

    // получение карты действий
    public function getActionsMap(): array
    {
        return $this->actionsMap;
    }

    // получения статуса, в который задание перейдёт после выполнения указанного действия
    public function getNextStatus(string $action): ?string
    {
        $actionStatusMap = [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_ACCEPT => self::STATUS_COMPLETED,
            self::ACTION_REFUSE => self::STATUS_FAILED
        ];

        return $actionStatusMap[$action] ?? null;
    }

    // получение доступных действий для указанного статуса
    public function getAvailableActions(string $userRole, string $currentStatus): ?string
    {
        $roleActionMap = [
            self::ROLE_EMPLOYER => [
                self::STATUS_NEW => self::ACTION_CANCEL,
                self::STATUS_PROCEEDING => self::ACTION_ACCEPT,
            ],
            self::ROLE_EMPLOYEE => [
                self::STATUS_NEW => self::ACTION_RESPOND,
                self::STATUS_PROCEEDING => self::ACTION_REFUSE,
            ]
        ];

        return $roleActionMap[$userRole][$currentStatus] ?? null;
    }
}
