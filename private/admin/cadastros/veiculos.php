<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;

    $modelo = $anomodelo = $anofabricacao = $valor = $tipo = $fotoDestaque  = $usuario_id = $cor_id = $marca_id = NULL;

	$usuario_id = ($_SESSION['admin']['id']);


    //select para edição
    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from veiculo where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $modelo = $dados->modelo;
        $anomodelo = $dados->anomodelo;
        $anofabricacao = $dados->anofabricacao;
        $valor = formatarValorBR($dados->valor);
		$tipo = $dados->tipo;
        $fotoDestaque = $dados->fotoDestaque;
        
		$usuario_id =$dados->usuario_id;
        $cor_id =$dados->cor_id;
        $marca_id =$dados->marca_id;

    }

?>
<div class="cadastro-veiculos">
	<div class="cadastro-veiculos__header">
		<div class="cadastro-veiculos__header--control">
			<a href="cadastros/veiculos" class="cadastro-veiculos__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/veiculos" class="cadastro-veiculos__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
		<h3 class="cadastro-veiculos__header--title">Cadastro de veiculos</h3>
	</div>
	<div class="cadastro-veiculos__container">
		<form name="formCadastro" method="post" action="salvar/veiculos" data-parsley-validate="" enctype="multipart/form-data">			
			<div class="cadastro-veiculos__container__form">
				<div class="col-12 col-md-2">
					<label for="id">ID:</label>
					<input type="text" name="id" id="id"
					class="form-control" readonly
					value="<?=$id?>">
				</div>
				<div class="col-12 col-md-10">
					<label for="modelo">Nome do modelo*:</label>
					<input type="text" name="modelo"
					id="modelo" class="form-control" required data-parsley-required-message="Digite o nome do modelo"
					value="<?=$modelo?>"  maxlength="200">
				</div>
				<div class="col-12 col-md-4">
					<label for="valor">Valor do veiculo*:</label>
					<input type="text" name="valor" id="valor" class="form-control valor" required 
					data-parsley-required-message="Digite o valor do veiculo" inputmode="numeric" value="<?=$valor?>">
				</div>
				<div class="col-12 col-md-4">
					<label for="anomodelo">Ano do modelo*:</label>
					<input type="text" name="anomodelo" id="anomodelo" class="form-control" required 
					data-parsley-required-message="Digite o ano do modelo" inputmode="numeric" value="<?=$anomodelo?>">
				</div>
				<div class="col-12 col-md-4">
					<label for="anofabricacao">Ano de fabricação*:</label>
					<input type="text" name="anofabricacao" id="anofabricacao" class="form-control" required 
					data-parsley-required-message="Digite o ano de fabricação" inputmode="numeric" value="<?=$anofabricacao?>">
				</div>
				<div class="col-12 col-md-4">
					<?php

						$required = ' required data-parsley-required-message=" " ';
						$link = NULL;

						//verificar se a imagem não esta em branco
						if ( !empty ( $fotoDestaque ) ) {
							//caminho para a imagem
							$img = "../veiculos/{$fotoDestaque}m.jpg";
							//criar um link para abrir a imagem
							$link = "<a href='{$img}' data-lightbox='foto' class='badge badge-success'>Abrir imagem</a>";
							$required = NULL;

						}

					?>
					<label for="fotoDestaque">Foto destaque (JPG)* <?=$link?>:</label>
					<input type="file" name="fotoDestaque" 
					id="fotoDestaque" class="form-control"
					<?=$required?> accept="image/jpeg">
				</div>
				<div class="col-12 col-md-6">
					<label for="marca_id">Selecione uma Marca*:</label>
					<select name="marca_id" id="marca_id" class="form-control" required data-parsley-required-message="Selecione uma marca">
						<option value=""></option>
						<?php
						//selecionar todas as marcas
						$sql = "select id, marca from marca order by marca";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

							echo "<option value='{$dados->id}'>{$dados->marca}</option>";

						}
						?>
					</select>
				</div>
				<div class="col-12 col-md-6">
					<label for="cor_id">Selecione uma cor*:</label>
					<select name="cor_id" id="cor_id" class="form-control" required data-parsley-required-message="Selecione uma cor">
						<option value=""></option>
						<?php
						//selecionar todas as marcas
						$sql = "select id, cor from cor order by cor";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

							echo "<option value='{$dados->id}'>{$dados->cor}</option>";

						}
						?>
					</select>
				</div>
				<div class="col-12 col-md-4">
					<label for="tipo">Tipo:</label>
					<select name="tipo" id="tipo" class="form-control" required data-parsley-required-message="Selecione uma opção">
						<option value="">Selecione</option>
						<option value="n">Novo</option>
						<option value="s">Semi-novo</option>
					</select>
				</div>
			</div>

			<button type="submit" class="cadastro-veiculos__container__form--button float-right">
				<i class="fas fa-check"></i> Salvar / Alterar
			</button>

			<br>
			<p>
				<small>* Obrigatório o preenchimento</small>
			</p>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".valor").maskMoney({
			thousands: '.',
			decimal: ','
		});

		//selecionar a categoria
		$("#cor_id").val(<?=$cor_id?>);
		$("#marca_id").val(<?=$marca_id?>);
		$("#tipo").val("<?=$tipo?>");
	})
</script>


