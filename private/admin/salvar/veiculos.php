<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;


    if ( $_POST ) {

    	//recuperar os dados dados

        include "libs/imagem.php";

    	foreach ($_POST as $key => $value) {
    		$$key = trim ( $value );
    	}

    	if ( empty ( $modelo ) ) {
    		$titulo = "Erro ao salvar";
    		$mensagem = "Preencha o campo nome do modelo";
    		$icone = "error";

    		mensagem($titulo, $mensagem, $icone);
    	} else if ( empty ( $valor ) ) {
 
     		mensagem("Erro ao salvar", 
     			"Preencha o campo valor", 
     			"error");
    	}


    	$valor = formatarValor($valor);
        //programação para copiar uma imagem
        //no insert envio da foto é obrigatório
        //no update só se for selecionada uma nova imagem


        //se o id estiver em branco e o imagem tbém - erro
        if ( ( empty ( $id ) ) and ( empty ( $_FILES['fotoDestaque']['name'] ) ) ) {
            mensagem("Erro ao enviar imagem", 
                "Selecione um arquivo JPG válido", 
                "error");
        } 

        //se existir imagem - copia para o servidor
        if ( !empty ( $_FILES['fotoDestaque']['name'] ) ) {
            //calculo para saber quantos mb tem o arquivo
            $tamanho = $_FILES['fotoDestaque']['size'];
            $t = 8 * 1024 * 1024; //byte - kbyte - megabyte

            $fotoDestaque = time();
            $usuario = $_SESSION['admin']['id'];

            //definir um nome para a imagem
            $fotoDestaque = "veiculo_{$fotoDestaque}_{$usuario}";

            //validar se é jpg
            if ( $_FILES['fotoDestaque']['type'] != 'image/jpeg' ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo enviado não é um JPG válido, selecione um arquivo JPG", 
                "error");
            } else if ( $tamanho > $t ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo é muito grande e não pode ser enviado. Tente arquivos menores que 8 MB", 
                "error");
            } else if ( !copy ( $_FILES['fotoDestaque']['tmp_name'], '../veiculos/'.$_FILES['fotoDestaque']['name'] ) ) {
                mensagem("Erro ao enviar imagem", 
                "Não foi possível copiar o arquivo para o servidor", 
                "error");
            }
            
            //redimensionar a imagem
            $pastaFotos = '../veiculos/';
            loadImg($pastaFotos.$_FILES['fotoDestaque']['name'], 
                    $fotoDestaque, 
                    $pastaFotos);

        } //fim da verificação da foto

        //se vai dar insert ou update
        if ( empty ( $id ) ) {
            $usuario_id = ($_SESSION['admin']['id']);
            $sql = "insert into veiculo values( NULL, :modelo, :anomodelo, :anofabricacao, :valor, :tipo, :fotoDestaque,:usuario_id, :cor_id, :marca_id)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotoDestaque', $fotoDestaque);
            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);

        } else if ( empty ( $fotoDestaque ) ) {
            $usuario_id = ($_SESSION['admin']['id']);

            $sql = "update veiculo set modelo = :modelo, anomodelo = :anomodelo, anofabricacao = :anofabricacao, valor = :valor, tipo = :tipo, usuario_id = :usuario_id, cor_id = :cor_id, marca_id = :marca_id where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);

            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':marca_id', $marca_id);

            $consulta->bindParam(':id', $id);


        } else {
            $usuario_id = ($_SESSION['admin']['id']);

            $sql = "update veiculo set modelo = :modelo, anomodelo = :anomodelo, anofabricacao = :anofabricacao, valor = :valor, tipo = :tipo, fotodestaque = :fotodestaque, usuario_id = :usuario_id, cor_id = :cor_id,   marca_id = :marca_id where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
  
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotoDestaque', $fotoDestaque);

            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);

            $consulta->bindParam(':id', $id);
        }

        //executar e verificar se foi salvo de verdade
        if ( $consulta->execute() ) {
            mensagem("OK", 
                "Registro salvo/alterado com sucesso!", 
                "ok");
        } else {
            echo $erro = $consulta->errorInfo()[2];

            mensagem("Erro", 
                "Erro ao salvar ou alterar registro", 
                "error");
        }


    }