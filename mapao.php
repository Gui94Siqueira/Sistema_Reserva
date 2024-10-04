<?php
session_start(); // Inicia uma sessão na página
require_once "Backend/config/Database.php";
require_once "Backend/dao/ReservaDAO.php";
require_once "Backend/dao/tipoDAO.php";
require_once "Backend/dao/EventoDAO.php";
require_once "Backend/dao/SalaDAO.php";

date_default_timezone_set('America/Sao_Paulo');

$data = date("y-m-d"); // Data no formato Y-m-d
$diaSemana = date('l', strtotime($data)); // 'l' retorna o nome completo do dia da semana

$dia_semana_numero = 0;

function obterNumeroDiaSemana($data)
{
    // Obter o nome completo do dia da semana a partir da data
    $diaSemana = date('l', strtotime($data)); // 'l' retorna o nome completo do dia da semana

    // Inicializar a variável que armazenará o número do dia da semana
    $dia_semana_numero = 0;

    // Usar switch para mapear o nome do dia da semana para seu número correspondente
    switch ($diaSemana) {
        case "Monday":
            $dia_semana_numero = 1;
            break;
        case "Tuesday":
            $dia_semana_numero = 2;
            break;
        case "Wednesday":
            $dia_semana_numero = 3;
            break;
        case "Thursday":
            $dia_semana_numero = 4;
            break;
        case "Friday":
            $dia_semana_numero = 5;
            break;
        case "Saturday":
            $dia_semana_numero = 6;
            break;
        case "Sunday":
            $dia_semana_numero = 7;
            break;
    }

    return $dia_semana_numero;
}

// echo $dia_semana_numero;

$mapaoDAO = new ReservaDAO();
$dia_atual = date("y-m-d");
$dia = obterNumeroDiaSemana($dia_atual);
$mapao = $mapaoDAO->listarSalas(date("y-m-d"), date("H:i:s"), date("H:i:s"), $dia);
//echo date("H:i:s");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {

        $data = $_POST['data'];
        $dia_semana = obterNumeroDiaSemana($data);
        $horario_inicio = $_POST['horario_inicio'];
        $horario_fim = $_POST['horario_fim'];

        $mapao = $mapaoDAO->listarSalas($data, $horario_inicio, $horario_fim, $dia_semana);
    } else {
        //$mapao = $mapaoDAO->listarSalas("2024-06-27", "00:00:00", "22:00:00");
    }
}

?>
<?php
require_once "Frontend/template/header.php";
?>


<body>
    <div class="container">
        <button style="margin-top: 2rem; margin-bottom: 2rem;" type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#myModal">
            Filtrar
        </button>

        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="mapao.php" method="post">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="data">Data: </label>
                                        <input type="date" class="form-control" name="data" require>
                                    </div>

                                    <div class="form-group">
                                        <label for="horario_inicio">Horario Inicio: </label>
                                        <input type="time" class="form-control" name="horario_inicio" require>

                                    </div>
                                    <label for="horario_fim">Horario Fim: </label>
                                    <input type="time" class="form-control" name="horario_fim" require>
                                    <br>
                                    <button type="submit" name="save" class="btn btn-success">Filtar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <h1>Mapa de salas</h1>
        <div class="table-responsive">
            <table style="background-color: #fff;" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Sala</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Inicio</th>
                        <th scope="col">Fim</th>
                        <th scope="col">Docente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mapao as $mapa) : ?>
                        <tr >
                            <th scope="row" ><?php echo $mapa['numero'] ?></th>
                            <td><?php echo $mapa['titulo'] ?></td>
                            <td><?php echo $mapa['horario_inicio'] ?></td>
                            <td><?php echo $mapa['horario_fim'] ?></td>
                            <td><?php echo $mapa['docente'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>




    </div>

    <?php
    require_once "Frontend/template/footer.php";
    ?>

    </html>