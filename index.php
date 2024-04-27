<!DOCTYPE html>

<html>

  <head>
    <title>Sistema de laboratorios </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styles.css">
  </head>

  <body>
    <table>
      <tr>
        <td>
          <img src="images/ITESM Logo.png" width="100" alt="ITESM Logo">
        </td>
        <td>
          <h1>Laboratorio de Ingenieria</h1>
        </td>
      </tr>
    </table>
    <table align="center">
      <tr>
        <td>
          <img src="images/robot.jpg" width="100px">
        </td>
      </tr>
    </table>

      <form action="index.php" method="post">

          <table align="center">
              <tr>
                  <td align="center">
                      <label for="idUsuario">Usuario:</label>
                      <input type="text" id="idUsuario" name="idUsuario" required>
                  </td>
              </tr>
              <tr>
                  <td align="center">
                      <label for="passwordUser">Contraseña:</label>
                      <input type="password" id="passwordUser" name="passwordUser" required>
                  </td>
              </tr>
              <tr>
                  <td align="center">
                      <button style="padding: 10px 20px; font-size: 16px">Log in</button>
                      <input type="submit" value="Log in" class="button">
                  </td>
              </tr>
                  <td align="center">
                      <button style="padding: 10px 20px; font-size: 16px">¿Olvido su contrasena?</button>
                  </td>
              </tr>
          </table>
      
      </form>


    <table align="right">
      <tr>
        <td>
          <svg viewBox="0 0 512 512" width="50" title="info-circle"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z" />
          </svg>
        </td>
      </tr>
    </table>
  </body>

</html>

<?php


include 'database.php';

$pdo = Database::connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['idUsuario']) && !empty($_POST['passwordUser'])) {

        $idUser = $_POST['idUsuario'];
        $passwordUser = $_POST['passwordUser'];

        $sql = 'SELECT * FROM user WHERE idUser = ? and passwordUser = ?';
        $stmt = $pdo->prepare($sql);

        $stmt->execute(array($idUser, $passwordUser));
        $result = $stmt->fetchAll();

        if (count($result) > 0) {

            echo '<p>Exitoso</p>';

        }
        else {

            echo '<p>Error</p>';

        }
    
    }

Database::disconnect();
?>