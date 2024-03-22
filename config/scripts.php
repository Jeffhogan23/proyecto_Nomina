<?php

function Emailexiste($email)
{
    require '../config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $sql1 = $con->prepare("SELECT count(email) FROM user WHERE email = ? LIMIT 1");
    $sql1->execute();
    if($sql1->fetchColumn() > 0)
    {
        $sqlemail = $con->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $sqlemail->execute();
        $row = $sqlemail->fetch(PDO::FETCH_ASSOC);
        return true;
    }
    else{
        return false;
    
    }
}
?>