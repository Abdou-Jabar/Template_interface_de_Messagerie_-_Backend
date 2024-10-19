<?php
    require 'connect.php';
    session_start();

    if (isset($_SESSION['id_utilisateur'])) {
        $id_utilisateur = $_SESSION['id_utilisateur'];
        $sql = "SELECT * FROM message";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $is_user_message = $row['id_utilisateur'] == $id_utilisateur;
                $sqlpseudo = "SELECT pseudo
                                from utilisateur u
                                join message m
                                on u.id_utilisateur = {$row['id_utilisateur']}";
                $resultPseudo = $conn->query($sqlpseudo);
                if ($resultPseudo->num_rows > 0):
                    $rowPseudo = $resultPseudo->fetch_assoc();
                    $pseudo = $rowPseudo['pseudo'];
?>
                <div class="flex <?= $is_user_message ? 'justify-end' : 'justify-start'?> mb-2">
                    <div class="<?= $is_user_message ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'?> p-3 rounded-lg max-w-xs">
                        <?php if ($is_user_message): ?>
                            <?= $row['message'] ?>
                        <?php else : ?>
                            <strong><?=$pseudo?></strong>: <?= $row['message'] ?>
                        <?php endif; ?>
                    </div>
                </div>
<?php
                endif;
            endwhile;
        endif;
    } else {
        echo "Vous devez être connecté pour voir les messages.";
    }
?>
