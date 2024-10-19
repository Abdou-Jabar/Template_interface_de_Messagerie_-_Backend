<?php
    //Importation du fichier de connexion à la base de donnée
    require 'db/connect.php';
    
    //Vérification: on verifie si un pseudo est défini
    if(isset($_POST['pseudo'])){

        $pseudo = $_POST['pseudo'];

        //Requête pour vérifier si l'identifiant de l'utilisateur est déjà dans notre base de donnée
        $sql = "SELECT id_utilisateur from utilisateur where pseudo = '$pseudo'";
        $result = $conn->query($sql);

        /**
         * La bloc de condition <if> s'éxécute si l'identifiant est déjà présent dans la base
         * 
         * Au cas contraire <else> s'éxécutera
         */

        if($result->num_rows > 0){

            //Redirection vers l'interface de message
            header("Location: messagerie.php");
            session_start();
            
            /*
             * Récupération des données de la base sous forme de tableau
             * Récupération de l'identifiant de l'utilisateur dans une variable
             * Création d'une session avec la clé id_utilisateur
             */
            
            $row = $result->fetch_assoc();
            $id_utilisateur = $row['id_utilisateur'];
            $_SESSION['id_utilisateur'] = $id_utilisateur;
            exit();
        }
        else {
            //Insertion de l'identifiant de l'utilisateur dans la base de donnée
            $sqlinsert = "insert into utilisateur (`pseudo`) values ('$pseudo')";
            if($conn->query($sqlinsert) === TRUE){
                //Redirection vers l'interface de message
                header("Location: messagerie.php");
                session_start();

                /*
                 * Récupération des données de la base sous forme de tableau
                 * Récupération de l'identifiant de l'utilisateur dans une variable
                 * Création d'une session avec la clé id_utilisateur
                 */

                $row = $result->fetch_assoc();
                $id_utilisateur = $row['id_utilisateur'];
                $_SESSION['id_utilisateur'] = $id_utilisateur;
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover" style="background-image: url(../images/image.avif)">
    <form action="" method="post">
        <div class="flex flex-col justify-center items-center h-screen w-auto">
            <label for="pseudo" class="text-white my-4 text-2xl">Pseudo</label>
            <input type="text" placeholder="Entre votre pseudo" class="text-center rounded-xl" name="pseudo">
            <button class="text-white my-4">Se connecter</button>
        </div>
    </form>
</body>
</html>
