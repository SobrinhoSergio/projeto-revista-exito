<?php error_reporting(E_ALL ^ E_NOTICE); ?>

    <script src="js/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="js/croppie.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/croppie.css" />
    <link rel="stylesheet" href="assets/css/sponsor.css" />

<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    .croppie-container .cr-boundary {
        zoom: .8;
    }
</style>

<div class="container">
    <div class="content">
        <div id="container_upload" style="text-align: center;">

            <div class="panel panel-default">
                <div id="heading" class="panel-heading">Novo parceiro</div>
                <div class="panel-body">
                    <label for="upload_image" class="button-img-input">Selecionar imagem</label>
                    <input type="file" name="upload_image" id="upload_image" accept="image/*" class="display-none"/>

                    <div class="about-partner" style="text-align: justify; padding-top: 2em;">
                        Os parceiros aparecerão na página de Produtos e Serviços do portal Êxito Rio.
                        <img src="assets/img/card_guia.png" alt="Card Produtos e Serviços" width="100%" style="padding-top: 1em;">
                    </div>

                    <div id="uploaded_image"></div>
                </div>
            </div>
        </div>

        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recorte da Logo</h4>
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
                        <a href="partner_controller.php"><button type="button" class="btn btn-default button-cancel">Cancelar</button></a>
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
                width: 227,
                height: 170,
                type:'square'
            },
            boundary:{
                width: 247,
                height: 190
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
                $.post({
                    url:"partner_controller.php",
                    type: "POST",
                    data:{"image": response},
                    success:function(data)
                    {
                        // $('#uploadimageModal').modal('hide');
                        // $('#uploaded_image').html(data);
                        // document.getElementById('upload_image').className = ' display-none';
                        // document.getElementById('heading').className = ' display-none';
                        // document.getElementById('form').className = ' display-block';
                        window.location.href = "partner_form_controller.php";
                    }
                });
            })
        });
    });
</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>


