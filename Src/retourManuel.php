<?php   

$message = $_POST['DATA'];
    $pathfile = "Sherlocks/Sherlocks/param_demo/pathfile";
    $response = exec("Sherlocks/Sherlocks/bin/response" . " ". "message"."=".$message . " ". "pathfile"."=".$pathfile );
    $response2 = explode("!", $response);

    $amount = $response2[5]/100;
    $date = $response2[10];




    $content = "############################################################## \n";
    $content .= "Achat de " . $amount . "$\n";
    $content .=  "Paiement effectué le " . $date; 
    $content .= "\n";

    $fichier = fopen('logs.txt', 'c+b');
    fwrite($fichier, $content);
    //file_put_contents('logs.txt', $content);
/*
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "alexandre_guerin14@hotmail.com";
    $to = "alexandre_guerin14@hotmail.com";
    $subject = "Essai de PHP Mail";
    $message = "PHP Mail fonctionne parfaitement";
    $headers = "De :" . $from;
    mail($to,$subject,$message, $headers);
    echo "L'email a été envoyé.";*/

    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Paiement accepté</title>
</head>
<body>
    <h1> Votre paiement de <?php echo $amount . "$ ";   ?>a été réalisé avec succès </h1>

    
</body>
</html>