<?php
ob_start();
// error_reporting(E_ALL ^ E_NOTICE); ?>

<?php

// recorte concluído
if (!$_SESSION['sponsor_original_image']) {
    header("Location: sponsors_list_controller.php?page=1");
}

switch ($_SESSION['type_sponsor']) {
    case 1; case 2; case 3;
    $vwidth = 970;
    $vheight = 90;
    $bwidth = 1000;
    $bheight = 100;
    echo '<style> .croppie-container .cr-boundary { zoom: .26; } </style>';
    break;

    case 4; case 5; case 6;
    $vwidth = 300;
    $vheight = 250;
    $bwidth = 310;
    $bheight = 260;
    echo '<style> .croppie-container .cr-boundary { zoom: .85; } </style>';
    break;

    case 7; case 8;
    $vwidth = 490;
    $vheight = 410;
    $bwidth = 500;
    $bheight = 400;
    echo '<style> .croppie-container .cr-boundary { zoom: .5; } </style>';
    break;

    case 9; case 10;
    $vwidth = 150;
    $vheight = 150;
    $bwidth = 170;
    $bheight = 170;
    echo '<style> .croppie-container .cr-boundary { zoom: 1.3; } </style>';
    break;
    case 12;
        $vwidth = 406;
        $vheight = 305;
        $bwidth = 408;
        $bheight = 306;
        echo '<style> .croppie-container .cr-boundary { zoom: .65; } </style>';
        break;
    case 15;
        $vwidth = 1580;
        $vheight = 645;
        $bwidth = 1600;
        $bheight = 665;
        echo '<style> .croppie-container .cr-boundary { zoom: .3; } </style>';
        break;
    default;
        $vwidth = 820;
        $vheight = 312;
        $bwidth = 840;
        $bheight = 322;
        echo '<style> .croppie-container .cr-boundary { zoom: .32; } </style>';
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
                    <h4 class="modal-title">Recorte do anúncio</h4>
                </div>
                <div>
                    <div>
                        <div class="image-crop-demo">
                            <div id="image_demo" style="width:100%; margin-top:30px"></div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="content">
                        <div class="image-crop-options">
                            <button class="crop_image crop-option-item" id="confirm-option">Cortar e Salvar Imagem</button>
                            <a href="cms_controller.php"><button type="button" class="btn btn-default crop-option-item" id="cancel-option">Cancelar</button></a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){

            $image_crop = $('#image_demo').croppie({
                url: '<?=$_SESSION['sponsor_original_image'] ?>',
                enableZoom: true,
                enableExif: true,
                viewport: {
                    width: "<?php echo $vwidth; ?>",
                    height: "<?php echo $vheight; ?>",
                    type:'square'
                },
                boundary:{
                    width: "<?php echo $bwidth; ?>",
                    height: "<?php echo $bheight; ?>"
                }
            });


            $('.crop_image').click(function(event){
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    $.post({
                        url:"update_sponsor_img_controller.php",
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