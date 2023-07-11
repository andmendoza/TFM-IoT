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
                                <form method='POST' class="custom-validation" action='<?= site_url('clientes') ?>'>
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
                                        <label for="direccion" class="col-md-2 col-form-label">DIRECCION </label>
                                        <div class="col-md-10">
                                            <input class="form-control <?= ($validation->getError('direccion')) ? 'is-invalid' : '' ?>" type="text" name="direccion" id="direccion" value="<?= set_value('direccion') ?>" required>
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
                                            <input class="form-control <?= ($validation->getError('email')) ? 'is-invalid' : '' ?>" type="text" name="email" id="email" value="<?= set_value('email') ?>" required>
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
                                            <input class="form-control <?= ($validation->getError('telefono')) ? 'is-invalid' : '' ?>" type="text" name="telefono" id="telefono" value="<?= set_value('telefono') ?>" required>
                                            <?php if ($validation->getError('telefono')) { ?>
                                                <div class='alert alert-danger mt-2'>
                                                    <?= $error = $validation->getError('telefono'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="password" class="col-md-2 col-form-label">CLAVE </label>
                                        <div class="col-md-10">
                                            <input class="form-control <?= ($validation->getError('password')) ? 'is-invalid' : '' ?>" type="text" name="password" id="password" value="<?= set_value('password') ?>" required>
                                            <?php if ($validation->getError('password')) { ?>
                                                <div class='alert alert-danger mt-2'>
                                                    <?= $error = $validation->getError('password'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 mt-3 offset-md-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Crear</button>
                                        <a class="btn btn-outline-danger waves-effect waves-light w-md" href='<?= site_url('clientes') ?>'>Cancelar</a>
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

<script src="assets/js/app.js"></script>

</body>

</html>