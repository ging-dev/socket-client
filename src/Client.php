<?php

declare(strict_types=1);

namespace Gingdev\SocketIo;

use Curl\Curl;
use InvalidArgumentException;

class Client
{
    /** @var Curl $client */
    private $client;

    /** @var string $host */
    private $host;
    
    /** @var string $namespace */
    private $namespace;

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
        $this->namespace = '/';
        $this->client->setHeader('Authorization', 'Bearer ' . $token);
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
    public function emit(string $event, array $data = []): bool
    {
        $args = [
            'namespace'    => $this->namespace,
            'event'        => $event,
            'data'         => $data
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
