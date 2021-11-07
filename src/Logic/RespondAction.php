<?php


namespace Taskforce\Logic;


class RespondAction extends Action
{
    public function getName(): string
    {
        return 'Откликнуться';
    }

    public function getAlias(): string
    {
        return 'respond';
    }

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $executorID != $currentUserID && $customerID != $currentUserID;
    }
}
