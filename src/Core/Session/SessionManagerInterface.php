<?php

namespace Tigrino\Core\Session;

interface SessionManagerInterface
{
    public function createSession(int $userId): string;

    public function destroySession(string $sessionToken): bool;

    public function validateSession(string $sessionToken): bool;

    public function getUserFromSession(string $sessionToken): ?int;
}
