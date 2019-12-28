<?php
    try {
        $db = new PDO('mysql: host=localhost;dbname=cashapp', "root", "");
            } catch(Exception $e) {
        die('impossible de se connecter à la base de données'.$e->getMessage());
    }
?>