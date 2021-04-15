<?php
/**
 * function ini adalah membuat koneksi ke database
 */
function koneksi(){
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_database = "db_pendaftaranpraktikum";

    try {
        return new mysqli(db_host,db_user,db_password,db_database);
    } catch (Exception $e) {
        echo "terjadi kesalahan database";
    }

}

