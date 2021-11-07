<?php


namespace Taskforce\Logic;


class CancelAction extends Action
{
    public function getName(): string
    {
        return 'Отменить';
    }

    public function getAlias(): string
    {
        return 'cancel';
    }

    public static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool
    {
        return $customerID === $currentUserID;
    }
}
