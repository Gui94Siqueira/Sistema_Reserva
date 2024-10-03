<?php

session_start();

include_once "Backend/config/Database.php";
include_once "Backend/dao/EventoDAO.php";
include_once "Backend/entity/Evento.php";

$eventoDAO = new EventoDAO();

$eventos = $eventoDAO->getAll();




?>

<?php
require_once "Frontend/template/header.php";
?>




<div class="container">

    <h1 class="my-4">Lista de Eventos</h1>


    <div class="d-flex justify-content-between">
        <a href="eventos_add.php" class="btn btn-primary">Adicionar Evento</a>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <br>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($eventos as $evento) : ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Titulo: <?php echo $evento->getTitulo(); ?></h5>
                        <P class="card-title">Sigla: <?php echo $evento->getSigla(); ?></P>
                        <p class="card-text">Oferta: <?php echo $evento->getOferta(); ?></p>
                        <a href="eventos_reservas.php?evento_id=<?php echo $evento->getId(); ?>" class="btn btn-primary">Editar <i class="fa-solid fa-pen"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
    let search = document.getElementById("")
</script>

<?php
require_once "Frontend/template/footer.php";
?>

</html>