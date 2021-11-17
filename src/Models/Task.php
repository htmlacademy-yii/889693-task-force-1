<?php

namespace Taskforce\Models;

use Taskforce\Actions\Action;
use Taskforce\Actions\ActionAccept;
use Taskforce\Actions\ActionCancel;
use Taskforce\Actions\ActionChooseExecutor;
use Taskforce\Actions\ActionRefuse;
use Taskforce\Actions\ActionRespond;

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

    public ?int $customerID = null;
    public ?int $executorID = null;
    public ?int $currentUserID = null;
    public ?string $currentStatus = '';

    public function _construct(?int $executorID, ?int $customerID, ?int $currentUserID, ?string $currentStatus)
    {
        $this->executorID = $executorID;
        $this->customerID = $customerID;
        $this->currentUserID = $currentUserID;
        $this->currentStatus = $currentStatus;
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
    public function getAvailableActions(string $currentStatus)
    {
        $action = null;
        $actions = null;

        switch ($currentStatus) {
            case self::STATUS_NEW:
                if (ActionRespond::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = ActionRespond::class;
                }
                if (ActionCancel::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $actionCancel = new ActionCancel();
                }
                if (ActionChooseExecutor::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $actionChooseExecutor = new ActionChooseExecutor();
                }
                $actions = isset($actionCancel) && isset($actionChooseExecutor) ? [$actionCancel, $actionChooseExecutor] : null;
                break;
            case self::STATUS_PROCEEDING:
                if (ActionAccept::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = ActionAccept::class;
                }
                if (ActionRefuse::isAllowed($this->customerID, $this->executorID, $this->currentUserID)) {
                    $action = ActionRefuse::class;
                }
        }

        if ($action) {
            return new $action();
        } else if ($actions) {
            return $actions;
        }
        return null;
    }
}
