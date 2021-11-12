<?php

namespace Taskforce\Logic;

abstract class Action
{
    protected $actionName = '';
    protected $actionAlias = '';

    protected function getName(): string {
        return $this->actionName;
    }

    protected function getAlias(): string {
        return $this->actionAlias;
    }

    abstract protected static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool;
}
