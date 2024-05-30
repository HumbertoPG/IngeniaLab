<div id="addMachineModal" class="modal">

    <div class="modalAdd-content">
        <span class="close" data-modal="addMachineModal">&times;</span>
        <h2>Agregar nueva máquina</h2>
        <form id="addMachineForm">
            <div class="form-group">
                <label for="numSerie">Número de serie: </label>
                <input type="text" id="numSerie" name="numSerie" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label class="control-label">Tipo maquina</label>
                <select name="tipo_maquina" id="tipo_maquina">
                    <option value="">Selecciona tipo de maquinaria</option>
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
            <div class="form-buttons">
                <button type="submit" class="btn-accept">Aceptar</button>
                <button type="button" class="cancel-btn" data-modal="addMachineModal">Cerrar</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
    
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById('addMachineModal');
    var closeModalBtns = document.querySelectorAll('.close, .cancel-btn');
    var form = document.getElementById('addMachineForm');
    var messageDiv = document.getElementById('message');

    closeModalBtns.forEach(function(btn) {
        btn.onclick = function() {
            modal.style.display = 'none';
            window.location.reload();  // Recargar la página al cerrar la ventana modal
        }
    });

    form.onsubmit = function(event) {
        event.preventDefault();

        var formData = new FormData(form);

        fetch('/IngeniaLab/src/machines/add_machine.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.innerHTML = '<p style="color:green;">' + data.message + '</p>';
                form.reset();
                setTimeout(function() {
                    modal.style.display = 'none';
                    window.location.reload();  // Recargar la página después de mostrar el mensaje de éxito
                }, 1500);  // Espera 1.5 segundos antes de cerrar la ventana modal y recargar la página
            } else {
                messageDiv.innerHTML = '<p style="color:red;">' + data.message + '</p>';
            }
        })
        .catch(error => {
            messageDiv.innerHTML = '<p style="color:red;">Error al procesar la solicitud.</p>';
        });
    };
});
</script>
