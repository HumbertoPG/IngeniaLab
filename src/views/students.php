<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>

    <link rel="stylesheet" href="../../public/css/styles.css"> 
    <link rel="stylesheet" href="../../public/css/students.css">

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</head>

<body>

    <?php include '../common/sideBar.html' ?>

    <div class="main-content">
        <div class="header">

            <h1>Usuarios</h1>
            <button id="openModalAdd" class="add-button">Agregar Estudiante</button>
            <button type="button" onclick="location.href='/TC2005B_602_01/IngeniaLab/src/views/register.php'">Registrar Administrador o Maestro</button>
            <?php require "../students/create-estudiante.php"; ?>

        </div>

        <div class="search-bar">
            <input type="text" placeholder="Buscar por nombre, correo, etc.">
            <button class="search-button">Buscar</button>
        </div>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT ID, nombre, carrera, correo FROM Alumnos';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<tr data-id='" . htmlspecialchars($row['ID']) . "'>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['carrera']) . "</td>";
                        echo "<td>";
                        echo "<button type='button' class='edit-button' onclick='openEditModal(" . json_encode($row['ID']) . ");'>Editar</button>";
                        echo "<button type='button' class='delete-button' data-id='" . htmlspecialchars($row['ID']) . "'>Eliminar</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay usuarios para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>
    </div>

    <?php require "../students/edit.php"; ?>

    <script src="/TC2005B_602_01/IngeniaLab/public/js/modal.js"></script>
    <script src="/TC2005B_602_01/IngeniaLab/public/js/modal2.js"></script>

</body>

</html>
