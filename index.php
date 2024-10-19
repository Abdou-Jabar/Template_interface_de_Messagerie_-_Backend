<?php
    require 'db/connect.php';
    
    if(isset($_POST['pseudo'])){
        $pseudo = $_POST['pseudo'];
        $sql = "select * from utilisateur where pseudo = '$pseudo'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            header("Location: messagerie.php");
            session_start();
            $sql = "SELECT id_utilisateur FROM utilisateur WHERE pseudo = '$pseudo'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_utilisateur = $row['id_utilisateur'];
            }
            $_SESSION['id_utilisateur'] = $id_utilisateur;
            exit();
        }
        else {
            $sqlinsert = "insert into utilisateur (`pseudo`) values ('$pseudo')";
            if($conn->query($sqlinsert) === TRUE){
                header("Location: messagerie.php");
                session_start();
                $sql = "SELECT id_utilisateur FROM utilisateur WHERE pseudo = '$pseudo'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id_utilisateur = $row['id_utilisateur'];
                }
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