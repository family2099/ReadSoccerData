<?php

ignore_user_abort();

header("Content-Type:text/html; charset=utf-8");
require_once "Db.php";

while (true) {
    $dbAct = new database;
    
    //先清除資料表
    $dbAct->deleteGame();  
    
    $url = 'http://www.228365365.com/sports.php';
    $file = file_get_contents ( $url , false );
    
    //抓取cookie
    preg_match_all( "/Set-Cookie:(.*?)rn/" , implode( "rn" ,  $http_response_header ),  $cookies );
    
    if (!empty($cookies[1])) {
        $cookiedata=substr($cookies[1][0], 0, 39) ;
     
    }
    
    //偽造來源的重要參數
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
                  "Cookie:".$cookiedata
      )
    );
    
    //創建並返回一個文本數據流並應用各種選項，
    //可用于fopen(),file_get_contents()等過程的超時設置、代理伺服器、請求方式、頭信息設置的特殊過程。
    $context = stream_context_create($opts);
    
    /*向指定地址發送http請求
    請求中包含附加的頭部信息*/
    $getUrlData = file_get_contents('http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=undefined', false, $context);
    
    //去掉html標籤和Running Ball字串
    $data = str_replace('Running Ball','',$getUrlData);
    $data = strip_tags($data);
    
    //切割資料
    $data = explode("parent.GameFT", $data);
    
    $gamenum=count($data);
    echo $gamenum;
    
    for ($i = 1; $i < $gamenum; $i++) {
            $result[$i] = explode(",", $data[$i]);
            
            for ($j = 0; $j < 3; $j++) {
              
                if ($j == 0) {
                    $league = $result[$i][2];
                    $time = $result[$i][1];
                    $gameName = $result[$i][5];
                    $win1 = $result[$i][15];
                    $allHandicap = $result[$i][9];
                    $allBigSmall = $result[$i][14];
                    $mono = $result[$i][18] . $result[$i][20];
                    $win2 = $result[$i][31];
                    $halfHandicap = $result[$i][25];
                    $halfBigSmall = $result[$i][30];
                    
                    $dbAct->insertGame($league, $time, $gameName, $win1, $allHandicap,
                        $allBigSmall, $mono, $win2, $halfHandicap, $halfBigSmall);
                }
                
                if ($j == 1) {
                    $league = $result[$i][2];
                    $time = $result[$i][1];
                    $gameName = $result[$i][6];
                    $win1 = $result[$i][16];
                    $allHandicap = $result[$i][10];
                    $allBigSmall = $result[$i][13];
                    $mono = $result[$i][19] . $result[$i][21];
                    $win2 = $result[$i][32];
                    $halfHandicap = $result[$i][26];
                    $halfBigSmall = $result[$i][29];
                    
                    $dbAct->insertGame($league, $time, $gameName, $win1, $allHandicap,
                        $allBigSmall, $mono, $win2, $halfHandicap, $halfBigSmall);
                }
            
                if ($j == 2) {
                    $league = $result[$i][2];
                    $time = $result[$i][1];
                    $gameName = "和";
                    $win1 = $result[$i][17];
                    $allHandicap = "";
                    $allBigSmall = "";
                    $mono = "";
                    $win2 = $result[$i][33];
                    $halfHandicap = "";
                    $halfBigSmall = "";
                    
                    $dbAct->insertGame($league, $time, $gameName, $win1, $allHandicap,
                        $allBigSmall, $mono, $win2, $halfHandicap, $halfBigSmall);
                }
            }
    }
    sleep(60);
}
?>

