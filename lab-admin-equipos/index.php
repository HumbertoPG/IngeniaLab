<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Equipos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/lab-admin-equipos.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div class="main-content">

        <h1>Administrar Equipos</h1>

        <!-- <a href="create.php" class='add-button btn'>Agregar equipo</a> -->
        <button onclick="window.modal.showModal();" class='add-button btn'>Agregar equipo</button>

        <dialog id="modal">

            <?php

                include 'create.php';

            ?>

        </dialog>

        <table class="equipment-table">
            <thead>
                <tr>
                    <th>Nombre Máquina</th>
                    <th>Estado Actual</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // require 'database.php';

                $pdo = Database::connect();
                $sql = 'SELECT * FROM CRUD_Maquinas';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        if ($row['estado'] == 0) {
                            echo '<td> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"  viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                          </svg></td>';
                        }
                        else if ($row['estado'] == 1) {

                            echo '<td> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green"  viewBox="0 0 16 16">
                                    <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                                    </svg>
                                </td>';

                        }
                        echo "<td>";
                        echo "<form method='POST' action=''>";
                        echo "<input type='submit' class='details-button' value='Detalles'>";
                        echo "<input type='submit' class='edit-button' value='Editar'>";
                        echo '<a class="delete-button" href="delete.php?id='.$row['id'].'">Eliminar</a>';
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";

                    }
                }
                else {
                    echo "<tr><td colspan='3'>No hay equipos para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function(){
            $("form").on("submit", function(event){
                event.preventDefault();

                $.ajax({
                    url: "insert.php",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(response){
                        // Aquí puedes manejar la respuesta del servidor
                        window.modal.close();
                        // alert(response);

                        $.ajax({
                            url: "get_machines.php",
                            type: "get",
                            dataType: "json",
                            success: function(machines){
                                // Actualizar la tabla con la lista de máquinas
                                var tbody = $(".equipment-table tbody");
                                tbody.empty();
                                machines.forEach(function(machine){
                                    var row = "<tr><td>" + machine.nombre + "</td><td>" + machine.estado + "</td><td>";
                                    row += "<form method='POST' action=''>";
                                    row += "<input type='submit' class='details-button' value='Detalles'>";
                                    row += "<input type='submit' class='edit-button' value='Editar'>";
                                    row += '<a class="delete-button" href="delete.php?id='+machine.id+'">Eliminar</a>';
                                    row += "</form></td></tr>";
                                    tbody.append(row);
                                });
                            }
                        });

                    }
                });
            });
        });

        function updateTable() {

            console.log('Updating table...')
            $.ajax({
                url: "get_machines.php",
                type: "get",
                dataType: "json",
                success: function(machines){
                    var tbody = $(".equipment-table tbody");
                    tbody.empty();
                    machines.forEach(function(machine){
                        var row = "<tr><td>" + machine.nombre + "</td><td>" + machine.estado + "</td><td>";
                        row += "<form method='POST' action=''>";
                        row += "<input type='submit' class='details-button' value='Detalles'>";
                        row += "<input type='submit' class='edit-button' value='Editar'>";
                        row += '<a class="delete-button" href="delete.php?id='+machine.id+'">Eliminar</a>';
                        row += "</form></td></tr>";
                        tbody.append(row);
                    });
                }
            });
        }
    </script>

</body>
</html>
