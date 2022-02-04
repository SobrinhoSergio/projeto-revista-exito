<?php include(TEMPLATE_PATH . "/header.php"); ?>

<div class="container">
    <div class="content">
<!--        <a href="cms_controller.php">Voltar</a>-->

        <div class="content-form">
            <form action="#" method="get">
                <div class="form-container">
                    <div class="form-field">
                        <label class="form-label" for="sponsor_type">Tipo de anúncio *</label>
                        <select class="form-select" name="type" id="sponsor_type" style="margin-bottom: 2em;" required>
                            <option disabled selected value> -- Selecione uma opção -- </option>
                            <option value="15">Slideshow</option>
                            <option value="1">Banner Grande (Home)</option>
                            <option value="2">Banner Grande (Matérias Jornalísticas)</option>
<!--                            <option value="3">Banner Grande (Matérias Imóveis)</option>-->
<!--                            <option value="4">Retângulo (Home)</option>-->
                            <option value="5">Retângulo (Matérias Jornalísticas)</option>
                            <option value="6">Retângulo (Matérias Imóveis)</option>
                            <option value="7">Pop-up Modal (Home)</option>
<!--                            <option value="8">Pop-up (Matérias Imóveis)</option>-->
                            <option value="9">Carrosel de Logos (Home)</option>
                            <option value="10">Carrossel de Logos (Matérias Imóveis)</option>
                            <option value="11">Full Banner (Home)</option>
                            <option value="12">Card de imóvel</option>
                        </select>
                    </div>

                    <button class="form-submit" type="submit">Continuar</button>

                    <div class="about-sponsors" style="padding-top: 2em; text-align: justify;">
                        Escolha o tipo de anúncio com base no formato (em pixels) e nas páginas no qual irá aparecer.
                        <div style="text-align: center; padding-top: 1em;"> - Slideshow: 1580x645 </div>
                        <div style="text-align: center;"> - Banner: 970x60 </div>
                        <div style="text-align: center;"> - Retângulo: 300x250 </div>
                        <div style="text-align: center;"> - Pop-up Modal: 490x410 </div>
                        <div style="text-align: center;"> - Carrossel de Logos: 150x150 </div>
                        <div style="text-align: center;"> - Card de Imóvel: 406x305 </div>
                        <div style="text-align: center;"> - Capa (Full Banner): 820x312 </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>