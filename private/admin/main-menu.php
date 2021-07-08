<?php
    if ( ! isset ( $_SESSION['admin']['id'] ) ) exit;
?>
<!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <div class="main-menu">
                
                    <div class="main-menu__item left">
                        <img class="main-menu__item--img" src="<?="../arquivos/".$_SESSION['admin']['foto']."p.jpg"?>">
                    </div>
                    <div class="main-menu__item">
                        <a class="main-menu__item--link" href="./listar/veiculos">
                            Veiculos
                        </a>
                    </div>
                    <div class="main-menu__item">
                        <a class="main-menu__item--link" href="./listar/marcas">
                            Marcas
                        </a>
                    </div>
                    <div class="main-menu__item">
                        <a class="main-menu__item--link" href="./listar/usuarios">
                            Usuarios
                        </a>
                    </div>
                    <div class="main-menu__item">
                        <a class="main-menu__item--link" href="./listar/cores">
                            Cores
                        </a>
                    </div>

                    <!--Deixar apenas ICONE-->
                    <div class="main-menu__item">
                        <a class="main-menu__item--link"href="sair.php">
                            <i class="fas fa-sign-out-alt"></i>
                            Sair
                        </a>
                    </div>
                </div>
                

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">