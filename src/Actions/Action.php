<?php

namespace Taskforce\Actions;

abstract class Action
{
    protected string $actionName = '';
    protected string $actionAlias = '';

    public function getName(): string {
        return $this->actionName;
    }

    public function getAlias(): string {
        return $this->actionAlias;
    }

    abstract protected static function isAllowed(?int $customerID, ?int $executorID, ?int $currentUserID): bool;
}
