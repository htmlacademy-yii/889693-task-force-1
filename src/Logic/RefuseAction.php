<?php


namespace Taskforce\Logic;


class RefuseAction extends Action
{
    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getAlias(): string
    {
        return 'refuse';
    }

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $executorID === $currentUserID;
    }
}
