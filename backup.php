<?php
include "sys/db.php";
$result = $koneksi->query("SHOW DATABASES");
while ($row = $result->fetch(PDO::FETCH_NUM)) {
echo $row[0]."<br>";
}   
?>