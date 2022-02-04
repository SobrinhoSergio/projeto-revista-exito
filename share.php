<div class="overlay"></div>
<div class="share">
	<h2>Compartilhe</h2>
	<button class="button share-fb shrink" data-sharer="facebook" data-hashtag="hashtag" data-url="http://exitorio.com.br<?=$_SERVER['REQUEST_URI']?>">Facebook</button>
	<button class="button share-wpp shrink" data-sharer="whatsapp" data-title="Êxito Rio - O portal da Serra&Mar" data-url="http://exitorio.com.br<?=$_SERVER['REQUEST_URI']?>" data-web="true">WhatsApp</button>

	<button class="button share-twitter shrink" data-sharer="twitter" data-title="Êxito Rio - O portal da Serra&Mar"
	 data-hashtags="exitorio, novafriburgo" data-url="http://exitorio.com.br<?=$_SERVER['REQUEST_URI']?>">Twitter</button>

</div>

<script type="text/javascript">
	const shareButton = document.querySelector('.share-icon');
	const overlay = document.querySelector('.overlay');
	const shareModal = document.querySelector('.share');

	const title = window.document.title;
	const url = window.document.location.href;

	shareButton.addEventListener('click', () => {
		if (navigator.share) {
			navigator.share({
				title: `${title}`,
				url: `${url}`
			}).then(() => {
				console.log('Obrigado por compartilhar!');
			})
			.catch(console.error);
		} else {
			overlay.classList.add('show-share');
			shareModal.classList.add('show-share');
		}
	})

	overlay.addEventListener('click', () => {
		overlay.classList.remove('show-share');
		shareModal.classList.remove('show-share');
	})

</script>

<script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>