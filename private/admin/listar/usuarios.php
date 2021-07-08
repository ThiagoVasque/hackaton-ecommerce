<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;
?>
<div class="listagem-usuarios">
    <div class="listagem-usuarios__header">
        <div class="listagem-usuarios__header--control">
        	<a href="cadastros/usuarios" class="listagem-usuarios__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/usuarios" class="listagem-usuarios__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="listagem-usuarios__container">
        <table class="listagem-usuarios__container--table">
            <thead class="listagem-usuarios__container--table-h">
                <tr>
                    <td width="10%">ID</td>
                    <td width="50%">Nome do Usuário</td>
                    <td width="20%">Login do Usuário</td>
                    <td width="10%">Ativo</td>
                    <td width="10%">action</td>
                </tr>      
            </thead>
            <tbody  class="listagem-usuarios__container--table-b">
                <?php
                    //selecionat todas as categorias
                    $sql = "select * from usuario order by nome";
                    //pdo -> prepare
                    $consulta = $pdo->prepare($sql);
                    //executar o comando sql
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td class="listagem-usuarios__container--table--destaque"><?=$dados->nome?></td>
                            <td><?=$dados->login?></td>
                            <td><?=$dados->ativo?></td>
                            <td>
                                <a href="cadastros/usuarios/<?=$dados->id?>" class="listagem-usuarios__container--table--button">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php

                    }

                ?>               
                
            </tbody>
        </table>
    </div>
</div>


