<?php

namespace Taskforce;

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
    const ROLE_REQUESTER = 'requester';
    const ROLE_RESPONDER = 'responder';

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

    public $requesterID = null; // id заказчика
    public $responderID = null; // id исполнителя

    public function _construct(?int $requesterID, ?int $responderID)
    {
        $this->requesterID = $requesterID;
        $this->responderID = $responderID;
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
            self::ROLE_REQUESTER => [
                self::STATUS_NEW => self::ACTION_CANCEL,
                self::STATUS_PROCEEDING => self::ACTION_ACCEPT,
            ],
            self::ROLE_RESPONDER => [
                self::STATUS_NEW => self::ACTION_RESPOND,
                self::STATUS_PROCEEDING => self::ACTION_REFUSE,
            ]
        ];

        return $roleActionMap[$userRole][$currentStatus] ?? null;
    }
}
