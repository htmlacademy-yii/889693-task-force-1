<?php


namespace Taskforce\Logic;


class RespondAction extends Action
{
    protected $actionName = 'Откликнуться';
    protected $actionAlias = 'respond';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $executorID != $currentUserID && empty($executorID);
    }
}
