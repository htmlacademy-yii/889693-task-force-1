<?php

namespace Taskforce\Logic;

use Taskforce\Logic\Action;

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
    const ROLE_CUSTOMER = 'customer';
    const ROLE_EXECUTOR = 'executor';

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

    public $customerID = null; // id заказчика
    public $executorID = null; // id исполнителя
    public $currentUserID = null; // id текущего пользователя

    public function _construct(?int $executorID, ?int $customerID, ?int $currentUserID)
    {
        $this->executorID = $executorID;
        $this->customerID = $customerID;
        $this->currentUserID = $currentUserID;
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

    // получение объекта класса доступного действия для указанного статуса и роли
    public function getAvailableActions(string $currentStatus): ?Action
    {
        $action = Action::class;

        switch ($currentStatus) {
            case self::STATUS_NEW:
                if (RespondAction::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = RespondAction::class;
                }
                if (CancelAction::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = CancelAction::class;
                }
                break;
            case self::STATUS_PROCEEDING:
                if (AcceptAction::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = AcceptAction::class;
                }
                if (RefuseAction::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = RefuseAction::class;
                }
        }

        return new $action() ?? null;
    }
}
