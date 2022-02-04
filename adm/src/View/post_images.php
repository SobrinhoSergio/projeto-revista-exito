<?php
error_reporting(E_ALL ^ E_NOTICE);

if (!$_SESSION['tmp_path_thumb']) {
    $vwidth = 406;
    $vheight = 305;
    $bwidth = 456;
    $bheight = 355;
    $title = "Miniatura";
    echo "<style>  .image-crop-demo { zoom: .7; }  </style>";

//    ($_SESSION['tmp_path_thumb'] && !$_SESSION['tmp_path_photo'])
} else {
    $vwidth = 591;
    $vheight = 420;
    $bwidth = 611;
    $bheight = 440;
    $title = "Capa";
    if (!$_SESSION['tmp_path_photo']) {
        echo "<style>  .image-crop-demo { zoom: .5; }  </style>";
    }
}
//else {
//    $vwidth = 1580;
//    $vheight = 645;
//    $bwidth = 1600;
//    $bheight = 665;
//    $title = "Banner";
//    if (!$_SESSION['tmp_path_amp']) {
//        echo "<style>  .image-crop-demo { zoom: .2; }  </style>";
//    }
//}

// recortes concluídos
if ($_SESSION['tmp_path_photo']) {
    unset($_POST);
    header("location: post_form_controller.php");
}

?>



    <script src="js/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="js/croppie.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/croppie.css" />
    <link rel="stylesheet" href="assets/css/sponsor.css" />

<?php include(TEMPLATE_PATH . "/header.php"); ?>


<style>
    .image-crop-demo {
        overflow-x: auto;
    }

</style>

        <div id="uploadimageModal" role="dialog">
            <div>
                <div>
                    <div class="image-crop-type-header">
                        <h4 class="modal-title"><?= $title ?></h4>
                    </div>
                    <div>
                        <div>
                            <div class="image-crop-demo">
                                <div id="image_demo" style="width:100%; margin-top:30px"></div>
                            </div>

        <!--                    <button class="crop_image">Cortar e Salvar Imagem</button>-->
                        </div>
                    </div>

                    <div class="container">
                        <div class="content">
                            <div class="form-container">
                            <div class="image-crop-options form-field">
                                <button class="crop_image crop-option-item" id="confirm-option">Cortar e Salvar Imagem</button>
                                <a href="cms_controller.php"><button type="button" class="btn btn-default crop-option-item" id="cancel-option">Cancelar</button></a>
                            </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


<script>
    $(document).ready(function(){

        $image_crop = $('#image_demo').croppie({
            url: '<?= $_SESSION['post_main_original_image'] ?>',
            enableZoom: true,
            enableExif: true,
            viewport: {
                width: '<?= $vwidth ?>',
                height: '<?= $vheight ?>',
                type:'square'
            },
            boundary:{
                width: '<?= $bwidth ?>',
                height: '<?= $bheight ?>'
            }
        });


        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response){
                $.ajax({
                    url:"post_images_controller.php",
                    type: "POST",
                    data:{"image": response},
                    success:function(data)
                    {
                        $('#uploadimageModal').modal('hide');
                        $('#uploaded_image').html(data);
                        location.reload();
                    }
                });
            })
        });
    });

</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>

























