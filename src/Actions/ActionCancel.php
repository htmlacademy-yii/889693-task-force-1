<?php

namespace Taskforce\Actions;

class ActionCancel extends Action
{
    protected string $actionName = 'Отменить';
    protected string $actionAlias = 'cancel';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID && empty($executorID);
    }
}
