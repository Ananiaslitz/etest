<?php

namespace Core\Application;

use Psr\Container\ContainerInterface;

class CommandQueryBus implements CommandQueryBusInterface
{
    private ContainerInterface $container;
    private array $mappings;

    public function __construct(ContainerInterface $container, array $mappings)
    {
        $this->container = $container;
        $this->mappings = $mappings;
    }

    public function dispatch($commandQuery)
    {
        $commandQueryClass = get_class($commandQuery);
        if (!isset($this->mappings[$commandQueryClass])) {
            throw new \Exception("Handler not found for {$commandQueryClass}");
        }

        $handlerClass = $this->mappings[$commandQueryClass];
        $handler = $this->container->get($handlerClass);

        return $handler->handle($commandQuery);
    }
}
