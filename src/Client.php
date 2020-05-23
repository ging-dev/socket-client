<?php

declare(strict_types=1);

namespace Gingdev\SocketIo;

use Curl\Curl;
use InvalidArgumentException;

class Client
{
    /** @var Curl */
    private $client;

    /** @var string */
    private $host;

    public function __construct()
    {
        // Initialize the variable
        $this->client = new Curl();
    }

    /**
     * Initialize client
     *
     * @param string $host
     * @param string $token
     * @return $this
     */
    public function initialize(string $host, string $token = 'gingdev')
    {
        if (! filter_var($host, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('The host name is not valid');
        }
        $this->host = rtrim($host, '/');
        $this->client->setHeader('Authorization', 'Bearer ' . $token);
        return $this;
    }

    /**
     * Emit data to socket server
     *
     * @param string $event
     * @param array $data
     * @return boolean
     */
    public function emit(string $event, array $data = []): bool
    {
        $args = [
            'event' => $event,
            'data'  => $data
        ];
        $response = $this->client->post($this->host . '/api', $args);
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
