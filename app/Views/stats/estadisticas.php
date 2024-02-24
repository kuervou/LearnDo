<!-- Incluimos el head -->
<?= view('template/head') ?>



<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container py-5">
        <div class="glassmorphism p-4">
            <h1 class="text-center mb-4">Estadísticas de Ingresos y Rendimiento</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Personas que lo compraron</th>
                            <th>Personas que lo tienen completado</th>
                            <th>Compras con PayPal</th>
                            <th>Compras con Créditos</th>
                            <th>Dinero generado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso) { ?>
                            <tr>
                                <td><?php echo $curso['nombre']; ?></td>
                                <td><?php echo $curso['ventasTotales']; ?></td>
                                <td><?php echo $curso['cantAprobados']; ?></td>
                                <td><?php echo $curso['paypal']; ?></td>
                                <td><?php echo $curso['creditos']; ?></td>
                                <td><?php echo $curso['recaudacion']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="glassmorphism p-4 my-4">
            <button class="btn btn-primary mb-3" id="resetChart"><span class="material-symbols-outlined">
                    restart_alt
                </span></button>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        // Inicializa el gráfico
        let ctx = document.getElementById('barChart').getContext('2d');
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [], // Nombre de los cursos
                datasets: [{
                    label: 'Personas que lo compraron',
                    data: [], // Personas que compraron cada curso
                    backgroundColor: 'rgba(20, 126, 158, 0.5)',
                    borderColor: 'rgba(15, 98, 115, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Carga los datos iniciales en el gráfico
        $('tbody tr').each(function() {
            let data = $(this).find('td').map(function() {
                return $(this).text();
            }).get();

            chart.data.labels.push(data[0]); // agrega el nombre del curso
            chart.data.datasets[0].data.push(data[1]); // agrega la cantidad de personas que compraron el curso
        });

        chart.update(); // actualiza el gráfico para mostrar los datos iniciales

        // Evento de clic en las filas de la tabla
        $('tbody tr').on('click', function() {
            let data = $(this).find('td').map(function() {
                return $(this).text();
            }).get();

            // Actualiza el gráfico
            chart.data.labels = ['Personas que lo compraron', 'Personas que lo tienen completado', 'Compras con PayPal', 'Compras con Créditos', 'Dinero generado'];
            chart.data.datasets = [{
                label: data[0], // nombre del curso
                data: data.slice(1), // datos del curso
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 75, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 75, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 1
            }];

            chart.update();
        });

   
    
    // Evento de clic en el botón "Resetear Gráfico"
$('#resetChart').on('click', function() {
    //refresca la pagina
    location.reload();
});

    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>