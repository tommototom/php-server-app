<?php

include 'http_req_handler.php';
$host = "127.0.0.1";
$port = 8080;
/*socket_write($connected_socket, "Available commands:
'{GET / HTTP/1.1 }' to post your request
'import 'path/to/your/script' ' to add some url pattern handlers
'dsc' to disconnect \n");*/

$socket = stream_socket_server("tcp://$host:$port");
echo "server is listening for requests at host $host and port $port\n";

while ($connected_socket = stream_socket_accept($socket, -1)) {
    if (($buf = fread($connected_socket, 2048)) === false) {
        break;
    } else {
        if (is_valid_request_header($buf)) {
            $response = handle($buf);
            fwrite($connected_socket, "$response");
        };
    };
    fclose($connected_socket);
}
socket_close($socket);
