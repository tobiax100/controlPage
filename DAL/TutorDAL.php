<?php
require_once(__DIR__."../../Entidades/Tutor.php");
require_once("AbstractMapper.php");

class TutorDAL extends AbstractMapper
{

    public function InsertarTutor($tutor)
    {
        $consulta= "INSERT INTO tutores (Nombre,Apellido,Dni,Email,Telefono) VALUES
        ('".$tutor->getNombre()."',
        '".$tutor->getApellido()."',
        '".$tutor->getDni()."',
        '".$tutor->getEmail()."',
        '".$tutor->getTelefono()."'
        )";
        $this->setConsulta($consulta);
        $id= $this->Execute();
        return $id;
    }
    // public function findTutorByIdAlumno(int $idAlumno): ?Tutor
    // {
    //     // $consulta = "SELECT tutores.idTutores, tutores.Nombre, tutores.Apellido, tutores.Dni,tutores.Email,tutores.Telefono FROM  alumnos a INNER JOIN tutores
    //     // ";
    //     $consulta = "SELECT t.idTutores, t.Nombre, t.Apellido, t.Dni, t.Email, t.Telefono
    //              FROM alumnos a
    //              INNER JOIN tutores t ON a.idTutores = t.idTutores
    //              WHERE a.idAlumnos = :idAlumno";

    // $stmt = $this->db->prepare($consulta);
    // $stmt->bindParam(':idAlumno', $idAlumno, PDO::PARAM_INT);
    // $stmt->execute();
    // $columna = $stmt->fetch(PDO::FETCH_ASSOC);

    // if ($columna) {
    //     return $this->doLoad($columna);
    // }
    // return null;
    // }


     public function findTutorByIdAlumno($idAlumno)
    {
        $consulta = "SELECT t.* 
                     FROM alumnos a
                     INNER JOIN tutores t ON a.idTutores = t.idTutores
                     WHERE a.idAlumnos = '$idAlumno'";

        $this->setConsulta($consulta);
        $resultado = $this->Find();


        if($resultado == null || (is_object($resultado) && empty((array)$resultado))){
            return null;
        }
         //id,nombre,apellido,dni, email
         $tutor = new Tutor(
        $resultado->idTutores ?? 0,           
        $resultado->nombre ?? '',            
        $resultado->apellido ?? '',          
        $resultado->dni ?? '',              
        $resultado->email ?? '',             
        $resultado->telefono ?? ''           
    );
        return $tutor;
       
    }

    public function findAllTutor()
    {
        
        $consulta= "SELECT * FROM tutores";
        $this->setConsulta($consulta);
        $resultado= $this->FindAll();
        return $resultado;
    }


    public function UpdateTutor($tutor)
    {
        $consulta="UPDATE tutores 
        SET Nombre='" . $tutor->getNombre() . "',
            Apellido='".$tutor->getApellido()."',
            Dni='".$tutor->getDni()."',
            Email='".$tutor->getEmail()."',
            Telefono='".$tutor->getTelefono()."'
            WHERE idTutores='" . $tutor->getId() . "';        
        ";
        $this->setConsulta($consulta);
        $id= $this->Execute();
        return $id;
    }



    public function doLoad($columna)
    {
        $id= (int) $columna["idTutores"];
        $nombre= (string) $columna["Nombre"];
        $apellido= (string) $columna["Apellido"];
        $dni= (string) $columna["Dni"];
        $email= (string) $columna["Email"];
        $telefono= (string) $columna["Telefono"];
        
        $tutor= new Tutor(
            $id,
            $nombre,
            $apellido,
            $dni,
            $email,
            $telefono
        );

        return $tutor;

    }
}