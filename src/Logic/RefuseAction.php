<?php


namespace Taskforce\Logic;


class RefuseAction extends Action
{
    protected $actionName = 'Отказаться';
    protected $actionAlias = 'refuse';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $executorID === $currentUserID;
    }
}
