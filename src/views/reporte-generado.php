<!DOCTYPE html>
<html lang="es">
<!-- /TC2005B_602_01 -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Reporte Generado</title>
  <link rel="stylesheet" href="/IngeniaLab/public/css/genReporte.css" />
  <link rel="stylesheet" href="/IngeniaLab/public/css/styleNav.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
  
  <?php include '../common/sideBar.html' ?>

  <div class="heading-admin">
    <div style="width: 30%;">
      <p class="header">Reporte Generado</p>
    </div>
</div>

<div class="main-content">

  <section class="container" id="report-content">
    <header>Información del Reporte</header>
    <div class="report-content">
      <h2>Detalles del Usuario</h2>
      <p>Nombre Completo: <?php echo htmlspecialchars($_POST['nombre_completo']); ?></p>
      <p>Matrícula: <?php echo htmlspecialchars($_POST['matricula']); ?></p>
      <p>Correo: <?php echo htmlspecialchars($_POST['correo']); ?></p>

      <?php if ($_POST['include_teachers'] == 'yes'): ?>
        <h2>Información de Profesores</h2>
        <p>(Aquí se incluirá información de uso de profesores)</p>
      <?php endif; ?>

      <?php if ($_POST['include_admins'] == 'yes'): ?>
        <h2>Información de Administradores</h2>
        <p>(Aquí se incluirá información de uso de administradores)</p>
      <?php endif; ?>

      <?php if ($_POST['include_graphs'] == 'yes'): ?>
        <h2>Gráfica de Uso Total de Máquinas</h2>
        <canvas id="usoTotalChart"></canvas>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
        $pdo = Database::connect();
        $sql = 'SELECT nombre, tiempoUso FROM Maquinas';
        $result = $pdo->query($sql);
        $maquinas = [];
        $tiempos = [];
        if ($result->rowCount() > 0) {
          foreach ($result as $row) {
            $maquinas[] = $row['nombre'];
            $tiempos[] = $row['tiempoUso'];
          }
        }
        Database::disconnect();
        ?>
        <script>
          const ctx = document.getElementById('usoTotalChart').getContext('2d');
          const usoTotalChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($maquinas); ?>,
              datasets: [{
                label: 'Tiempo de Uso Total (minutos)',
                data: <?php echo json_encode($tiempos); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      <?php endif; ?>
    </div>
  </section>
  <button class="btn" id="download-btn"><i class="fa fa-download"></i> Descargar</button>
</div>

<script>
    document.getElementById('download-btn').addEventListener('click', function () {
      const { jsPDF } = window.jspdf;
      const reportContent = document.getElementById('report-content');

      html2canvas(reportContent).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('reporte.pdf');
      });
    });
</script>

</body>

</html>
