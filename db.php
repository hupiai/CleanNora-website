<?php

$conn = mysqli_connect(
    "localhost",
    "u345631720_cle",
    "Security@3232",
    "u345631720_cleannora"
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>