<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once("../DAL/MailDAL.php");
require_once("../Mail/mail.php");

class MailBLL
{
    
    public static function getFaltas($alumnoId, $cursoId)
{
    try {
        $mailDAL = new MailDAL();
        $resultado = $mailDAL->getFaltasAlumnos($alumnoId, $cursoId);

        if ($resultado && $resultado->TotalFaltas > 3) {
            // crea losdto con la info necesaria
            $alumnoDTO = new AlumnoEmailDTO(
                $resultado->Nombre,
                $resultado->Apellido,
                $resultado->Dni
            );

            $tutorDTO = new TutorEmailDTO(
                $resultado->TutorNombre,
                $resultado->TutorApellido,
                $resultado->TutorEmail
            );

            //funcion para enviar los mail
            MailProcessor::procesarAlumnosConInasistencias($alumnoDTO, $tutorDTO);
            return true;
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("Error enviando email: " . $e->getMessage());
        return false;
    }
}
}
?>
