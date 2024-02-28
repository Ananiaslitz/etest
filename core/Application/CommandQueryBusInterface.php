<?php

namespace Core\Application;

interface CommandQueryBusInterface
{
    public function dispatch($commandQuery);
}
