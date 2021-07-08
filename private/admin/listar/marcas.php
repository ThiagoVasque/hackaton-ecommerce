<div class="listagem-marcas">
    <div class="listagem-marcas__header">
        <div class="listagem-marcas__header--control">
        	<a href="cadastros/marcas" class="listagem-marcas__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/marcas" class="listagem-marcas__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="listagem-marcas__container">
        <table class="listagem-marcas__container--table">
            <thead class="listagem-marcas__container--table-h">
                <tr>
                    <td width="33%">ID</td>
                    <td width="33%">Marca</td>
                    <td width="33%">action</td>
                </tr>      
            </thead>
            <tbody  class="listagem-marcas__container--table-b">
                <?php
                    //selecionat todas as categorias
                    $sql = "select * from marca order by id";
                    //pdo -> prepare
                    $consulta = $pdo->prepare($sql);
                    //executar o comando sql
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td class="listagem-marcas__container--table--destaque"><?=$dados->marca?></td>
                            <td>
                                <a href="cadastros/marcas/<?=$dados->id?>" class="listagem-marcas__container--table--button">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" class="listagem-marcas__container--table--button">
                                    <i class="fas fa-trash"></i>
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
<script type="text/javascript">
    function excluir(id) {

        Swal.fire({
          title: 'Deseja realmente excluir este registro?',
          showCancelButton: true,
          confirmButtonText: `Sim`,
          cancelButtonText: `Não`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            //enviar para excluir
            location.href='excluir/marcas/'+id;
          } 
        })
    }
</script>
