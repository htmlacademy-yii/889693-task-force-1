<?php

namespace Taskforce\Actions;

class ActionRespond extends Action
{
    protected string $actionName = 'Откликнуться';
    protected string $actionAlias = 'respond';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID != $currentUserID && empty($executorID);
    }
}
