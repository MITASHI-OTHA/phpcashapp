<?php
require 'connexion.php';
$photo = 'https://kazimo.ga/images/defaut-cah-app.png';
$password = '';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$email = $request->email;
$type = $request->type;
if(isset($request->password)) {
    $password = $request->password;
}
if(isset($request->photo)) {
    $photo = $request->photo;
}
$nom = $request->nom;
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
$password = SHA1($password);
$p = $db->query("SELECT *FROM users WHERE email = '$email'");
$k = $p->fetch(PDO::FETCH_OBJ);
$p = $p->rowcount();
if ($p<=0) {
    $q = $db->prepare("INSERT INTO users SET nom=:nom ,email =:email, passwords =:pass, dateinscription =:creates, confirm=:conf, photo = :photo, `insc_type` =:types");
    $q->bindValue(':email', $email);
    $q->bindValue(':pass', $password);
    $q->bindValue(':creates',  $mydat);
    $q->bindValue(':nom',  $nom);
    $q->bindValue(':types',  $type);
    $q->bindValue(':conf',  0);
    $q->bindValue(':photo',  $photo);
    $q->execute();
    $p = $db->query("SELECT  *FROM users WHERE email = '$email'");
    $k = $p->fetch(PDO::FETCH_OBJ);
    if($type == 'facebook' || $type == 'google') {
        echo json_encode(['response'=> "Vous êtes connecté!", "couleur"=>"success", "type"=> $type, 'data'=> $k]);
    } else {
       echo json_encode(['response'=> "Vous avez reçu un email à l'adresse $email", "couleur"=>"success", "type"=> $type]); 
    }
    
} else {
    if($type == 'facebook' || $type == 'google') {
        echo json_encode(['type'=> $type,'response'=> 'Vous êtes connecté', 'couleur'=> 'success', 'data'=> $k]);
    } else {
        echo json_encode(['type'=> $type,'response'=> 'Ce compte email existe deja', 'couleur'=> 'danger', 'tab'=> $k]);
    }
    
}

?>