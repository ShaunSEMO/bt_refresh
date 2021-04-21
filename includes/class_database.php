<?php

    class database{

        // VARIABLES
        private $db_connection;
        // METHODS
        // CONNECTING TO THE DATABASE
        private function connection(){

            // $mysqli = mysqli_connect("localhost", "qaazi09_demo", "#DI+qQ&PDzIi", "qaazi09_biztweak");
            $mysqli = mysqli_connect("127.0.0.1", "root", "", "biztweak");


            if (mysqli_connect_errno()) {
                echo mysqli_connect_error();
                header("location: error.php");
                exit();
            }
            else {
                $this->db_connection = $mysqli;
            }
        } 

        // DATABASE SELECT STATEMENT
        function query($query){
            $this->connection();

            $query_results = mysqli_query($this->db_connection, $query);
            if($query_results){

            }else{
                echo mysqli_error($this->db_connection);exit;
            }
            return $query_results;
        }

        // DATABASE FETCH ASSOC STATEMENT
        function fetch_assoc($results){
            $fetch_assoc_results = mysqli_fetch_assoc($results);
            return $fetch_assoc_results;
        }

        function fetch_object($results){
            $fetch_object_results = mysqli_fetch_object($results);
            return $fetch_object_results;
        }

        // DATABASE  FETCH ARRAY STATEMENT
        function fetch_array($results){
            $fetch_array_results = mysqli_fetch_array($results);
            return $fetch_array_results;
        }

        // DATABASE NUM OF ROWS STATEMENT
        function num_rows($results){
            $num_rows_results = mysqli_num_rows($results);
            return $num_rows_results;
        }

        // DATABASE AFFECTED ROWS STATEMENT 
        function affected_rows($results){
            $affected_rows_results = mysqli_affected_rows($results);
            return $affected_rows_results;
        }

        // DATABASE INSERT ID
        function insert_id($results){
            $insert_id = mysqli_insert_id($results);
            return $insert_id;
        }

        // DATABASE CLOSE STATEMENT
        function database_close(){
            $this->connection();
            mysqli_close($this->db_connection);
        }
    }

?>
