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

                                <h4 class="card-title">Agregar Cliente</h4>
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
                                <form method='POST' class="custom-validation" action='<?= site_url('devices') ?>'>
                                    <div class="mb-3 row">
                                        <label for="nombre" class="col-md-2 col-form-label">NOMBRE </label>
                                        <div class="col-md-10">
                                            <input class="form-control <?= ($validation->getError('nombre')) ? 'is-invalid' : '' ?>" type="text" name="nombre" id="nombre" value="<?= set_value('nombre') ?>" required>
                                            <?php if ($validation->getError('nombre')) { ?>
                                                <div class='alert alert-danger mt-2'>
                                                    <?= $error = $validation->getError('nombre'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="serie" class="col-md-2 col-form-label">SERIE </label>
                                        <div class="col-md-10">
                                            <input class="form-control <?= ($validation->getError('serie')) ? 'is-invalid' : '' ?>" type="text" name="serie" id="serie" value="<?= set_value('serie') ?>" required>
                                            <?php if ($validation->getError('serie')) { ?>
                                                <div class='alert alert-danger mt-2'>
                                                    <?= $error = $validation->getError('serie'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="ubicacion" class="col-md-2 col-form-label">UBICACION </label>
                                        <div class="col-md-10">
                                            <input class="form-control <?= ($validation->getError('ubicacion')) ? 'is-invalid' : '' ?>" type="text" name="ubicacion" id="ubicacion" value="<?= set_value('ubicacion') ?>" required>
                                            <?php if ($validation->getError('ubicacion')) { ?>
                                                <div class='alert alert-danger mt-2'>
                                                    <?= $error = $validation->getError('ubicacion'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 mt-3 offset-md-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Crear</button>
                                        <a class="btn btn-outline-danger waves-effect waves-light w-md" href='<?= site_url('devices') ?>'>Cancelar</a>
                                    </div>
                                </form>
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

<script src="<?= base_url('/').'/'?>assets/js/app.js"></script>

</body>

</html>