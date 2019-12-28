<?php
require 'connexion.php';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
if(isset($request->Email)) {
    $email = $request->Email;
} else {
    $email = $request->email;
}

$password = $request->password;
$password = SHA1($password);
$p = $db->query("SELECT *FROM user WHERE email = '$email' AND passwords = '$password'");
$p = $p->rowcount();
if ($p<=0) {
    echo json_encode(['response'=> false]);
} else {
    echo json_encode(['response'=> true]);
}

?>