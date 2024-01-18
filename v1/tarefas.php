<?php
session_start();
if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = array();
}
if (isset($_POST['nome_tarefa'])) {
    if ($_POST['nome_tarefa'] != "") {
        $dados = [ 
            'nome_tarefa' => $_POST['nome_tarefa'],
            'desc_tarefa' => $_POST['desc_tarefa'],
            'data_tarefa' => $_POST['data_tarefa']
        ];
        array_push($_SESSION['tarefas'], $dados);
        unset($_POST['nome_tarefa']);
        unset($_POST['desc_tarefa']);

        unset($_POST['data_tarefa']);
        header('Location:index.php');

    } else {
        $_SESSION['message'] = "o campo Nome da Tarefa precisa ser preenchido!";
    };
}
if (isset($_GET['limpar'])) {
    unset($_SESSION['tarefas']);
}
if (isset($_GET['key'])) {
    array_splice($_SESSION['tarefas'], $_GET['key'], 1);
    unset($_GET['key']);
}
?>

