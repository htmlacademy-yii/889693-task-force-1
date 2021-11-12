<?php


namespace Taskforce\Logic;


class CancelAction extends Action
{
    protected $actionName = 'Отменить';
    protected $actionAlias = 'cancel';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID;
    }
}
