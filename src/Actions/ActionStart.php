<?php

namespace Taskforce\Actions;

class ActionStart
{
    protected string $actionName = 'Принять';
    protected string $actionAlias = 'appoint';

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID && empty($executorID);
    }
}
