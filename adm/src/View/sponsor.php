<?php
//error_reporting(E_ALL ^ E_NOTICE);

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

<div class="container">
    <div class="content">
        <div id="container_upload" style="text-align:center;">
            <div class="panel panel-default">
                <div id="heading" class="panel-heading">Novo anúncio</div>
                <div class="panel-body">
                    <label class="button-img-input" for="upload_image">Selecionar imagem</label>
                    <input type="file" name="upload_image" id="upload_image" accept="image/*" class="display-none" />
                    <div class="about-sponsor" style="text-align: justify; padding-top: 2em;">
                        O anúncio será exibido de acordo com o tipo escolhido na página anterior.
                    </div>
                    <div id="uploaded_image"></div>
                </div>
            </div>
        </div>

        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recorte de Imagem</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="image_demo" style="width:100%; margin-top:30px"></div>
                            </div>
                            <div class="col-md-12 text-center" style="padding-top:30px;">

                                <button class="crop_image button-confirm">Cortar e Salvar Imagem</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="sponsor_controller.php"><button type="button" class="btn btn-default button-cancel">Cancelar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $image_crop = $('#image_demo').croppie({
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

        $('#upload_image').on('change', function(){
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                    $image_crop.croppie('setZoom', 1);
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });

        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response){
                $.ajax({
                    url:"cropper_controller.php",
                    type: "POST",
                    data:{image: response},
                    success:function(data)
                    {
                        console.log("success");
                        window.location.href="sponsor_form_controller.php?tmp_path=<?=$_SESSION['tmp_path']?>"
                    }
                });
            })
        });
    });
</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>