
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/auth.php';

exigirLogin();

$id = (int) ($_GET['id'] ?? 0);

try {

    if ($id > 0) {

        // Verifica se existem consultas vinculadas
        $s = $pdo->prepare(
            "SELECT COUNT(*) FROM consultas WHERE animal_id = ?"
        );

        $s->execute([$id]);

        $total = $s->fetchColumn();

        if ($total > 0) {
            header('Location: index.php?erro=consultas');
            exit;
        }

        // Exclui o animal
        $s = $pdo->prepare("DELETE FROM animais WHERE id = ?");
        $s->execute([$id]);
    }

    header('Location: index.php?sucesso=excluido');
    exit;

} catch (PDOException $e) {

    header('Location: index.php?erro=excluir');
    exit;

}
