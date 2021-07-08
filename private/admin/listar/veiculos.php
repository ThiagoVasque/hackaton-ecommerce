<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;
?>
<div class="listagem-veiculos">
    <div class="listagem-veiculos__header">
        <div class="listagem-veiculos__header--control">
        	<a href="cadastros/veiculos" class="listagem-veiculos__header--button">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/veiculos" class="listagem-veiculos__header--button">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="listagem-veiculos__container">
        <?php

            $sql = "select v.id, v.modelo, v.valor, v.fotoDestaque, m.marca
                from veiculo v
                inner join marca m on ( m.id = v.marca_id ) 
                order by v.modelo";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                $valor  = number_format( $dados->valor,2, ',' , '.' );
                
                $fotoDestaque = "../veiculos/{$dados->fotoDestaque}p.jpg"; 
                $fotoDestaqueg = "../veiculos/{$dados->fotoDestaque}g.jpg";

                ?>
                <div class="listagem-veiculos__container__card">
                    <div class="listagem-veiculos__container__card--image-container">
                        <a href="<?=$fotoDestaqueg?>" data-lightbox="foto" title="<?=$dados->modelo?>">
                            <img src="<?=$fotoDestaque?>" alt="<?=$dados->modelo?>" width="100px">
                        </a>
                    </div>
                    <h4 class="listagem-veiculos__container__card--title">
                        <?=$dados->modelo?>
                    </h4>
                    <div class="listagem-veiculos__container__card--info">
                        <p class="listagem-veiculos__container__card--info__item">
                            ID: <?=$dados->id?>
                        </p>
                        <p class="listagem-veiculos__container__card--info__item">
                            Marca: <?=$dados->marca?>
                        </p>
                        <p class="listagem-veiculos__container__card--info__item">
                            Preço: <?=$valor?>
                        </p>
                    </div>
                    
                    <div class="listagem-veiculos__container__card--controls">
                        <a href="cadastros/veiculos/<?=$dados->id?>" class="listagem-veiculos__container__card--controls--button">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="javascript:excluir(<?=$dados->id?>)" class="listagem-veiculos__container__card--controls--button">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>

                <?php

            }
        ?>
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
            location.href='excluir/veiculos/'+id;
          } 
        })
    }
</script>