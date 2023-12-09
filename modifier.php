<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

         //connexion à la base de donnée
          include_once "connexion.php";
         //on récupère le id dans le lien
          $id = $_GET['id'];
          //requête pour afficher les infos d'un employé
          $req = "SELECT * FROM contact WHERE id = $id";
          $result = $con->query($req);
          if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $categorie_id = $row['categorie_id'];
        }


       //vérifier que le bouton ajouter a bien été cliqué
       if(isset($_POST['button'])){
           //extraction des informations envoyé dans des variables par la methode POST
           extract($_POST);
           //verifier que tous les champs ont été remplis
           if(isset($nom) && isset($prenom) && $categorie_id){
               //requête de modification
               $req = mysqli_query($con, "UPDATE contact SET nom = '$nom' , prenom = '$prenom' , categorie_id = '$categorie_id' WHERE id = $id");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: index.php");
                }else {//si non
                    $message = "Contact non modifié";
                }

           }else {
               //si non
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>

    <div class="form">
        <a href="index.php" class="back_btn"><img src="images/back.png"> Retour</a>
        <h2>Modifier le conatct : <?=$row['id']?> </h2>
        <p class="erreur_message">
           <?php 
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>
        <form action="" method="POST">
            <label>Nom</label>
            <input type="text" name="nom" value="<?= $nom; ?>">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?= $prenom; ?>">
            <label>Catégorie</label>
            <select id="categorie" name="categorie">
                <?php
                    //connexion à la base de donnée
                    include_once "connexion.php";
                    // Récupérez les catégories depuis la base de données
                    $categories_sql = "SELECT * FROM categorie";
                    $categories_result = $con->query($categories_sql);

                    // Affichez les options de catégorie dans le formulaire
                    while ($cat_row = $categories_result->fetch_assoc()) {
                        $selected = ($cat_row['id'] == $categorie_id) ? 'selected' : '';
                        echo '<option value="' . $cat_row['id'] . '" ' . $selected . '>' . $cat_row['nom'] . '</option>';
                    }
             
                 ?>  
            </select>
            <input type="submit" value="Modifier" name="button">
        </form>
    </div>
</body>
</html>