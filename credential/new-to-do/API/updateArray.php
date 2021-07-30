<?php
    function getArray($email, $finalArray){
        $connent = mysqli_connect("localhost", "root", "", "to-do list");
        $query = "UPDATE `users` SET `todoArray` = '$finalArray' WHERE `users`.`E-mail` = '$email';";
        $res = mysqli_query($connent, $query);

        echo "Your Array is updated";
    }

    getArray($_GET["email"], $_GET["finalArray"]);
?>