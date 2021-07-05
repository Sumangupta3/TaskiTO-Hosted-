<?php
    function getArray($email){
        $connent = mysqli_connect("remotemysql.com", "F8I3FAjxrT", "PI9fV18M1F", "F8I3FAjxrT");
        $query = "SELECT * FROM users WHERE `E-mail` = '$email'";
        $res = mysqli_query($connent, $query);

        while($row = mysqli_fetch_assoc($res)){
            $finalArray = array(
                "todoArray" => $row["todoArray"]
            );
        }

        mysqli_close($connent);
        return json_encode($finalArray);
    }

    echo getArray($_GET["email"]);
?>