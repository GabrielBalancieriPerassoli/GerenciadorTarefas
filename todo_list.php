<?php
session_start();

if (isset($_POST['nome']) && $_POST['nome'] != '') {
    $tarefa = array();
    $tarefa['nome'] = $_POST['nome'];
    $tarefa['concluida'] = false;
    $_SESSION['lista_tarefas'][] = $tarefa;
}

if (isset($_SESSION['lista_tarefas'])) {
    $lista_tarefas = $_SESSION['lista_tarefas'];
} else {
    $lista_tarefas = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['concluida'])) {
        $concluidas = $_POST['concluida'];
        foreach ($concluidas as $index) {
            unset($lista_tarefas[$index]); 
        }
        $_SESSION['lista_tarefas'] = array_values($lista_tarefas);
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Gerenciador de Tarefas</h1>
    <form method="post">
        <div class="cadastrar-tarefa">
            <h2>Tarefa<h2>
                    <input autocomplete="off" type="text" name="nome">
                    <button type="submit" name="enviar" required>Nova Tarefa</button>
        </div>
    </form>

    <div class="tabela">
        <form method="post">
            <div class="atualizar">
                <tr>
                    <td>
                        <button type="submit">Atualizar</button>
                    </td>
                </tr>
            </div>
            <br>
            <table>
                <?php foreach ($lista_tarefas as $index => $tarefa) : ?>
                <tr>
                    <td>
                        <div class="listar">
                            <div class="tarefas">
                                <?php if ($tarefa['concluida']) : ?>
                                <p><s><?php echo $tarefa['nome']; ?></s></p>
                                <?php else : ?>
                                <p><?php echo $tarefa['nome']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="concluida">
                                <input class="form-check-input" name="concluida[]" type="checkbox"
                                    value="<?php echo $index; ?>" id="checkbox_<?php echo $index; ?>"
                                    <?php if ($tarefa['concluida']) echo 'checked'; ?>>
                                <label for="checkbox_<?php echo $index; ?>"></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</body>

</html>