<?php


namespace App;

use \PDO;

class Connection {

    /*public static function getPDO(): PDO
    {
        return new PDO('mysql:dbname=appli_massoutre;host=127.0.0.1', 'root', 'M@ssoutre2013', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
        ]);
    }
*/
public static function getPDO(): PDO

// {
//         return new PDO('mysql:dbname=massoutre;host=127.0.0.1', 'root', 'M@ssoutre2013', [
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
//         ]);
//     }
{

    $user = 'root';
    $password = 'root';
    
        return new PDO('mysql:host=localhost;dbname=portail_massoutre', $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
        ]);
    }


}
