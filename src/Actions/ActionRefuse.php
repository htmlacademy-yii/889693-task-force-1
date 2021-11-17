<?php

namespace Taskforce\Actions;

class ActionRefuse extends Action
{
    protected string $actionName = 'Отказаться';
    protected string $actionAlias = 'refuse';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $executorID === $currentUserID;
    }
}
