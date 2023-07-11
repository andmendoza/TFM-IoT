<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">

<head>





</head>

<body>





    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Ver Online</h4>
                    <img id="cam-preview" src="" style="width:100%; display:none">
                    <canvas id="myCanvas" style="width:100%;display:none"></canvas>

                </div>
            </div>
        </div>
    </div>




    <?= $this->include('partials/vendor-scripts') ?>
    <script>
        const image_url = "<?= site_url('clientes/' . $cliente_id . '/device/' . $currentRow['_id'] . '/getimagen') ?>";
        console.log(image_url);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.5/axios.min.js" integrity="sha512-nnNHpffPSgINrsR8ZAIgFUIMexORL5tPwsfktOTxVYSv+AUAILuFYWES8IHl+hhIhpFGlKvWFiz9ZEusrPcSBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url('/') . '/' ?>assets/js/loadremoteimage.js">
    </script>
</body>

</html>