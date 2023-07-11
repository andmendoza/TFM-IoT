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

                                <h4 class="card-title">Todos los clientes</h4>
                                <p class="card-title-desc">onRumbo.
                                </p>
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
                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <tr>
                                        <th>#</th>
                                        <th>NOMBRE</th>
                                        <th>EMAIL</th>
                                        <th>TELÉFONO</th>
                                        <th>DIRECCION</th>
                                        <th>ES ADMIN</th>
                                        <td style="width: 10px;">
                                            <a class="btn btn-primary" href="<?= site_url('clientes/new')?>">
                                            <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <?php
                                    $i=0;
                                    foreach ($documentos as $documento) {
                                        $i++;
                                        /* echo "<pre>";
                                        var_dump($documento['basepath']);
                                        echo "</pre>"; */
                                        // Mostrar los datos del documento
                                        //print_r($documento);
                                        //$mongoDate = $document->fecha;
                                        // Convert MongoDB date to PHP date
                                        //$phpDate = $mongoDate->toDateTime();

                                        // Format the PHP date as needed
                                        //$formattedDate = $phpDate->format('Y-m-d H:i:s');
                                        //var_dump($datetime->format(DATE_RSS));
                                    ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $documento->nombre ?></td>
                                            <td><?= $documento->email ?></td>
                                            <td><?= $documento->telefono ?></td>
                                            <td><?= $documento->direccion ?></td>
                                            <td><?= $documento->is_admin ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="<?= site_url('clientes/'.$documento['_id'])?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
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

<script src="<?=base_url('/').'/'?>assets/js/app.js"></script>

</body>

</html>