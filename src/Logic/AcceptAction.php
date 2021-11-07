<?php


namespace Taskforce\Logic;


class AcceptAction extends Action
{
    public function getName(): string
    {
        return 'Принять';
    }

    public function getAlias(): string
    {
        return 'accept';
    }

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID;
    }
}
