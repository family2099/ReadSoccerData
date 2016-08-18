<?php
ignore_user_abort();

header("Content-Type:text/html; charset=utf-8");
require_once "Db.php";
while (true) {
    
    $dbAct = new database;
    
    $gameArr=$dbAct->getGame();
    $redis = new redis();
    $result = $redis->connect('127.0.0.1', 6379);
    $result = $redis->set('test', json_encode($gameArr));

    sleep(60);
}
