
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    nome do evento:<br>
    <input type="text" name="nome"><br>
    TITULO do evento:<br>
    <input type="text" name="titulo"><br>
    DESCRIÇÃO do evento:<br>
    <input type="text" name="desc"><br>
    LOCAL do evento:<br>
    <input type="text" name="local"><br>
    DATA do evento:<br>
    <input type="datetime" name="data"><br>
    GRUPO do evento:<br>
    <input type="text" name="grupo"><br>
    link do evento:<br>
    <input type="text" name="link"><br>
    
    <input type="submit" name="submit"  value="registrar"><br>
</form>

</body>
</html>

<?php 

include("database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nome_html = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
    $titulo_html = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS);
    $desc_html = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_SPECIAL_CHARS);
    $local_html = filter_input(INPUT_POST, "local", FILTER_SANITIZE_SPECIAL_CHARS);
    $data_html = forArray(filter_input(INPUT_POST, "data", FILTER_SANITIZE_SPECIAL_CHARS));
    $grupo_html = array(filter_input(INPUT_POST, "grupo", FILTER_SANITIZE_SPECIAL_CHARS));
    $link_html = filter_input(INPUT_POST, "link", FILTER_SANITIZE_SPECIAL_CHARS);
    


    if(empty($nome_html)){
        echo "selecione um nome para o projeto<br>";
    }
    elseif(empty($titulo_html)){
        echo "selecione um nome para o projeto<br>";
    }
    elseif(empty($desc_html)){
        echo "selecione uma descrição para o projeto<br>";
    }
    elseif(empty($local_html)){
        echo "selecione um local para o projeto<br>";
    }
    elseif(empty($data_html)){
        echo "selecione uma data para o projeto<br>";
    }
    elseif(empty($grupo_html)){
        echo "selecione um grupo para o projeto<br>";
    }
    elseif(empty($link_html)){
        echo "selecione um link para o projeto<br>";
    }
    else{
        $connection = connect("root","");
        
        setEvent( $connection,$nome_html,$titulo_html,$desc_html,$local_html,$data_html,$grupo_html,$link_html);
        
        echo "ta funcionando chefia";
    }
   
    }
    mysqli_close($connection);
?>
