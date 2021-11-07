<?php

namespace Taskforce\Logic;

abstract class Action
{
    abstract protected function getName(): string;
    abstract protected function getAlias(): string;
    abstract protected static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool;
}
