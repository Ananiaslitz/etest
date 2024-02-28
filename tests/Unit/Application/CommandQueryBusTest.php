<?php

namespace Application;

use Core\Application\CommandQueryBus;
use Psr\Container\ContainerInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CommandQueryBusTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testDispatchSuccessfully()
    {
        $container = Mockery::mock(ContainerInterface::class);

        $mappings = [
            SampleCommand::class => SampleCommandHandler::class,
        ];

        $handler = Mockery::mock(SampleCommandHandler::class);
        $handler->shouldReceive('handle')->once()->withArgs(function ($command) {
            return $command instanceof SampleCommand;
        })->andReturn('handled');

        $container->shouldReceive('get')->once()->with(SampleCommandHandler::class)->andReturn($handler);

        $bus = new CommandQueryBus($container, $mappings);

        $command = new SampleCommand();

        $result = $bus->dispatch($command);

        $this->assertEquals('handled', $result);
    }

    public function testDispatchThrowsExceptionForUnmappedCommand()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches("/Handler not found for .*/");

        $container = Mockery::mock(ContainerInterface::class);
        $bus = new CommandQueryBus($container, []);

        $command = new SampleCommand();
        $bus->dispatch($command);
    }
}

// Classes fictícias para o teste
class SampleCommand {}
class SampleCommandHandler
{
    public function handle($command)
    {
        return 'handled';
    }
}
