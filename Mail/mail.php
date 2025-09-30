<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '.././vendor/autoload.php';

class MailProcessor
{

    public static function procesarAlumnosConInasistencias( AlumnoEmailDTO $alumno, TutorEmailDTO $tutor)
    {
        $emailtutor = $tutor->getEmail();
        $alumnoNombre = $alumno->getNombre().' '.$alumno->getApellido();
        $nombreTutor = $tutor->getNombre(). ' '.$tutor->getApellido(); 
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'tobiasagustinsanchez01@gmail.com'; 
            $mail->Password = 'prau gukr bicr znys'; 
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Configuración del correo
            $mail->setFrom('tobiasagustinsanchez01@gmail.com'); 
            $mail->addAddress($emailtutor);
            $body = file_get_contents(__DIR__ . '/contenido.html');
            $body = str_replace("{BIENVENIDA}", "AVISO DE INASISTENCIAS ACULMULADAS", $body);
            $body = str_replace("%NOMBRE%", $nombreTutor,$body);
            $body = str_replace("{TEXTO}", "El alumno ".$alumnoNombre.' estuvo faltantando por favor acerquese a la  institucion o mande una nota por el cuaderno de comunicados', $body);

            $mail->isHTML(true);
            $mail->Subject = 'Notificación de Inasistencias'; 
            $mail->AltBody = 'El alumno 3 tiene inasistencias acumuladas.'; 
            $mail->MsgHTML($body);

            $mail->send();
            echo 'El mensaje ha sido enviado con éxito.';
        } catch (Exception $e) {
            echo 'Error al enviar el mensaje: ', $mail->ErrorInfo;
        }
    }
}
?>
