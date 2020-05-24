<?php

declare(strict_types=1);

namespace Gingdev\SocketIo;

use Curl\Curl as Socket;

class Client
{
    const HEROKU_PLATFORM = 'herokuapp.com';

    const GLITCH_PLATFORM = 'glitch.me';

    /** @var Socket $client */
    private $client;

    /** @var string $host */
    private $host;

    /** @var string $namespace */
    private $namespace;

    public function __construct()
    {
        // Initialize the variable
        $this->client = new Socket();
    }

    /**
     * Initialize client
     *
     * @param string $name
     * @param array $opts
     * @return $this
     */
    public function initialize(
        string $name,
        array $opts = [
            'platform' => Client::HEROKU_PLATFORM,
            'token'    => 'gingdev'
        ]
    ) {
        $this->host = sprintf("https://%s.%s", $name, $opts['platform']);
        $this->client->setHeader('Authorization', 'Bearer ' . $opts['token']);
        $this->namespace = '/';
        return $this;
    }

    /**
     * Change namespace
     *
     * @param string $namespace
     * @return $this
     */
    public function of(string $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Emit data to socket server
     *
     * @param string $event
     * @param array $data
     * @return boolean
     */
    public function emit(string $event, array $data): bool
    {
        $args = [
            'namespace' => $this->namespace,
            'event'     => $event,
            'data'      => $data
        ];
        $response = $this->client->post($this->host, $args);
        if ($response->error) {
            return false;
        }
        return true;
    }

    /**
     * Close client
     *
     * @return $this
     */
    public function close()
    {
        $this->client->reset();
        return $this;
    }
}
