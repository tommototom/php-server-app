<?php


function is_valid_request_header($request) {
//    $request="GET /index.html HTTP/1.1";
    $methods="GET|HEAD|TRACE|OPTIONS";
    $pattern="/^(".$methods.")\s+(\S+)\s+(HTTP)/";

    if (1 === preg_match($pattern, $request)) {
        return true;
    } else {
        return false;
    }
}


function method($request) {
    return substr($request, 0, strpos($request, ' '));
}

function url($request) {
    $request = substr($request, 0, strpos($request, " HTTP/"));
    return substr($request, strpos($request, ' ') + 1);
}


function wrap_html_to_response($html, $status = 200) {
    //todo get message by status code
    return "HTTP/1.1 $status OK
Server: nginx
Date: Sat, 08 Mar 2014 22:29:53 GMT
Content-Type: text/html
Connection: keep-alive
Keep-Alive: timeout=25
Location: http://habrahabr.ru/users/alizar/

" . $html;
}