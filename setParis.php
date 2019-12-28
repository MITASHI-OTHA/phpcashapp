<?php
require 'connexion.php';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
if(empty($request)) exit();
$titre = $request->titre;
$auteur = $request->auteur;
$debut = $request->debut;
$id = $request->id;
$fin = $request->fin;
$prix = $request->prix;
$status = $request->status;
$descriptions = $request->description;
//createdAt
    try {
        $fuseau="Europe/Paris";
        $cal=date('Y-m-d H:i:s');
        $dates = new DateTimeZone($fuseau);
        $date = new DateTime($cal, $dates);//utilisera le bon fuseau horaire
        $date->setTimezone($dates);
        $mydat=$date->format('Y-m-d H:i:s');
    } catch(Exception $e){
            exit($e->getMessage());
    }
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
$datation=$date=strftime("%A %d %B").' à '.date("H:i");
//fin
    $prix = intVal($prix);
   $db->query("INSERT INTO paris SET titre ='$titre', auteur ='$auteur', datecreattion ='$mydat', debut ='$debut', fin ='$fin',  statu ='$status', prix = $prix, descriptions ='$descriptions','id_auteur'=$id");
  
    echo json_encode(['response'=> 'ok']);
?>