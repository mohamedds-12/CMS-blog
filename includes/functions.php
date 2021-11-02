<?php

$connection = mysqli_connect('localhost', 'root', '', 'cms_db');
if (!$connection) {
    die("DATABASE CONNECTION FAILED " . mysqli_connect_error($connection));
}


function searchAllData() {

    global $connection;
    global $searchAllData;
    global $search;

    // Searching database
    $query = "SELECT * FROM posts 
    WHERE post_author like '%$search%'
    or post_title like '%$search%'
    or post_content like '%$search%'
    or post_date like '%$search%'
    ";

    $searchAllData = mysqli_query($connection, $query);

    // Checking query
    if (!$searchAllData) {
        die("SEARCH QUERY FAILED " . mysqli_error($connection));
    }
}


function deleteData($table, $where_col, $where_val) {

    global $connection;

    // Deleting data from database
    $query = "DELETE FROM $table WHERE $where_col = $where_val";
    $deleteData = mysqli_query($connection, $query);

    // Checking query
    if (!$deleteData) {
        die("DELETE QUERY FAILED " . mysqli_error($connection));
    }
}


function selectData($table, $clause) {

    global $connection;
    global $selectData;

    // Getting data from database
    $query = "SELECT * FROM $table $clause";
    $selectData = mysqli_query($connection, $query);

    // Checking query
    if (!$selectData) {
        die("SELECT ALL DATA QUERY FAILED! " . mysqli_error($connection));
    }
}



// function selectDataWhere($table, $where_col, $where_val, $order_col, $order_val) {

//     global $connection;
//     global $selectDataWhere;

//     // Inserting data to database
//     $query = "SELECT * FROM $table WHERE $where_col = $where_val ORDER BY $order_col $order_val";
//     $selectDataWhere = mysqli_query($connection, $query);

//     // Checking query
//     if (!$selectDataWhere) {
//         die("SELECT QUERY FAILED " . mysqli_error($connection));
//     }
// }


function insertOneData($table, $column, $value) {

    global $connection;

    // Inserting data to database
    $query = "INSERT INTO $table SET $column = '$value'";
    $insertOneData = mysqli_query($connection, $query);

    // Checking query
    if (!$insertOneData) {
        die("INSERT QUERY FAILED " . mysqli_error($connection));
    }
}


function insertMultiData($table, $columns, $values) {

    global $connection;
    
    // Inserting data to database
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $insertMultiData = mysqli_query($connection, $query);

    // Checking query
    if (!$insertMultiData) {
        die("INSERT QUERY FAILED " . mysqli_error($connection));
    }
}


function updateOneData($table, $clause) {

    global $connection;

    // Inserting data to database
    $query = "UPDATE $table SET $clause";
    $updateOneData = mysqli_query($connection, $query);

    // Checking query
    if (!$updateOneData) {
        die("UPDATE ONE DATA QUERY FAILED " . mysqli_error($connection));
    }
}


function updateMultiData($table, $columns, $values) {
    global $connection;

    // Replacing data in database
    $query = "REPLACE INTO $table ($columns) VALUES($values)";

    $updateMultiData = mysqli_query($connection, $query);

    // Checking query
    if (!$updateMultiData) {
        die("UPDATE QUERY FAILED " . mysqli_error($connection));
    }
}
