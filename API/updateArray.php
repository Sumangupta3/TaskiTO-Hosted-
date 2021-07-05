<?php
    function getArray($email, $finalArray){
        $connent = mysqli_connect("remotemysql.com", "F8I3FAjxrT", "PI9fV18M1F", "F8I3FAjxrT");
        // $connent = mysqli_connect("localhost", "root", "", "to-do list");
        $query = "UPDATE `users` SET `todoArray` = '$finalArray' WHERE `users`.`E-mail` = '$email';";
        $res = mysqli_query($connent, $query);

        echo "Your Array is updated";
    }

    getArray($_GET["email"], $_GET["finalArray"]);
?>