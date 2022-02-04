// card de serviços marcado mas texto vazio ao tentar enviar
$(".form-submit").click(function() {
    if ( (document.getElementById("post_service_check").checked) && (tinymce.get('post_service_text').getContent().length < 1 ) ) {
        alert("Insira um texto de serviço");
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.post-service-card-content').offset().top
        }, 2000);
        return false;
    }

    // se texto principal estiver vazio
    if (tinymce.get('post_main').getContent().length < 1) {
        alert("Insira o texto da matéria");
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.form-field-post-main').offset().top
        }, 2000);
        return false;
    }

    // se introdução da matéria estiver vazia
    if (tinymce.get('post_intro').getContent().length < 1) {
        alert("Insira a introdução da matéria");
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.form-field-post-intro').offset().top
        }, 2000);
        return false;
    }

    // se tema da matéria estiver vazia
    if ($("#post_subject").val() == "") {
        alert("Insira um tema para a matéria");
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.form-field-post-subject').offset().top
        }, 2000);
        return false;
    }

});



$('.category-field').hide();
$('.column-field').hide();
$('.expiration-field').hide();

$('.post-service-content').hide();
$('.post-service-card-content').hide();
$('.form-submit').hide();

// esconde botão de imagem principal e mostra o de enviar ao inserir principal
$('#post_image').change(function() {
    if ( $(this).val() ) {
        $('#btn-upload-img').hide();
        $('.form-submit').show();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#submit-button-field").offset().top
        }, 2000);
    }
});

// caso seja selecionado ESPECIAIS, mostra a opção de inserir card de serviço, categoria e vencimento
$('#post_layout').change(function() {

    if( $(this).val() == 2 ) {
        $('.category-field').show();

        $('.expiration-field').show();
        $('#post_expiration').prop('required', true);

        $('.post-service-content').show();

        $('#post_subject').prop('disabled', true);
        $('#post_subject').val("Produtos & Serviços");

    } else {
        $('.category-field').hide();

        $('.expiration-field').hide();
        $('#post_expiration').prop('required', false);
        $('#post_expiration').val("");

        $('.post-service-content').hide();

        $('#post_subject').prop('disabled', false);
        $('#post_subject').val("");
    }
});

// caso seja selecionado COLUNA, mostra select respectivo
$('#post_layout').change(function(){
    if ( $(this).val() == 4 ) {
        $('.column-field').show();
        $('#post_author_field').hide();
        $('#post_author').val("");
        $('#post_column').prop('required',true);
    } else {
        $('.column-field').hide();
        $('#post_author_field').show();
        $('#post_column').prop('required',false);
        $('#post_column').val("");
    }
});

// caso marque a opção de serviços
$('input:checkbox[name="service_check"]').change(
    function() {
        if ( $(this).is(':checked') && $(this).val() == 'Yes' ) {
            $('.post-service-card-content').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#service-text-field").offset().top
            }, 2000);
        } else {
            $('.post-service-card-content').hide();
        }
    });

// esconde botão ao inserir imagem de serviço e scrolla para imagem principal
$('#post_service_img').change(function() {
    if ( $(this).val() ) {
        $('#btn-upload-service-img').hide();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#main-img-field").offset().top
        }, 2000);
    }
});


// aciona o input quando clica no botão
$(function(){
    $('#btn-upload-img').click(function(e){
        e.preventDefault();
        $('#post_image').click();}
    );
});

$(function(){
    $('#btn-upload-service-img').click(function(e){
        e.preventDefault();
        $('#post_service_img').click();}
    );
});

// ao tentar enviar sem uma imagem, emite alerta
function empty() {
    let x;
    x = document.getElementById("post_image").value;
    if (x == "") {
        alert("Selecione uma imagem");
        return false;
    }
}

// se tentar selecionar a imagem principal antes de escolher o tipo de matéria
$("#post_image").click(function() {
    if ( (document.getElementById("post_layout").value == "") ) {
        alert("Selecione o tipo de matéria");
        return false;
    }
});


function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        if ($(input, this).attr("id") == 'post_image') {
            var id = 'img-preview-main';
        } else {
            var id = 'img-preview-service';
        }
        document.getElementById(id).className = ' display-block';

        reader.onload = function (e) {
            $('#'+ id)
                .attr('src', e.target.result)
                .width('100%');
        };

        reader.readAsDataURL(input.files[0]);

    }
}