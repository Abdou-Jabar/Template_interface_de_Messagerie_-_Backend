<?php
    include 'db/connect.php';
    session_start();
    
    //Verifions si un message a été envoyé
    if(isset($_POST['message'])){
        //Récupération du message ne faisant pas confiance à l'utilisateur et pour éviter des erreurs (utilisation de htmlentites())
        $message = htmlentities($_POST['message']);

        //Récupération de la date au moment de l'envoi du message
        $date = date('H:i:s');        

        //Requête pour Récuperer le dernier message
        $sql_dernier_message = "SELECT * FROM message
                                ORDER BY id_message DESC
                                LIMIT 1";
                                
        //On vérifie si un message à été récupérer
        if($conn->query($sql_dernier_message)->num_rows > 0){

            /**
             * Récupération du dernier message en tableau
             * Si ce message est différent du message qui vient d'être envoyer, on l'insert dans la base
            **/

            $row = $conn->query($sql_dernier_message)->fetch_assoc();
            if($row['message'] != $_POST['message']){
                $sql = "insert into message (`id_utilisateur`, `message`, `heure`) values('$id_utilisateur','$message','$date')";
                $result = $conn->query($sql);
            }
        }
        //Toutefois si la base de donnée de message est vide, on insert le message sans vérification
        else {
            $sql = "insert into message (`id_utilisateur`, `message`, `heure`) values('$id_utilisateur','$message','$date')";
            $result = $conn->query($sql);
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-cover shadow-lg rounded-lg w-full max-w-md h-screen flex flex-col bg-[url('images/plage.avif')]">
        <div id="messages" class="flex-grow p-4 overflow-y-auto">
            <?php
                require 'db/read.php'
            ?>
        </div>
        <form action="" method="post">
            <div class="flex p-2 border-t">
                <input autocomplete="off" id="messageInput" name="message" class="flex-grow border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" placeholder="Écrire un message..." required>
                <button id="sendButton" class="bg-blue-500 text-white p-2 rounded-lg ml-2 focus:outline-none hover:bg-blue-600" type="submit">Envoyer</button>
            </div>
        </form>
    </div>
    <script>
        //Script qui se charge du défilement automatique vers des messages pour afficher le dernier message envoyer
        window.onload = function() {
            var messageDiv = document.getElementById("messages");
            messageDiv.scrollTop = messageDiv.scrollHeight;
        };

        //Script qui charge à chaque demi seconde le fichier php qui affiche les messages, de ce fait on aura plus à actualiser la page pour afficher les nouveaux messages reçus
        setInterval('load_message()', 500);
        function load_message() {
            $('#messages').load('db/read.php')
        }
    </script>
</body>
</html>
