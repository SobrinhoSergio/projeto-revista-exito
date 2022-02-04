	<!-- footer -->
	<footer class="footer" id="footer">
		    <!-- navigation footer -->
		    <section class="footer-nav">

		    	<!-- logo/credits -->
				<div class="footer-logo">
					<img src="img/logo.png" style="width: 168px;">
				</div>

				<!-- contact -->
				<div class="footer-contact">
						<div class="footer-contact-header">
							<h3>Contato</h3>
						</div>

						<div class="footer-contact-list">
							<a href="https://wa.me/5522999618992" target="_blank"> <i class="fa fa-whatsapp"></i> (22) 99961-8992 </a>
							<a href="anuncie.php"> <i class="fa fa-bullhorn"></i> Anuncie </a>
						</div>
				</div>


		    	<!-- footer map -->
		    	<div class="footer-map">
			    		<div class="footer-map-header">
							<h3>Páginas</h3>
						</div>

						<div class="footer-map-list">
							<ul>
                                <li> <a href="index.php"> <i class="fa fa-angle-right"></i> Home </a> </li>
                                <li> <a href="especiais.php?page=1"> <i class="fa fa-angle-right"></i> Turismo Serra & Mar </a> </li>
                                <li> <a href="piadas.php?page=1"> <i class="fa fa-angle-right"></i> Diversão </a> </li>
                                <li> <a href="colunas.php?page=1"> <i class="fa fa-angle-right"></i> Colunas </a> </li>

							</ul>
						</div>
				</div>

				<!-- list 'overflow' -->
				<div class="list-overflow">
							<ul>
                                <li><a href="imoveis.php?page=1"><i class="fa fa-angle-right"></i> Imóveis</a></li>
								<li><a href="produtos_e_servicos.php"><i class="fa fa-angle-right"></i> Guia Empresarial</a></li>
								<a href="about.php"><li><i class="fa fa-angle-right"></i> Quem Somos</li></a>

							</ul>
				</div>
				<!-- social media icons -->
				<div class="footer-social-media">
					<a href="https://www.facebook.com/ExitoRio" target="_blank"><i class="fa fa-facebook"></i></a>
					<a href="https://www.youtube.com/user/exitorio" target="_blank"><i class="fa fa-youtube"></i></a>
					<a href="https://www.instagram.com/exitorio/" target="_blank"><i class="fa fa-instagram"></i></a>
				</div>

			<!-- </div> -->
		</section>

	</footer>

	<script>
		
		var tituloPagina = document.getElementById('tituloPagina').textContent.replace(/^\s\s*/, '').replace(/\s\s*$/, '');

		if (tituloPagina != "") {
			document.title = tituloPagina;
		}

	</script>

	<script src="js/menu.js" type="text/javascript"></script>
	<script src="js/carousel.js" type="text/javascript"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(window).on("load",function(){
            $(".loader-wrapper").fadeOut("slow");
        });
    </script>

    <script>
        //dropdown list nav mobile
        let dpdwn = document.getElementsByClassName("dropdown-btn-mobile");
        let counterdpwn;

        for (counterdpwn = 0; counterdpwn < dpdwn.length; counterdpwn++) {
            dpdwn[counterdpwn].addEventListener("click", function() {
                this.classList.toggle("active");
                let panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NZXS1BJLHE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NZXS1BJLHE');
</script>

    </body>

</html>
