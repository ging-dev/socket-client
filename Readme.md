## Simple Socket Client
![PHP-CI](https://github.com/ging-dev/socket-client/workflows/PHP-CI/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ging-dev/socket-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ging-dev/socket-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ging-dev/socket-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ging-dev/socket-client/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/ging-dev/socket-client/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ging-dev/socket-client/build-status/master)
## Require:
PHP 7.2+

**This package only works with [Socket server](https://github.com/ging-dev/socket-server)**

## Install : 
	composer require ging-dev/socket-client
## Backend:
```php
<?php
use Gingdev\SocketIo\Client;
require 'vendor/autoload.php';
$client = new Client();

// Demo: yourapp.herokuapp.com
$client->initialize('yourapp');
$client->emit('news', [
	'message' => 'New message'
]);

// Emit to namespace
$client->of('/namespace')
	->emit('test', [
		'message' => 'New message'
	]);
$client->close();

// Advanced usage
$client->initialize('yourapp', [
	'platform' => Client::HEROKU_PLATFORM, // or Client::GLITCH_PLATFORM
	'token'	=> 'access token'
]);

$client->close();
```
## Javascript:
```js
<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>
    var socket = io('https://yourapp.herokuapp.com');
    socket.on('news', (data) => alert(data.message));
</script>
```
