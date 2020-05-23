## Simple Socket Client

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
$client->initialize('http://yourapp.herokuapp.com');
$client->emit('news', [
	'message' => 'New message'
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
