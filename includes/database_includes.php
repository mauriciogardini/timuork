<?php
function database_connect($fn){
    try {
        $dbh = new PDO("sqlite:" . dirname(__DIR__) . "/db/database");
        $fn($dbh);
        $dbh = null;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
}

function database_query($query, $params = array()) {
    database_connect(function($dbh) use($query, $params, &$sth) {
        $sth = $dbh->prepare($query);
        $sth->execute($params);
    });
    return $sth;
}

function database_fetch($sth) {
    return $sth->fetch(PDO::FETCH_OBJ);
}

function database_iterate($sth, $fn){
    while($row = database_fetch($sth)) {
        $result = $fn($row);
        if($result === false)
        {
            break;
        }   
    }
}
