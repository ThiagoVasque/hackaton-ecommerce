<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;

    $tabela = "usuarios";

    $l = $nome = $email = $login = $senha = $foto = $tipo_id = $ativo = NULL;
    $r = " required data-parsley-required-message='Preencha a senha' ";
    $f = " required data-parsley-required-message='Selecione uma Imagem JPG' ";


    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from usuario where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $nome = $dados->nome;
        $email = $dados->email;
        $login = $dados->login;
        $foto = $dados->foto;
        $tipo_id = $dados->tipo_id;
        $ativo = $dados->ativo;

        $l = " readonly ";
        $r = $f = NULL;

    }
?>
<div class="cadastro-usuarios">
	<div class="cadastro-usuarios__header">
		<div class="cadastro-usuarios__header--control">
			<a href="cadastros/usuarios" class="cadastro-usuarios__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/usuarios" class="cadastro-usuarios__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
		<h3 class="cadastro-usuarios__header--title">Cadastro de usuarios</h3>
	</div>
    <div class="cadastro-usuarios__container">
        <form name="formCadastro" method="post" action="salvar/<?=$tabela?>" data-parsley-validate="" enctype="multipart/form-data">
            <div class="cadastro-usuarios__container__form">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-8">
        			<label for="nome">Nome do Usuário:</label>
        			<input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" value="<?=$nome?>">
        		</div>
                <div class="col-12 col-md-2">
                    <label for="tipo_id">Tipo:</label>

                    <?php 
                    if ( $_SESSION["admin"]["tipo_id"] == 1 ) {
                    ?>

                    <select name="tipo_id" id="tipo_id" required data-parsley-required-message="Selecione um tipo" class="form-control">
                        <option value=""></option>
                        <?php
                            $sql = "select * from tipo order by tipo";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ( $d = $consulta->fetch(PDO::FETCH_OBJ) ) {
                                echo "<option value='{$d->id}'>{$d->tipo}</option>";
                            }

                        ?>
                    </select>

                    <?php
                    } else {
                    ?>

                    <select name="tipo_id" id="tipo_id" required data-parsley-required-message="Selecione um tipo" class="form-control">
                        <option value=""></option>
                        <?php
                            $sql = "select * from tipo where id <> 1 order by tipo";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ( $d = $consulta->fetch(PDO::FETCH_OBJ) ) {
                                echo "<option value='{$d->id}'>{$d->tipo}</option>";
                            }

                        ?>
                    </select>


                    <?php 
                    }
                    ?>
                </div>
                <div class="col-12 col-md-8">
                    <label for="email">E-mail do Usuário:</label>
                    <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o e-mail" value="<?=$email?>" data-parsley-type-message="Digite um e-mail válido">
                </div>
                <div class="col-12 col-md-4">
                    <label for="login">Login do Usuário:</label>
                    <input type="text" name="login" id="login" class="form-control" required data-parsley-required-message="Preencha o login" value="<?=$login?>" <?=$l?> >
                </div>
                <div class="col-12 col-md-6">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" <?=$r?> >
                </div>
                <div class="col-12 col-md-6">
                    <label for="redigite">Redigite a Senha:</label>
                    <input type="password" name="redigite" id="redigite" class="form-control" <?=$r?> data-parsley-equalto="#senha">
                </div>
                 <div class="col-12 col-md-8">
                    <label for="foto">Arquivo:</label>
                    <input type="file" name="foto" id="foto" class="form-control" <?=$f?> >
                </div>
        		<div class="col-12 col-md-4">
        			<label for="ativo">Ativo:</label>
        			<select name="ativo" id="ativo" required data-parsley-required-message="Selecione um estado" class="form-control">
        				<option value=""></option>
        				<option value="S">Sim</option>
                        <option value="N">Não</option>
        			</select>
        		</div>
        	</div>

        	<button type="submit" class="cadastro-usuarios__container__form--button float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $("#ativo").val("<?=$ativo?>");
    $("#tipo_id").val("<?=$tipo_id?>");
</script>