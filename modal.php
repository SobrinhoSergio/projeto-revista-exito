	<style>
		.modal-container {
			width: 100vw;
			height: 100vh;
			background: rgba(0,0,0,.5);
			position: fixed;
			top: 0;
			left: 0;
			z-index: 2000;
			display: none;
			justify-content: center;
			align-items: center;
		}

		.modal-container.mostrar {
			display: flex;
		}

		.modal {
			background: white;
			width: 510px;
			/*min-width: 300px;*/
			/*height: 250px;*/
			/*padding: 40px;*/
			border: 10px solid #191970;
			box-shadow: 0 0 0 10px white;
			position: relative;
		}

			.modal img {
				width: 100%;
			}

		@keyframes modal {
			from {
				opacity: 0;
				transform: translate3d(0, -60px, 0);
			}
			to {
				opacity: 1;
				transform: translate3d(0, 0, 0);
			}
		}

		.mostrar .modal {
			animation: modal .3s;
		}

		.fechar {
			position: absolute;
			font-size: 1.2em;
			top: -30px;
			right: -30px;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			border: 4px solid white;
			background: #191970;
			color: white;
			font-family: "PT Mono", monospace;
			cursor: pointer;
			box-shadow: 0 4px 4px 0 rgba(0,0,0,.3);
		}

		@media screen and (max-width:768px) {
			.modal-container.mostrar {
 				display: none;
 			}
		}
		
	</style>




	<div id="modal-promocao" class="modal-container">
		<div class="modal">
			<button class="fechar">x</button>
			<!-- <h3 class="subtitulo">Cadastre-se na Newsletter</h3>
			<form>
				<input type="text" class="inputM" placeholder="Email">
				<input type="button" class="buttonM" value="Cadastrar">
			</form> -->
			<img src="img/reservasbuzios.jpg">
		</div>
	</div>




	<script>
	
		function iniciaModal(modalID) {
			if(sessionStorage.fechaModal !== modalID) {
				const modal = document.getElementById(modalID);
				if(modal) {
					modal.classList.add('mostrar');
					modal.addEventListener('click', (e) => {
						if(e.target.id == modalID || e.target.className == 'fechar') {
							modal.classList.remove('mostrar');
							sessionStorage.fechaModal = modalID;
						}
					});
				}
			}
		}

		// const logoM = document.querySelector('.contato .buttonM');
		// logoM.addEventListener('click', () => iniciaModal('modal-promocao'));

		document.addEventListener('scroll', () => {
			if(window.pageYOffset > 800) {
				iniciaModal('modal-promocao')
			}
		})

	</script>

</body>
</html>