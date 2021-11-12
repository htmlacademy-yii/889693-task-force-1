<?php


namespace Taskforce\Logic;


class AcceptAction extends Action
{
    protected $actionName = 'Принять';
    protected $actionAlias = 'accept';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID;
    }
}
