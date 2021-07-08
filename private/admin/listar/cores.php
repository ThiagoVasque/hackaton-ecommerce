<div class="listagem-cores">
    <div class="listagem-cores__header">
        <div class="listagem-cores__header--control">
        	<a href="cadastros/cores" class="listagem-cores__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/cores" class="listagem-cores__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="listagem-cores__container">
        <table class="listagem-cores__container--table">
            <thead class="listagem-cores__container--table-h">
                <tr>
                    <td width="20%">ID</td>
                    <td width="50%">Cor</td>
                    <td width="30%">action</td>
                </tr>      
            </thead>
            <tbody  class="listagem-cores__container--table-b">
                <?php
                    //selecionat todas as categorias
                    $sql = "select * from cor order by id";
                    //pdo -> prepare
                    $consulta = $pdo->prepare($sql);
                    //executar o comando sql
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td class="listagem-cores__container--table--destaque"><?=$dados->cor?></td>
                            <td>
                                <a href="cadastros/cores/<?=$dados->id?>" class="listagem-cores__container--table--button">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" class="listagem-cores__container--table--button">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php

                    }

                ?>               
                
            </tbody>
        </table>

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
            location.href='excluir/cores/'+id;
          } 
        })
    }
</script>
