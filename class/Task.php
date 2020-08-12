<?php

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

    public $statuses = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELLED => 'Отменённое',
        self::STATUS_PROCEEDING => 'В работе',
        self::STATUS_COMPLETED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено'
    ];

    public $actions = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_ACCEPT => 'Выполнено',
        self::ACTION_REFUSE => 'Отказаться',
    ];

    public $curStatus = ''; // название текущего статуса
    public $requesterId = null; // id заказчика
    public $acceptorId = null; // id исполнителя

    public function _construct(string $curStatus, int $requesterId, int $acceptorId)
    {
        $this->curStatus = $curStatus;
        $this->acceptorId = $acceptorId;
        $this->requesterId = $requesterId;
    }

    // получение текущего статуса
    public function getCurStatus()
    {

    }

    // получение доступных действий для указанного статуса
    public function getAvailableActions()
    {

    }

    // получение статуса после выполнения действия
    public function getNewStatus()
    {

    }
}
