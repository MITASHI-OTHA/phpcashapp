<?php
require 'connexion.php';
$req = $db->query("SELECT *FROM paris, users WHERE `statu` = 'en cours' OR `statu` IS NULL AND `paris`.`id_auteur` = `users`.`id`");
$count = $req->rowcount($req);
$paris =[

];
$tab = [];
$participants = [];
if($count>=1) {
    while($i = $req->fetch()) {
        $id = $i['id_p'];
        $j = $db->query("SELECT *FROM users, participants WHERE `participants`.`id_paris` = $id AND `users`.`id` = `participants`.`id_part`");
        $p = $j->rowcount($j);
        if($p >= 1) {
            while($b = $j->fetchAll()) {
                $q = array_merge($i, ["participants"=> $b]);
                $paris = array_push($tab, $q);
            }
        }else {
            $q = array_merge($i, ["participants"=>[]]);
            $paris = array_push($tab, $q);
        }
        
        
       
     }
     echo json_encode($tab);
    }

?>