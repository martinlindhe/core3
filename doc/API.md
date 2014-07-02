# API

Core3 has a few internal api:s available,
such as "ping".
They reside in core3/api and is a good
starting point when creating your own API:s

All API:s are implemented as views


The API request routing is simple;

when a client requests /api/name,
first we look into app/api directory for name.php,
if found we serve that view.
If not found, we look for core3/api/name.php

This allows for application override of default api:s



## Available variables in API views

$param              indexed array containing the request GET parameters
$requestMethod      method used for the request (GET, PUT, POST, DELETE)



## TODO

TODO: how to pass in POST / PUT data?
