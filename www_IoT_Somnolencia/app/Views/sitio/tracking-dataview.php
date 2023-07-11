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

<body>





    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Default Datatable</h4>
                    <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            for ($i = 1; $i <= $totalPages; $i++) {
                                $active = '';
                                if ($i == $page) {
                                    $active = 'active';
                                }
                                echo '<li class="page-item ' . $active . '"><a class="page-link ' . $active . '" href="?page=' . $i . '">' . $i . '</a> </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                    <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <tr>
                            <th>Fecha</th>
                            <th>IP</th>
                            <th>PERSONA</th>
                            <th>ESTADO</th>
                            <td>IMAGEN</td>
                            <td>PROCESADA</td>
                        </tr>

                        <?php
                        foreach ($documentos as $documento) {
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
                            $datetime = $documento->fecha->toDateTime();
                            //var_dump($datetime->format(DATE_RSS));
                        ?>
                            <tr>
                                <td><?= $datetime->format(DATE_RSS) ?></td>
                                <td><?= ($documento['ip']) ? $documento->ip : '' ?></td>
                                <td><?php
                                    if (isset($documento['pesonanombre'])) {
                                        echo $documento['pesonanombre'];
                                    }
                                    ?></td>
                                <td><?php
                                    if (isset($documento['estado'])) {
                                        echo $documento['estado'];
                                    }
                                    ?></td>
                                <td><?php
                                    if (isset($documento['imagename'])) {
                                        $path =  IMAGES_BASE . $documento['basepath'] . $documento['imagename'];
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
                                <td><?php
                                    if (isset($documento['imagename'])) {
                                        $path =  IMAGES_BASE . $documento['basepath'] . 'fd/' . $documento['imagename'];
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            for ($i = 1; $i <= $totalPages; $i++) {
                                $active = '';
                                if ($i == $page) {
                                    $active = 'active';
                                }
                                echo '<li class="page-item ' . $active . '"><a class="page-link ' . $active . '" href="?page=' . $i . '">' . $i . '</a> </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>




    <?= $this->include('partials/vendor-scripts') ?>



</body>

</html>