<link rel="stylesheet" type="text/css" href="../style/stylescnx.css">

<?php


if (isset($_POST['submit'])){
    extract($_POST);
  


     if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($password) && !empty($cpassword)){


        if($password == $cpassword){

        $options = [
            'cost' => 12,
        ];
        $hashpass = password_hash($password, PASSWORD_BCRYPT, $options);

        include 'database.php';
        global $db;


        $c = $db->prepare("SELECT email FROM user WHERE email = :email");
        $c->execute(['email' => $email]);

        $result= $c->rowCount();

        if($result ==0){

             $q = $db->prepare("INSERT INTO user(lastname,firstname,email,password) VALUES(:lastname,:firstname,:email,:password)");
        $q->execute([
            'lastname'=>$lastname,
            'firstname'=>$firstname,
            'email'=>$email,
            'password'=>$hashpass
        ]);
           echo "<h3> Votre compte a été créé avec succès ! </h3> Vous pouvez <b> Vous Connecter Maintenant !</b>  ";
           include '../content/login.html';

        } else{
             echo " <h2> ERREUR ! </h2> <h3> cette émail < <b> $email </b> >  éxiste dejja </h3> <br> <h4> Veuillez bien vérefier Votre <b> email! </b> <b>Merci<b> </h4> <br>";
              ?>
        <a href="../content/register.html">Retourne</a>
        <?php
        }




       

    } else {
        echo " <h2> ERREUR ! </h2> <h3> Mots de passe <b> Non identique </b> </h3><br> <h4>Veuillez bien vérefier Votre <b>mots de passe ! </b><b>Merci<b> </h4>";
        ?>
        <a href="../content/register.html">Retourne</a>
        <?php
    }
      


        
          
                

            }
             else {
            echo " <h3> Veuillez Completer tout les champs ! <b> Merci </b> </h3> ";
              ?>
        <a href="../content/register.html"><h1>Retourne<h1></a>
        <?php
                  }



        }