<?php

declare(strict_types=1);

namespace Gingdev\SocketIo;

use Gingdev\SocketIo\Client;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    public function testSendMessage(): void
    {
        $client = (new Client())
            ->initialize('ging-socket');
        $test = $client->emit('news', [
            'message' => 'Test message'
        ]);
        $client->close();

        $this->assertTrue($test);
    }
    public function testSendNamespace(): void
    {
        $client = (new Client())
            ->initialize('ging-socket')
            ->of('/test');
        $test = $client->emit('news', [
            'message' => 'Test message'
        ]);
        $client->close();

        $this->assertTrue($test);
    }
}
