<?php
class TutorEmailDTO
{
    private string $nombre;
    private string $apellido;
    private string $email;

    public function __construct(string $nombre, string $apellido, string $email)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
    }

    public function getNombre(): string { return $this->nombre; }
    public function getApellido(): string { return $this->apellido; }
    public function getEmail(): string { return $this->email; }
}
?>