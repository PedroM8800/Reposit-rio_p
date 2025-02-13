<?php
    #MANIPULAÇÃO
    define("PTEMPO_DIA", 0);
    define("PTEMPO_MES", 1);
    define("PTEMPO_ANO", 2);
    define("PTEMPO_HORA", 3);
    define("PTEMPO_MINUTO", 4);
    define("PTEMPO_SEGUNDO", 5);
    define("PTECA_MAIN_TABLE", "tb_evento");
    
    define("PDATA_ID", 0);
    define("PDATA_NOME", 1);
    define("PDATA_TITULO", 2);
    define("PDATA_DESCRICAO", 3);
    define("PDATA_LOCAL", 4);
    define("PDATA_DATA", 5);
    define("PDATA_GRUPO", 6);
    define("PDATA_LINK", 7);

    #LOCAIS TERMINAR!!!
    define("PLOCAL_PATIO", "patio");

    function connect($admin, $password)
    {
        //Conexão com o banco de dados
        //COLOCAR O mysqli_select_db NA MESMA FUNÇÃO DO mysqli_connect !!!! NÃO ESQUECER
        $connect = mysqli_connect("localhost", $admin, $password);
        mysqli_select_db($connect, "pernambucalia");
        return $connect;
    }

    function connectTo($ip, $admin, $password)
    {
        //Conexão com o banco de dados
        //COLOCAR O mysqli_select_db NA MESMA FUNÇÃO DO mysqli_connect !!!! NÃO ESQUECER
        $connect = mysqli_connect("$ip", $admin, $password);
        mysqli_select_db($connect, "pernambucalia");
        return $connect;
    }

    function setEvent($connection, $nome, $titulo, $descricao, $enum_local, $array_data = [], $array_grupo = [], $link)
    {
        //IMPLEMENTAR SEGUNDOS!!!!
        //Setar novos eventos
        //array_data[0] = dia, array_data[1] = mes, array_data[2] = ano, array_data[3] = hora, array_data[4] = minuto, array_data[5] = segundo
        //Criando as variaveis para serem usadas
        $ano = PTEMPO_ANO; $mes = PTEMPO_MES; $dia = PTEMPO_DIA; $hora = PTEMPO_HORA; $minuto = PTEMPO_MINUTO;
        $table = PTECA_MAIN_TABLE;
        $grupo = "$array_grupo[0]";
        //echo "$array_data[PTEMPO_MES]";
        //Adicionar a variavel grupo os outros respectivos membros
        if(sizeof($array_grupo) > 1)
        {
            for($i = 1; $i < sizeof($array_grupo); $i++)
            {
                //"." Server para concatenação!!! Não esquecer!!!!
                $grupo = $grupo.", ".$array_grupo[$i];
            }
        }
        //Executando o codigo
        $data = date("Y-m-d H:i:s", mktime( $array_data[$hora], $array_data[$minuto], 0, $array_data[$mes], $array_data[$dia], $array_data[$ano]));
        $sql = "INSERT INTO $table VALUES(null, '$nome', '$titulo', '$descricao', '$enum_local', '$data', '$grupo', '$link');";
        mysqli_query($connection, $sql);
    }

    function forArray($data)
    {
        //Converte uma data string em um array para ser inserido
        $args = explode("/", $data);
        $convert = [];
        
        for($i = 0; $i < count($args); $i++)
        {
            $var = intval($args[$i]);
            array_push($convert, $var);
        }
            
        return $convert;
    }

    function forArrayWithSep($data, $separador)
    {
        //Converte uma data string em um array para ser inserido
        $args = explode($separador, $data);
        $convert = [];
        
        for($i = 0; $i < count($args); $i++)
        {
            $var = intval($args[$i]);
            array_push($convert, $var);
        }
            
        return $convert;
    }

    function updateEvent($connection, $id, $newNome, $newTitulo, $newDescricao, $newLocal, $newData = [], $newGrupo = [], $newLink)
    {
        //Atualizar evento cadastrado
        //Criando as variaveis para serem usadas
        $ano = PTEMPO_ANO; $mes = PTEMPO_MES; $dia = PTEMPO_DIA; $hora = PTEMPO_HORA; $minuto = PTEMPO_MINUTO;
        $table = PTECA_MAIN_TABLE;
        $grupo = "$newGrupo[0]";

        //Adicionar a variavel grupo os outros respectivos membros
        if(sizeof($newGrupo) > 1)
        {
            for($i = 1; $i < sizeof($newGrupo); $i++)
            {
                $grupo = $grupo.", ".$newGrupo[$i];
            }
        }

        //Executando o codigo
        $data = date("Y-m-d H:i:s", mktime( $newData[$hora], $newData[$minuto], 0, $newData[$mes], $newData[$dia], $newData[$ano]));
        $sql = "UPDATE $table SET varchar_nome_evento = '$newNome', varchar_titulo_evento = '$newTitulo', varchar_desc_evento = '$newDescricao', enum_local_evento = '$newLocal', datetime_data_evento = '$data', varchar_grupo_evento = '$grupo', varchar_linkConteudo_evento = '$newLink' WHERE int_id_evento = $id;";
        mysqli_query($connection, $sql);
    }

    function eventExists($connection, $id)
    {
        //Se o evento ja existe
        $table = PTECA_MAIN_TABLE;
        $result = mysqli_query($connection, "SELECT * FROM $table WHERE int_id_evento = $id;");

        //Verificar se o evento ja está cadastrado na tabela
        $exist = false;
        if(mysqli_num_rows($result) > 0)
        {
            $exist = true;
        }

        return $exist;
    }

    function getEvent($connection, $id)
    {
        //Pegar um evento especifico do pernambucalia
        $table = PTECA_MAIN_TABLE;
        $res = mysqli_query($connection, "SELECT * FROM $table WHERE int_id_evento=$id;");
        return mysqli_fetch_row($res);
    }

    function getAllEvents($connection)
    {
        //Pegar todos os eventos disponiveis no pernambucalia
        $table = PTECA_MAIN_TABLE;
        $res = mysqli_query($connection, "SELECT * FROM $table;");
        return mysqli_fetch_row($res);
    }

    function deleteEvent($connection, $id)
    {
        //Deletar um evento especifico
        $table = PTECA_MAIN_TABLE;
        mysqli_query($connection, "DELETE FROM $table WHERE int_id_evento=$id;");
    }

    function getIdByName($connection, $name)
    {
        //Pegar o id do evento pelo nome
        $table = PTECA_MAIN_TABLE;
        $id = mysqli_query($connection, "SELECT int_id_evento FROM $table WHERE varchar_nome_evento = '$name';");

        //Usar mysqli_fetch_row para transformar o vetor mysql em um ventor normal
        return mysqli_fetch_row($id)[0];
    }

    function closeConnection($connection)
    {
        //Fechar a conexão do banco de dados
        mysqli_close($connection);
    }
?>
