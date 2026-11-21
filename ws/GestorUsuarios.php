<?php

require_once "./Conexion.php";
require_once "./models/User.php";

// aqui van todas las consultas a la tabla alumno, asi no se repiten en cada archivo
// ningun metodo hace echo, solo devuelven datos
class GestorUsuarios
{
    public $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    // convierte una fila de la base de datos en un objeto User
    public function filaAUser($fila)
    {
        return new User(
            $fila["id"],
            $fila["nombre"],
            $fila["apellidos"],
            $fila["password"],
            $fila["telefono"],
            $fila["email"],
            $fila["sexo"],
            $fila["fecha_nacimiento"]
        );
    }

    // devuelve un array con todos los usuarios
    public function obtenerTodos()
    {
        $query = $this->pdo->query("SELECT * FROM alumno");
        $filas = $query->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];
        foreach ($filas as $fila) {
            $usuarios[] = $this->filaAUser($fila);
        }

        return $usuarios;
    }

    // devuelve el usuario con ese id, o null si no existe
    public function obtenerPorId($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM alumno WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        $fila = $query->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        return $this->filaAUser($fila);
    }

    // inserta el usuario y lo devuelve ya con el id que le ha dado la base de datos
    public function crear($user)
    {
        $query = $this->pdo->prepare(
            "INSERT INTO alumno (nombre, apellidos, password, telefono, email, sexo, fecha_nacimiento)
            VALUES (:nombre, :apellidos, :password, :telefono, :email, :sexo, :fechaNacimiento)"
        );

        // bindParam necesita variables, por eso los saco primero
        $nombre = $user->getNombre();
        $apellidos = $user->getApellidos();
        $password = $user->getPassword();
        $telefono = $user->getTelefono();
        $email = $user->getEmail();
        $sexo = $user->getSexo();
        $fechaNacimiento = $user->getFechaNacimiento();

        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":apellidos", $apellidos);
        $query->bindParam(":password", $password);
        $query->bindParam(":telefono", $telefono);
        $query->bindParam(":email", $email);
        $query->bindParam(":sexo", $sexo);
        $query->bindParam(":fechaNacimiento", $fechaNacimiento);
        $query->execute();

        return $this->obtenerPorId($this->pdo->lastInsertId());
    }

    // guarda en la base de datos los datos que tenga el objeto ahora mismo
    public function modificar($user)
    {
        $query = $this->pdo->prepare(
            "UPDATE alumno SET nombre = :nombre, apellidos = :apellidos, password = :password,
            telefono = :telefono, email = :email, sexo = :sexo, fecha_nacimiento = :fechaNacimiento
            WHERE id = :id"
        );

        $id = $user->getId();
        $nombre = $user->getNombre();
        $apellidos = $user->getApellidos();
        $password = $user->getPassword();
        $telefono = $user->getTelefono();
        $email = $user->getEmail();
        $sexo = $user->getSexo();
        $fechaNacimiento = $user->getFechaNacimiento();

        $query->bindParam(":id", $id);
        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":apellidos", $apellidos);
        $query->bindParam(":password", $password);
        $query->bindParam(":telefono", $telefono);
        $query->bindParam(":email", $email);
        $query->bindParam(":sexo", $sexo);
        $query->bindParam(":fechaNacimiento", $fechaNacimiento);
        $query->execute();

        return $this->obtenerPorId($id);
    }

    // borra el usuario con ese id
    public function borrar($id)
    {
        $query = $this->pdo->prepare("DELETE FROM alumno WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
    }
}
