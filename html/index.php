<?php

$host = "mysqlserver";
$user = "root";
$pass = "pass123";
$db = "test_database";

print '<pre>';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    print "Connected successfully.\n";
} catch(PDOException $e) {
    print "Connection failed: " . $e->getMessage();
    die();
}

try {
    $sql ="CREATE TABLE IF NOT EXISTS visit_log (
     id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
     ip_address VARCHAR( 50 ) NOT NULL, 
     visit_datetime datetime NOT NULL);";
    $conn->exec($sql);

    print "Created visit_table (if it not exist).\n";
} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
    die();
}

try {
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date("Y-m-d H:i:s", time());

    $sql ="INSERT INTO visit_log 
    (ip_address, visit_datetime)
    VALUES 
    ('$ip', '$time');" ;

    $conn->exec($sql);

    print "New value has been put to visit_table.\n";
} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
    die();
}

try {
    $sql ="SELECT * FROM visit_log;";
    $result = $conn->query($sql);


    print "All values from visit_table:\n";
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        print $row['id'] . ' ' . $row['ip_address'] . ' ' . $row['visit_datetime'] . PHP_EOL;
    }
} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
    die();
}
