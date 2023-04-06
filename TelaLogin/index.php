<?php

    date_default_timezone_set('America/Sao_Paulo');
    define('HOST','localhost');
    define('DB','user');
    define('USER','root');
    define('PASS','');

    try{
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS,array(PDO::
            MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        echo 'erro eu conectar';
    }

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];

        $sql = $pdo->prepare("INSERT INTO `userregister` VALUES (null,?,?,?)");
        $sql->execute(array($username,$email,$pass));
    }

    $telalogin = 'true';

    if(isset($_POST['submitLogin'])){
        $username = $_POST['username'];
        $pass = $_POST['password'];

        $sql = $pdo->prepare("SELECT * FROM `userregister`");
        $sql->execute();

        $login = $sql->fetchAll();

        $teste = 'false';

        foreach($login as $key => $value){
            if($username == $value['username'] && $pass == $value['password']){
                $teste = 'true';
            }
        }
        if($teste == 'true'){
            $telalogin = 'false';
            include('TelaLogin/telalogin.html');
        }else 
            echo 'Erro de login';
    }

    if(isset($_POST['registerView'])){
        $telalogin = 'false';
        include('register.html');
        
    }
    
    
    if($telalogin == 'true'){
        include('login.html');
    }

?>

<?php
    if(isset($_POST['formEmail'])){
        //Variáveis
        $nome = $_POST['cf-name'];
        $email = $_POST['cf-email'];
        $mensagem = $_POST['cf-message'];
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');

        //Compo E-mail
        $arquivo = "
            <html>
            <p><b>Nome: </b>$nome</p>
            <p><b>E-mail: </b>$email</p>
            <p><b>Mensagem: </b>$mensagem</p>
            <p>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></p>
            </html>
        ";
        
        //Emails para quem será enviado o formulário
        $destino = "klismanfdm@gmail.com";
        $assunto = "Contato pelo Site";

        //Este sempre deverá existir para garantir a exibição correta dos caracteres
        $headers  = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= "From: $nome <$email>";

        //Enviar
        mail($destino, $assunto, $arquivo, $headers);
        
        echo 'Mensagem enviada';
    }//fim do if
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    
    <link rel="stylesheet" href="TelaLogin/css/bootstrap.min.css">
     <link rel="stylesheet" href="TelaLogin/css/all.min.css">
     <link rel="stylesheet" href="TelaLogin/css/owl.carousel.min.css">
     <link rel="stylesheet" href="TelaLogin/css/owl.theme.default.min.css">

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="TelaLogin/css/tooplate-ben-resume-style.css">
    <title>Login</title>
</head>
</html>


