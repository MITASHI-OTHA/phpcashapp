<?php
$req = file_get_contents('php://input');
$data = json_decode($req);
if(null !== $data->email && null !== $data->password) {
	$email = $data->email;
	$pass = $data->password;
	require('connexion.php');
	$reg = $db->query("SELECT *FROM users WHERE LOWER(email) = LOWER('$email') AND (passwords = '$pass' AND confirm = 1)");
	$cmpt = $reg->rowcount($reg);
	if($cmpt>=1) {
		$use = $reg->fetch();
		$tab = ['data'=> $use, 'type'=> 'formulaire', 'message'=> 'Vous êtes connectés', 'couleur'=> 'success', 'status'=> 1];
	} else {
		$tab = ['message'=> 'Votre email ou mot de passe ne nous dit rien !', 'couleur'=> 'danger', 'status'=> 0];
	}
	echo json_encode($tab);
}

?>