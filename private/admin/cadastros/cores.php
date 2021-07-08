<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;

    $cor = NULL;

    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from cor where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $cor = $dados->cor;

    }

?>

<div class="cadastro-cores">
	<div class="cadastro-cores__header">
		<div class="cadastro-cores__header--control">
			<a href="cadastros/cores" class="cadastro-cores__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/cores" class="cadastro-cores__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
		<h3 class="cadastro-cores__header--title">Cadastro de cores</h3>
	</div>
    <div class="cadastro-cores__container">
        <form name="formCadastro" method="post" action="salvar/cores" data-parsley-validate="">
            <div class="cadastro-usuarios__container__form">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-10">
        			<label for="tipo">Nome da cor</label>
        			<input type="text" name="cor" id="cor" class="form-control" required data-parsley-required-message="Preencha o tipo">
        		</div>
        	</div>

        	<button type="submit" class="cadastro-usuarios__container__form--button float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>