<?php
require __DIR__ . '/connection.php';
error_reporting(E_ALL & ~E_WARNING);
session_start();

if (isset($_POST['nome_tarefa'])) {
    if ($_POST['nome_tarefa'] != "") {
        if($_FILES['imagem_tarefa']){
            $ext = strtolower(substr($_FILES['imagem_tarefa']['name'],-4));
            $file_name = md5(date('Y.m.d.H.i.s')) . $ext;
            $dir = 'uploads/';
            move_uploaded_file($_FILES['imagem_tarefa']['tmp_name'], $dir.$file_name);
        }
      
        $stmt = $conn->prepare('INSERT INTO tarefas(nome_tarefa,desc_tarefa,imagem_tarefa,data_tarefa)
        VALUES (:nome, :desc,:imagem,:data);');

        $stmt->bindParam('nome',$_POST['nome_tarefa']);
        $stmt->bindParam('desc',$_POST['desc_tarefa']);
        $stmt->bindParam('imagem',$file_name);
        $stmt->bindParam('data',$_POST['data_tarefa']);

        if($stmt->execute()){
            $_SESSION['sucess']="Dados Cadastrados";
        } else {
            $_SESSION['error']="Dados Não Cadastrados";    
        }

    } /*else {
        $_SESSION['message'] = "o campo Nome da Tarefa precisa ser preenchido!";


    };*/
    header('Location:index.php');
}
if (isset($_GET['limpar'])) {
    $stmt = $conn->prepare('SELECT id FROM tarefas');
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $deleteStmt = $conn->prepare('DELETE FROM tarefas WHERE id= :id');
        $deleteStmt->bindParam(':id', $id);

        if($deleteStmt->execute()){
            $_SESSION['success']="Dados removidos";
        } else {
            $_SESSION['error']="Dados Não removidos";
        }
    }
    header('Location:index.php');
}
if (isset($_GET['id'])) {
    $stmt =$conn->prepare('DELETE FROM tarefas WHERE id= :id');
    $stmt->bindParam(':id', $_GET['id']);

    if($stmt->execute()){
        $_SESSION['sucess']="Dados removidos";
    } else {
        $_SESSION['error']="Dados Não removidos";
    }
} /*else {
    $_SESSION['message'] = "o campo Nome da Tarefa precisa ser preenchido!";
}*/


?>

