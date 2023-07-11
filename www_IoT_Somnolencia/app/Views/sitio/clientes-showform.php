<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Administrar Cliente</h4>
                                <p class="card-title-desc">onRumbo.
                                </p>
                                <?php $validation = \Config\Services::validation(); ?>
                                <?php
                                if (session()->getFlashdata('success')) : ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                        <?php echo session()->getFlashdata('success') ?>
                                    </div>
                                <?php elseif (session()->getFlashdata('failed')) : ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                        <?php echo session()->getFlashdata('failed') ?>
                                    </div>
                                <?php endif; ?>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Pefil Cliente</a>
                                            <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Empleados</a>
                                            <a class="nav-link mb-2" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Asignaciones</a>
                                            <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Notificaciones</a>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <form method='POST' class="custom-validation" action='<?= site_url('clientes/' . $currentRow['_id']) ?>'>
                                                    <input type='hidden' name='_method' value='PUT'>
                                                    <div class="mb-3 row">
                                                        <label for="nombre" class="col-md-2 col-form-label">NOMBRE </label>
                                                        <div class="col-md-10">
                                                            <input class="form-control <?= ($validation->getError('nombre')) ? 'is-invalid' : '' ?>" type="text" name="nombre" id="nombre" value="<?= $currentRow['nombre'] ?>" required>
                                                            <?php if ($validation->getError('nombre')) { ?>
                                                                <div class='alert alert-danger mt-2'>
                                                                    <?= $error = $validation->getError('nombre'); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="direccion" class="col-md-2 col-form-label">DIRECCION </label>
                                                        <div class="col-md-10">
                                                            <input class="form-control <?= ($validation->getError('direccion')) ? 'is-invalid' : '' ?>" type="text" name="direccion" id="direccion" value="<?= $currentRow['direccion'] ?>" required>
                                                            <?php if ($validation->getError('direccion')) { ?>
                                                                <div class='alert alert-danger mt-2'>
                                                                    <?= $error = $validation->getError('direccion'); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="email" class="col-md-2 col-form-label">EMAIL </label>
                                                        <div class="col-md-10">
                                                            <input class="form-control <?= ($validation->getError('email')) ? 'is-invalid' : '' ?>" type="text" name="email" id="email" value="<?= $currentRow['email'] ?>" required>
                                                            <?php if ($validation->getError('email')) { ?>
                                                                <div class='alert alert-danger mt-2'>
                                                                    <?= $error = $validation->getError('email'); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="telefono" class="col-md-2 col-form-label">TELEFONO </label>
                                                        <div class="col-md-10">
                                                            <input class="form-control <?= ($validation->getError('telefono')) ? 'is-invalid' : '' ?>" type="text" name="telefono" id="telefono" value="<?= $currentRow['telefono'] ?>" required>
                                                            <?php if ($validation->getError('telefono')) { ?>
                                                                <div class='alert alert-danger mt-2'>
                                                                    <?= $error = $validation->getError('telefono'); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3 mt-3 offset-md-2">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Actualizar</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <th>NOMBRE</th>
                                                        <th>EMAIL</th>
                                                        <th>FOTO</th>
                                                        <th>ESTADO</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody id="empleados-table-body">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <th>NOMBRE EMPLEADO</th>
                                                        <th>DISPOSITIVO</th>
                                                        <th>UBICACION</th>
                                                        <th>ESTADO</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody id="asignaciones-table-body">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>IP</th>
                                                            <th>PERSONA</th>
                                                            <td>IMAGEN</td>

                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    foreach ($listadoNotificaciones as $documento) {
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

                                                            <td><?php
                                                                if (isset($documento['tracking']['imagename'])) {
                                                                    $path =  IMAGES_BASE . $documento['tracking']['basepath'] . 'fd/' . $documento['tracking']['imagename'];
                                                                    if (file_exists($path)) {


                                                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                                                        $data = file_get_contents($path);
                                                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                                                ?>
                                                                        <img src='<?= $base64 ?>' style='width:300px'>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?= $this->include('partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Full screen Content -->
    <div class="modal fade" id="trackingModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Tracking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id='tracking-iframe' style="border:none; width:100%; height:100%" scrolling="no"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Center Modal example -->
    <div id="onlineModal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Center modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id='online-iframe' style="border:none; width:100%; height:600px" scrolling="no"></iframe>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?= $this->include('partials/right-sidebar') ?>

    <?= $this->include('partials/vendor-scripts') ?>

    <script src="<?= base_url('/') . '/' ?>assets/js/app.js"></script>
    <script type="text/javascript">
        const loadEmpleadosTables = () => {
            $.ajax({
                type: 'GET',
                url: '<?= site_url('clientes/' . $currentRow['_id'] . '/empleados') ?>',
                success: function(responseText) {
                    $('#empleados-table-body').html('');
                    $('#empleados-table-body').html(responseText);
                }

            });
        }
        const loadAsignacionesTables = () => {
            $.ajax({
                type: 'GET',
                url: '<?= site_url('clientes/' . $currentRow['_id'] . '/asignaciones') ?>',
                success: function(responseText) {
                    $('#asignaciones-table-body').html('');
                    $('#asignaciones-table-body').html(responseText);
                }

            });
        }

        const loadTracking = (asignacion_id) => {
            $('#trackingModalFullscreen').modal('show');
            var urlTracking = '<?= site_url('clientes/' . $currentRow['_id'] . '/asignaciones/') ?>' + asignacion_id + '/tracking';
            console.log(urlTracking);
            $('#tracking-iframe').attr('src', urlTracking);
        }
        const verremoto = (device_id) => {
            $('#onlineModal').modal('show');
            var urlRemoto = '<?= site_url('clientes/' . $currentRow['_id'] . '/device/') ?>' + device_id + '/online';
            console.log(urlRemoto);
            $('#online-iframe').attr('src', urlRemoto);
        }

        $(document).ready(function() {
            loadEmpleadosTables();
            loadAsignacionesTables();
        });
    </script>
    </body>

</html>