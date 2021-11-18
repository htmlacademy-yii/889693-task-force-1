<?php

namespace Taskforce\Actions;

class ActionAccept extends Action
{
    protected string $actionName = 'Завершить';
    protected string $actionAlias = 'accept';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID;
    }
}
