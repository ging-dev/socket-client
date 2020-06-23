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
            ->initialize('https://ging-socket.herokuapp.com');
        $test = $client->emit('news', [
            'message' => 'Test message'
        ]);

        $this->assertTrue($test);
        $client->close();

        $client->initialize('https://ging-socket.herokuapp.com', 'error');
        $test = $client->emit('news', [
            'message' => 'Test message'
        ]);

        $this->assertFalse($test);
        $client->close();
    }
    public function testSendNamespace(): void
    {
        $client = (new Client())
            ->initialize('https://ging-socket.herokuapp.com')
            ->of('/test');
        $test = $client->emit('news', [
            'message' => 'Test message'
        ]);
        $client->close();

        $this->assertTrue($test);
    }
}
