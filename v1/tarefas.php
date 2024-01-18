<?php
session_start();
if (isset($_POST['nome_tarefa'])) {
    if ($_POST['nome_tarefa'] != "") {
        if($_FILES['imagem_tarefa']){
            $ext = strtolower(substr($_FILES['imagem_tarefa']['name'],-4));
            $file_name = md5(date('Y.m.d.H.i.s')) . $ext;
            $dir = 'uploads/';
            move_uploaded_file($_FILES['imagem_tarefa']['tmp_name'], $dir.$file_name);
        }
        $dados = [ 
            'nome_tarefa' => $_POST['nome_tarefa'],
            'desc_tarefa' => $_POST['desc_tarefa'],
            'data_tarefa' => $_POST['data_tarefa'],
            'imagem_tarefa' => $file_name

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
    unset($_GET['limpar']);
}
if (isset($_GET['key'])) {
    array_splice($_SESSION['tarefas'], $_GET['key'], 1);
    unset($_GET['key']);
}
?>

