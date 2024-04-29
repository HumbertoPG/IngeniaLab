<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detalles de la Máquina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/lab-admin-equipos.css">
</head>
<body>
    <div class="details-form-container">
        <h2>Detalles de la máquina</h2>
        <?php
        include 'database.php';
        $pdo = Database::connect();

        if (!empty($_GET['id'])) {
            $id = $_GET['id'];

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM CRUD_Maquinas WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                echo "<div class='form-group'><label>ID:</label> <span>" . htmlspecialchars($data['id']) . "</span></div>";
                echo "<div class='form-group'><label>Nombre:</label> <span>" . htmlspecialchars($data['nombre']) . "</span></div>";
                echo "<div class='form-group'><label>Estado:</label> <span>" . ($data['estado'] == 1 ? 'Activo' : 'Inactivo') . "</span></div>";
                echo "<div class='form-group'><label>Fecha de Registro:</label> <span>" . htmlspecialchars($data['fechaRegistro']) . "</span></div>";
                echo "<div class='form-group'><label>Tiempo de Uso Total:</label> <span>" . htmlspecialchars($data['tiempoUsoTotal']) . "</span></div>";
            } else {
                echo "<p>No se encontró información para la máquina con ID $id.</p>";
            }
        } else {
            echo "<p>ID no proporcionado.</p>";
        }

        Database::disconnect();
        ?>
        <button onclick="document.getElementById('modal').close();">Cerrar</button>
    </div>
</body>
</html>
