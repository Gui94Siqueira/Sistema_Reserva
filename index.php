<?php
session_start();

require_once "Backend/config/Database.php";
require_once "Backend/dao/ReservaDAO.php";
require_once "Backend/dao/SalaDAO.php";


$reservaDAO = new ReservaDAO();
$reservas = $reservaDAO->listarSalasPorPeriodo("2024-01-01", "2025-01-01", "19:00", "22:00", "1, 2, 3");


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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save']) && isset($_POST['dias'])) {
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];
        $horario_inicio = $_POST['horario_inicio'];
        $horario_fim = $_POST['horario_fim'];
        $dias_semana = implode(", ", $_POST['dias']);

        $reservas = $reservaDAO->listarSalasPorPeriodo($data_inicio, $data_fim, $horario_inicio, $horario_fim, $dias_semana);
    } else {
        echo "<h1>Não Existem salas reservadas neste periodo.</h1>";
    }
}


?>

<?php
require_once "Frontend/template/header.php";
?>
<br>



<div class="container">
<button style="margin-top: 2rem; margin-bottom: 2rem;" type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#myModal">
            Filtrar
        </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Consultar Salas Disponiveis</h3>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="data_inicio">Data Inicio: </label>
                                    <input type="date" class="form-control" name="data_inicio" require>
                                </div>
                                <div class="form-group">
                                    <label for="data_fim">Data Fim: </label>
                                    <input type="date" class="form-control" name="data_fim" require>
                                </div>

                                <div class="form-group">
                                    <label for="horario_inicio">Horario Inicio: </label>
                                    <input type="time" class="form-control" name="horario_inicio" require>
                                </div>
                                <div class="form-group">
                                    <label for="horario_fim">Horario Fim: </label>
                                    <input type="time" class="form-control" name="horario_fim" require>
                                </div>

                                <h5>Dias da semana:</h5>
                                <div style="display: flex;">
                                    <label for="seg">Seg:</label>
                                    <input type="checkbox" class="form-control" id="seg" name="dias[]" value="1">
                                    <label for="ter">Ter:</label>
                                    <input type="checkbox" class="form-control" id="ter" name="dias[]" value="2">
                                    <label for="qua">Qua:</label>
                                    <input type="checkbox" class="form-control" id="qua" name="dias[]" value="3">
                                    <label for="qui">Qui:</label>
                                    <input type="checkbox" class="form-control" id="qui" name="dias[]" value="4">
                                    <label for="sex">Sex:</label>
                                    <input type="checkbox" class="form-control" id="sex" name="dias[]" value="5">
                                    <label for="sab">Sab:</label>
                                    <input type="checkbox" class="form-control" id="sab" name="dias[]" value="6">
                                    <label for="dom">Dom:</label>
                                    <input type="checkbox" class="form-control" id="dom" name="dias[]" value="7">
                                </div>

                            </div>
                            <br>
                            <button type="submit" name="save" class="btn btn-success">Filtar</button>
                        </div>
                </div>
                </form>
            </div>

        </div>
    </div>


    <div class="table-responsive">
        <table style="background-color: #fff;" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Numero</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Data Inicio</th>
                    <th scope="col">Data fim</th>
                    <th scope="col">Horario Inicio</th>
                    <th scope="col">Horario fim</th>
                    <th scope="col">Docente</th>
                    <th scope="col">Dias semana</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva) : ?>
                    <tr>
                        <td><?php echo $reserva['numero']; ?></td>
                        <td><?php echo $reserva['titulo']; ?></td>
                        <td><?php echo $reserva['data_inicio']; ?></td>
                        <td><?php echo $reserva['data_fim']; ?></td>
                        <td><?php echo $reserva['horario_inicio']; ?></td>
                        <td><?php echo $reserva['horario_fim']; ?></td>
                        <td><?php echo $reserva['docente']; ?></td>
                        <td><?php echo $reserva['dias_semana']; ?></td>
                    <?php endforeach; ?>
                    </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
<?php
require_once "Frontend/template/footer.php";
?>

</html>