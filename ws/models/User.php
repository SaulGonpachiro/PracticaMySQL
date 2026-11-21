<?php

require_once "./interfaces/IToJson.php";

class User implements IToJson
{
    // una propiedad por cada columna de la tabla alumno, van sin tipo porque pueden venir a null
    public $id;
    public string $nombre;
    public string $apellidos;
    public string $password;
    public $telefono;
    public $email;
    public $sexo;
    public string $fechaNacimiento;

    public function __construct(
        $id,
        string $nombre,
        string $apellidos,
        string $password,
        $telefono,
        $email,
        $sexo,
        string $fechaNacimiento
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->fechaNacimiento = $fechaNacimiento;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function setFechaNacimiento(string $fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    // devuelve el usuario como array para meterlo en el "data" de la respuesta
    // la contraseña no la meto para no mandarla en el JSON
    public function toArray()
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "apellidos" => $this->apellidos,
            "telefono" => $this->telefono,
            "email" => $this->email,
            "sexo" => $this->sexo,
            "fecha_nacimiento" => $this->fechaNacimiento
        ];
    }

    // el metodo de la interfaz, el mismo usuario pero como string JSON
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
