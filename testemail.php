<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Mail/mail.php';
require_once __DIR__ . '/Entidades/AlumnoEmailDTO.php';
require_once __DIR__ . '/Entidades/TutorEmailDTO.php';


$alumnoTest = new AlumnoEmailDTO('Juan', 'Pérez', '40123456');
$tutorTest = new TutorEmailDTO('María', 'Pérez', 'tobiascr28@gmail.com');

echo "🚀 Iniciando prueba de envío de email...\n";
echo "📧 Enviando a: tobiascr28@gmail.com\n"; 

try {
    
    MailProcessor::procesarAlumnosConInasistencias($alumnoTest, $tutorTest);
    echo "✅ Email enviado exitosamente!\n";
    echo "📨 Revisa tu bandeja de entrada y carpeta de spam.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>