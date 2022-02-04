<?php error_reporting(E_ALL ^ E_NOTICE); ?>

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

    .image-demo {
        width: 100%;
        margin-top: 30px;
    }

</style>

        <div id="uploadimageModal" role="dialog">
            <div>
                <div>
                    <div class="image-crop-type-header">
                        <h4 class="modal-title"> Recorte de anúncio </h4>
                    </div>
                    <div>
                        <div>
                            <div class="image-crop-demo">
                                <div id="image_demo"></div>
                            </div>
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
            url: '<?= $_GET['original_img'] ?>',
            enableZoom: true,
            enableExif: true,
            viewport: {
                width: '<?=$_GET['vw']?>',
                height: '<?=$_GET['vh']?>',
                type:'square'
            },
            boundary:{
                width: '<?=$_GET['bw']?>',
                height: '<?=$_GET['bh']?>'
            }
        });


        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $.post({
                    url: "ad_crop_image.php",
                    type: "POST",
                    data:{
                        "image": response,
                        "id": '<?=$_GET['sponsor_id']?>',
                        "dir": '<?=$_GET['dir']?>',
                        "type": '<?=$_GET['type']?>'
                    },
                    success:function(data)
                    {
                        window.location.href="sponsors_list_controller.php?page=1";
                    }
                });

            })
        });
    });

</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>