<div id="editModal" class="modal">
    <div class="modalAdd-content">
        <span class="close">&times;</span>
        <h2>Editar Máquina</h2>
        <form id="editMachineForm" method="POST" action="../machines/update.php">
            <input type="hidden" name="ID" id="editID">
            <div class="form-group">
                <label for="editNombre">Nombre:</label>
                <input type="text" id="editNombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="editNumSerie">Número de Serie:</label>
                <input type="text" id="editNumSerie" name="numSerie" required>
            </div>
            <div class="form-group">
                <label for="editTipoMaquina">Tipo de Máquina:</label>
                <select id="editTipoMaquina" name="tipoMaquina" required>
                    <?php
                        require_once $_SERVER['DOCUMENT_ROOT'].'/IngeniaLab/config/database.php';
                        $pdo = Database::connect();
                        $query = 'SELECT * FROM Tipos_maquina';
                        foreach ($pdo->query($query) as $row) {
                            echo "<option value='" . $row['idType'] . "'>" . $row['tipo'] . "</option>";
                        }
                        Database::disconnect();
                    ?>
                </select>
            </div>
            <button type="submit" class="save-button">Guardar Cambios</button>
        </form>
    </div>
</div>


<script>

function editModal(machineId) {
    // Hacer una petición AJAX para obtener los detalles de la máquina
    $.ajax({
        url: '../machines/get_machine.php', // Ruta al archivo PHP que devolverá los detalles de la máquina
        type: 'GET',
        data: { id: machineId },
        success: function(response) {
            var machine = JSON.parse(response);
            $('#editID').val(machine.ID);
            $('#editNombre').val(machine.nombre);
            $('#editNumSerie').val(machine.numSerie);
            $('#editTipoMaquina').val(machine.tipoMaquina);
            $('#editModal').css('display', 'block');
        },
        error: function(error) {
            console.error('Error obteniendo los detalles de la máquina:', error);
        }
    });
}

</script>
