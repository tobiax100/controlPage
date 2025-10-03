<?php 

require_once("../../BLL/FaltaTotalBLL.php");
require_once("../../BLL/InformeAsistenciasBLL.php");


class ReporteAsistencia {

private function tableAsistencia($idAlumno)
{
    $listaFaltas = FaltaTotalBLL::getFaltasTotales($idAlumno);
    $totalAsistencias = 0;
    $totalMediasFaltas = 0;
    $totalFaltas = 0;
    foreach ($listaFaltas as $falta) {
        $totalAsistencias += $falta->getTotalAsitencias();
        $totalMediasFaltas += $falta->getMediasFaltas();
        $totalFaltas += $falta->getTotalFaltas();
    }
    $caption = '
        <div>Asistencias completas: ' . $totalAsistencias . '</div>
        <div>Medias faltas: ' . $totalMediasFaltas . '</div>
        <div>Faltas: ' . $totalFaltas . '</div>
    ';
    if (empty($listaFaltas)) {
        $caption = '<div>No hay datos de faltas.</div>';
    }

    $listaInformes = InformeAsistenciasBLL::informeAsistencia($idAlumno);
    $tablaInforme = '';

    foreach ($listaInformes as $informe) {
        $fechaAsistencia = $informe->getFechaAsistencia()->format('Y-m-d H:i:s');
        $fechaFiltro = $informe->getFechaAsistencia()->format('Y-m-d'); // yyyy-mm-dd
        $valor = ($informe->getValorAsistencia() == 0 ? "Presente" :
                 ($informe->getValorAsistencia() == 0.5 ? "Media Falta" :
                 ($informe->getValorAsistencia() == 1 ? "Falta" : "Desconocido")));
        $tablaInforme .= '
            <tr data-fecha="' . $fechaFiltro . '">
                <td class="col-fecha">' . $fechaAsistencia . '</td>
                <td>' . htmlspecialchars($informe->getTipoClase()) . '</td>
                <td class="valor-asistencia">' . $valor . '</td>
            </tr>';
    }

    return '
    <div class="table-responsive" style="border:1px solid #ddd; padding:10px;">
        <table id="InformeIndividual' . $idAlumno . '" class="table table-striped table-bordered table-hover align-middle h-100">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="col-fecha">Fecha de Asistencia</th>
                    <th scope="col">Tipo de Clase</th>
                    <th scope="col">Valor de asistencia</th>
                </tr>
            </thead>
            <tbody>
                ' . $tablaInforme . '
            </tbody>
            <caption style="caption-side: top; font-weight:bold;" class="d-flex justify-content-between">
                ' . $caption . '
            </caption>
        </table>
    </div>';
}




}



?>