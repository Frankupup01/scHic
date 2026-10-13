<?php
try {
    $db = new SQLite3('../db/scHic.db');

    echo " 数据库连接成功<br>";
    echo "SQLite3 版本: " . SQLite3::version()['versionString'] . "<br>";

    // 测试查询表是否存在
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "找到表： " . $row['name'] . "<br>";
    }

} catch (Exception $e) {
    echo " 数据库错误: " . $e->getMessage();
}