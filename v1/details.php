<?php 
require __DIR__ .'/connection.php';
session_start();
$stmt = $conn->prepare("SELECT * FROM tarefas WHERE id= :id");
$stmt->bindParam(':id', $_GET['key']);
$stmt->execute();
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
    <div class="details-container">
        <div class="header">
            <h1>
                <?php 
                    echo $dados['nome_tarefa'];
            
                ?>

            </h1>
        </div>
        <div class="row">
            <div class="details">
                <dl>
                    <dt>Descriçao da Tarefa:
                    </dt>
                    <dd>
                        <?php 
                            echo $dados['desc_tarefa']
                        ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Data da Tarefa:
                    </dt>
                    <dd>
                        <?php 
                            echo $dados['data_tarefa']
                        ?></dd>
                </dl>

            </div>
            <div class="imagem">
                <img src="uploads/<?php echo $dados['imagem_tarefa']?>" alt="imagem da tarefa">
            </div>
        </div>
        <div class="footer">
            <p> Desenvolvido por Caua Mahl</p>


        </div>

    </div>
</body>
</html>