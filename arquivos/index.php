<?php
require __DIR__ ."\connection.php";
session_start();

$stmt = $conn->prepare("SELECT * FROM tarefas");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$dados = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <title>Gerenciador de Tarefas</title>
</head>

<body>
    <div class="container">
    <?php 
if(isset($_SESSION['sucess'])){
?>
    <div class="alert-sucess">
        <?php 
            echo $_SESSION['sucess'];
        ?>
    </div>
    <?php 
        unset($_SESSION['sucess']);
    }
?>

<?php
if(isset($_SESSION['error'])){
?>
    <div class="alert-error">
        <?php 
            echo $_SESSION['error'];
        ?>
    </div>
    <?php 
        unset($_SESSION['error']);
    }
?>

        
        
        <div class="header">
            <h1>Gerenciador de tarefas</h1>

        </div>
        <div class="form">
            <form action="tarefa.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="insert" value="insert">
                <label for="nome_tarefa">Tarefa:</label>
                <input type="text" name="nome_tarefa" placeholder="Nome da Tarefa">
                <label for="desc_tarefa">Descriçao:</label>
                <input type="text" name="desc_tarefa" placeholder="Descriçao da Tarefa">
                <label for="data_tarefa">Data:</label>
                <input type="date" name="data_tarefa" placeholder="Nome da Tarefa">
                <label for="imagem_tarefa">Imagem</label>
                <input type="file" name="imagem_tarefa" id="">
                <button type="submit">Cadastrar</button>


            </form>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p style='color: #black';>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>
        </div>
        <div class="separator">

        </div>
        <div class="lista-tarefas">
            <?php
                echo "<ul>";
                foreach ($dados as $tarefa) {
                    echo ("<li> <a href='details.php?id=" . $tarefa['id'] ."'>" . $tarefa['nome_tarefa'] . "</a>
                    <button type='button' class='btn-remover' onclick='remover".$tarefa['id']."()' >Remover</button>
                    <script> 
                    function remover". $tarefa['id']. "(){
                        if (confirm('Confirmar remoçao?')){
                            window.location.href = '?id=".$tarefa['id']."';
                        }
                        return false;
                    }
                    </script>
                    </li>");
                };
                echo "<ul>";
                
                if (isset($_GET['id'])) {
                    $stmt =$conn->prepare('DELETE FROM tarefas WHERE id= :id');
                    $stmt->bindParam(':id', $_GET['id']);
                
                    if($stmt->execute()){
                        $_SESSION['sucess']="Dados removidos";
                    } else {
                        $_SESSION['error']="Dados Não removidos";
                    }
                }
                
            ?>

            <form action="tarefa.php" method="get">
                <input type="hidden" name="limpar" value="limpar">
                <button class="btn-limpar" type="submit">Limpar tarefas</button>

            </form>
        </div>
        <div class="footer">
            <p> Desenvolvido por Caua Mahl</p>
        </div>
    </div>
    <?php
    ?>
</body>
</html>