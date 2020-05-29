<?php

declare(strict_types=1);

namespace Gingdev\SocketIo;

use Curl\Curl as Socket;
use InvalidArgumentException;

class Client
{
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
     * @param string $token
     * @return $this
     */
    public function initialize(string $host, string $token = 'gingdev')
    {
        if (filter_var($host, FILTER_VALIDATE_URL)) {
            $this->host = $host;
            $this->client->setHeader('Authorization', 'Bearer ' . $token);
            $this->namespace = '/';
        } else {
            throw new InvalidArgumentException('Error: Invalid URL');
        }
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
        $this->host = null;
        $this->client->reset();
        return $this;
    }
}
