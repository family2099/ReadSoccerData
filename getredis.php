<?php

header("Content-Type:text/html; charset=utf-8");

$redis = new redis();
$result = $redis->connect('127.0.0.1', 6379);
$result = $redis->get('test');
print_r($result);
// $redis->delete('test');