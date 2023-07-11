<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

</head>

<?= $this->include('partials/body') ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <?= $page_title ?>

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="total-revenue-chart"></div> -->
                                    <i class="uil-user-square" style="font-size: 3em;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $count_clientes ?></span></h4>
                                    <p class="text-muted mb-0">Clientes</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><span class="text-success me-1">Todos los clientes
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="orders-chart"> </div> -->
                                    <i class="uil-cog" style="font-size: 3em;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $count_devices ?></span></h4>
                                    <p class="text-muted mb-0">Dispositivos</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><span class="text-success me-1">Total Dispositivos
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="customers-chart"> </div> -->
                                    <i class="uil-exclamation-triangle" style="font-size: 3em;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $count_notificaciones ?></span></h4>
                                    <p class="text-muted mb-0">Notificaciones</p>
                                </div>
                                <p class="text-muted mt-3 mb-0">Total de Notificaciones
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="growth-chart"></div> -->
                                    <i class="uil-users-alt" style="font-size: 3em;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?= $count_empleados ?></span></h4>
                                    <p class="text-muted mb-0">Empleados</p>
                                </div>
                                <p class="text-muted mt-3 mb-0"><span class="text-warning me-1">Todos los empleados
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart" style="width: 100%; height:400px;"></div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Ultimas Notificaciones</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>IP</th>
                                                <th>PERSONA</th>
                                                <th>ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($notificaciones as $documento) {
                                                $datetime = $documento->tracking->fecha->toDateTime();
                                            ?>
                                                <tr>
                                                    <td><?= $datetime->format(DATE_RSS) ?></td>
                                                    <td><?= ($documento['tracking']['ip']) ? $documento['tracking']['ip'] : '' ?></td>
                                                    <td><?php
                                                        if (isset($documento['empleado'])) {
                                                            echo $documento['empleado']['apellidos'] . ' ' . $documento['empleado']['nombres'];
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <?= $documento['tracking']['estado'] ?>
                                                    </td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->




            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>

<?= $this->include('partials/vendor-scripts') ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/js/app.js"></script>
<script>
    // Datos en formato JSON
    var jsonData = [
      {"name":"JAVUU X",
      "data":[
          {"date":"2023-05-23","counter":5},
          {"date":"2023-05-24","counter":10},
          {"date":"2023-05-25","counter":2},
          {"date":"2023-05-26","counter":7}
          ]},
      {"name":"JUAN",
      "data":[
          {"date":"2023-05-23","counter":5},
          {"date":"2023-05-24","counter":6},
          {"date":"2023-05-25","counter":7},
          {"date":"2023-05-26","counter":9}
          ]},
      {"name":"ANIBAL",
      "data":[
          {"date":"2023-05-23","counter":2},
          {"date":"2023-05-24","counter":5},
          {"date":"2023-05-25","counter":2},
          {"date":"2023-05-26","counter":13}
          ]},
      {"name":"ANITA",
      "data":[
          {"date":"2023-05-23","counter":4},
          {"date":"2023-05-24","counter":9},
          {"date":"2023-05-25","counter":23},
          {"date":"2023-05-26","counter":1}
          ]}
      ];

    // Preparar los datos para ApexCharts
    var series = [];
    var xLabels = [];
    jsonData[0].data.forEach(function(item) {
      xLabels.push(item.date);
    });
    jsonData.forEach(function(item) {
      var dataPoints = [];
      item.data.forEach(function(dataItem) {
        dataPoints.push(dataItem.counter);
      });
      series.push({
        name: item.name,
        data: dataPoints
      });
    });

    // Configuración del gráfico
    var options = {
      chart: {
        type: 'line'
      },
      series: series,
      xaxis: {
        categories: xLabels
      }
    };

    // Crear una instancia del gráfico de ApexCharts
    var chart = new ApexCharts(document.querySelector("#chart"), options);

    // Renderizar el gráfico
    chart.render();
  </script>
</body>

</html>