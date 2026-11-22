
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/auth.php';

exigirLogin();

$id = (int) ($_GET['id'] ?? 0);

try {

    if ($id <= 0) {
        header('Location: index.php?erro=excluir');
        exit;
    }

    // Verifica se existem animais vinculados ao tutor
    $s = $pdo->prepare("SELECT COUNT(*) FROM animais WHERE tutor_id = ?");
    $s->execute([$id]);

    $total = $s->fetchColumn();

    if ($total > 0) {
        header('Location: index.php?erro=animais');
        exit;
    }

    // Exclui o tutor
    $s = $pdo->prepare("DELETE FROM tutores WHERE id = ?");
    $s->execute([$id]);

    header('Location: index.php?sucesso=excluido');
    exit;

} catch (PDOException $e) {

    header('Location: index.php?erro=excluir');
    exit;

}
