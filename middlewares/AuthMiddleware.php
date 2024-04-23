<?php

declare(strict_types=1);

namespace PHPStrike\middlewares;

use celionatti\Bolt\Bolt;
use celionatti\Bolt\Middleware\Middleware;


class AuthMiddleware extends Middleware
{
    protected array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute(array $actions = [])
    {
        if (empty($this->actions) || in_array(Bolt::$bolt->controller->action, $this->actions)) {
            bolt_die("Auth Middleware");
        }
    }
}
