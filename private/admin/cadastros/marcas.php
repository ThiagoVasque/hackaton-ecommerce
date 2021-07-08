<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;

    $marca = NULL;

    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from marca where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $marca = $dados->marca;

    }

?>

<div class="cadastro-marcas">
	<div class="cadastro-marcas__header">
		<div class="cadastro-marcas__header--control">
			<a href="cadastros/marcas" class="cadastro-marcas__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/marcas" class="cadastro-marcas__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
		<h3 class="cadastro-marcas__header--title">Cadastro de marcas</h3>
	</div>
    <div class="cadastro-marcas__container">
        <form name="formCadastro" method="post" action="salvar/marcas" data-parsley-validate="">
        	<div class="cadastro-marcas__container__form">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-10">
        			<label for="tipo">Nome da marca</label>
        			<input type="text" name="marca" id="marca" class="form-control" required data-parsley-required-message="Preencha o tipo">
        		</div>
        	</div>

        	<button type="submit" class="cadastro-marcas__container__form--button float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>