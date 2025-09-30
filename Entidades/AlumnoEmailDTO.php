<?php
class AlumnoEmailDTO
{
    private string $nombre;
    private string $apellido;
    private string $dni;

    public function __construct(string $nombre, string $apellido, string $dni)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
    }

    public function getNombre(): string { return $this->nombre; }
    public function getApellido(): string { return $this->apellido; }
    public function getDni(): string { return $this->dni; }
}
?>