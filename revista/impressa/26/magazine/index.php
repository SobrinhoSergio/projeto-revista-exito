<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<title>Revista Êxito Rio - Versão Impressa</title>
<meta property="OG TAG" content="FRIWEB">
<meta property="og:description" content="A Revista Êxito Rio tem em sua linha editorial o turismo como tema principal. Assuntos relacionados ao meio ambiente, saúde, cultura, lazer, esporte, entretenimento e atualidades são abordados de maneira leve e inteligente visando oferecer conteúdo de alta qualidade. Tendo como foco a “Serra&Mar”, destacamos o melhor da Região Serrana, Costa do Sol e do município de Niterói.">
<meta name="description" content="A Revista Êxito Rio tem em sua linha editorial o turismo como tema principal. Assuntos relacionados ao meio ambiente, saúde, cultura, lazer, esporte, entretenimento e atualidades são abordados de maneira leve e inteligente visando oferecer conteúdo de alta qualidade. Tendo como foco a “Serra&Mar”, destacamos o melhor da Região Serrana, Costa do Sol e do município de Niterói.">
<meta name="keywords" content="Revista, restaurantes, Eventos, Hospedagem, Nova Friburgo, Região Serrana, pontos turisticos, Gastronomia, Bares, Bar, Casas Noturnas">
<meta name="robots" content="index,follow">
<meta name="viewport" content="width = 1050, user-scalable = no" />
<script type="text/javascript" src="../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../extras/modernizr.2.5.3.min.js"></script>
<script type="text/javascript" src="../lib/hash.js"></script>

</head>
<body style="background: #dbdcda; overflow-y: scroll;">

<div id="canvas">

<div class="zoom-icon zoom-icon-in"></div>

<div class="magazine-viewport">
	<div class="container">
		<div class="magazine">
			<!-- Next button -->
			<div ignore="1" class="next-button"></div>
			<!-- Previous button -->
			<div ignore="1" class="previous-button"></div>
		</div>
	</div>
</div>

<!-- Thumbnails -->

<!-- <div class="thumbnails">
	<div>
		<ul>
			<li class="i">
				<img src="pages/1.jpg" width="76" height="100" class="page-1">
				<span>1</span>
			</li>
			<li class="d">
				<img src="pages/2.jpg" width="76" height="100" class="page-2">
				<img src="pages/3.jpg" width="76" height="100" class="page-3">
				<span>2-3</span>
			</li>
			<li class="d">
				<img src="pages/4.jpg" width="76" height="100" class="page-4">
				<img src="pages/5.jpg" width="76" height="100" class="page-5">
				<span>4-5</span>
			</li>
			<li class="d">
				<img src="pages/6.jpg" width="76" height="100" class="page-6">
				<img src="pages/7.jpg" width="76" height="100" class="page-7">
				<span>6-7</span>
			</li>
			<li class="d">
				<img src="pages/8.jpg" width="76" height="100" class="page-8">
				<img src="pages/9.jpg" width="76" height="100" class="page-9">
				<span>8-9</span>
			</li>
			<li class="d">
				<img src="pages/10.jpg" width="76" height="100" class="page-10">
				<img src="pages/11.jpg" width="76" height="100" class="page-11">
				<span>10-11</span>
			</li>
			<li class="d">
				<img src="pages/12.jpg" width="76" height="100" class="page-12">
				<img src="pages/13.jpg" width="76" height="100" class="page-13">
				<span>12-13</span>
			</li>
			<li class="d">
				<img src="pages/14.jpg" width="76" height="100" class="page-14">
				<img src="pages/15.jpg" width="76" height="100" class="page-15">
				<span>14-15</span>
			</li>
			<li class="d">
				<img src="pages/16.jpg" width="76" height="100" class="page-16">
				<img src="pages/17.jpg" width="76" height="100" class="page-17">
				<span>16-17</span>
			</li>
			<li class="d">
				<img src="pages/18.jpg" width="76" height="100" class="page-18">
				<img src="pages/19.jpg" width="76" height="100" class="page-19">
				<span>18-19</span>
			</li>
			<li class="i">
				<img src="pages/20.jpg" width="76" height="100" class="page-20">
				<span>20</span>
			</li>
		<ul>
		
</div>
</div> -->

<script type="text/javascript">

function loadApp() {

 	$('#canvas').fadeIn(1000);

 	var flipbook = $('.magazine');

 	// Check if the CSS was already loaded
	
	if (flipbook.width()==0 || flipbook.height()==0) {
		setTimeout(loadApp, 10);
		return;
	}
	
	// Create the flipbook

	flipbook.turn({
			
			// Magazine width

			width: 922,

			// Magazine height

			height: 600,

			// Duration in millisecond

			duration: 1000,

			// Hardware acceleration

			acceleration: !isChrome(),

			// Enables gradients

			gradients: true,
			
			// Auto center this flipbook

			autoCenter: true,

			// Elevation from the edge of the flipbook when turning a page

			elevation: 50,

			// The number of pages

			pages: 20,

			// Events

			when: {
				turning: function(event, page, view) {
					
					var book = $(this),
					currentPage = book.turn('page'),
					pages = book.turn('pages');
			
					// Update the current URI

					Hash.go('page/' + page).update();

					// Show and hide navigation buttons

					disableControls(page);
					

					$('.thumbnails .page-'+currentPage).
						parent().
						removeClass('current');

					$('.thumbnails .page-'+page).
						parent().
						addClass('current');



				},

				turned: function(event, page, view) {

					disableControls(page);

					$(this).turn('center');

					if (page==1) { 
						$(this).turn('peel', 'br');
					}

				},

				missing: function (event, pages) {

					// Add pages that aren't in the magazine

					for (var i = 0; i < pages.length; i++)
						addPage(pages[i], $(this));

				}
			}

	});

	// Zoom.js

	$('.magazine-viewport').zoom({
		flipbook: $('.magazine'),

		max: function() { 
			
			return largeMagazineWidth()/$('.magazine').width();

		}, 

		when: {

			swipeLeft: function() {

				$(this).zoom('flipbook').turn('next');

			},

			swipeRight: function() {
				
				$(this).zoom('flipbook').turn('previous');

			},

			resize: function(event, scale, page, pageElement) {

				if (scale==1)
					loadSmallPage(page, pageElement);
				else
					loadLargePage(page, pageElement);

			},

			zoomIn: function () {

				$('.thumbnails').hide();
				$('.made').hide();
				$('.magazine').removeClass('animated').addClass('zoom-in');
				$('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');
				
				if (!window.escTip && !$.isTouch) {
					escTip = true;

					$('<div />', {'class': 'exit-message'}).
						html('<div>Press ESC to exit</div>').
							appendTo($('body')).
							delay(2000).
							animate({opacity:0}, 500, function() {
								$(this).remove();
							});
				}
			},

			zoomOut: function () {

				$('.exit-message').hide();
				$('.thumbnails').fadeIn();
				$('.made').fadeIn();
				$('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');

				setTimeout(function(){
					$('.magazine').addClass('animated').removeClass('zoom-in');
					resizeViewport();
				}, 0);

			}
		}
	});

	// Zoom event

	if ($.isTouch)
		$('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
	else
		$('.magazine-viewport').bind('zoom.tap', zoomTo);


	// Using arrow keys to turn the page

	$(document).keydown(function(e){

		var previous = 37, next = 39, esc = 27;

		switch (e.keyCode) {
			case previous:

				// left arrow
				$('.magazine').turn('previous');
				e.preventDefault();

			break;
			case next:

				//right arrow
				$('.magazine').turn('next');
				e.preventDefault();

			break;
			case esc:
				
				$('.magazine-viewport').zoom('zoomOut');	
				e.preventDefault();

			break;
		}
	});

	// URIs - Format #/page/1 

	Hash.on('^page\/([0-9]*)$', {
		yep: function(path, parts) {
			var page = parts[1];

			if (page!==undefined) {
				if ($('.magazine').turn('is'))
					$('.magazine').turn('page', page);
			}

		},
		nop: function(path) {

			if ($('.magazine').turn('is'))
				$('.magazine').turn('page', 1);
		}
	});


	$(window).resize(function() {
		resizeViewport();
	}).bind('orientationchange', function() {
		resizeViewport();
	});

	// Events for thumbnails

	$('.thumbnails').click(function(event) {
		
		var page;

		if (event.target && (page=/page-([0-9]+)/.exec($(event.target).attr('class'))) ) {
		
			$('.magazine').turn('page', page[1]);
		}
	});

	$('.thumbnails li').
		bind($.mouseEvents.over, function() {
			
			$(this).addClass('thumb-hover');

		}).bind($.mouseEvents.out, function() {
			
			$(this).removeClass('thumb-hover');

		});

	if ($.isTouch) {
	
		$('.thumbnails').
			addClass('thumbanils-touch').
			bind($.mouseEvents.move, function(event) {
				event.preventDefault();
			});

	} else {

		$('.thumbnails ul').mouseover(function() {

			$('.thumbnails').addClass('thumbnails-hover');

		}).mousedown(function() {

			return false;

		}).mouseout(function() {

			$('.thumbnails').removeClass('thumbnails-hover');

		});

	}


	// Regions

	if ($.isTouch) {
		$('.magazine').bind('touchstart', regionClick);
	} else {
		$('.magazine').click(regionClick);
	}

	// Events for the next button

	$('.next-button').bind($.mouseEvents.over, function() {
		
		$(this).addClass('next-button-hover');

	}).bind($.mouseEvents.out, function() {
		
		$(this).removeClass('next-button-hover');

	}).bind($.mouseEvents.down, function() {
		
		$(this).addClass('next-button-down');

	}).bind($.mouseEvents.up, function() {
		
		$(this).removeClass('next-button-down');

	}).click(function() {
		
		$('.magazine').turn('next');

	});

	// Events for the next button
	
	$('.previous-button').bind($.mouseEvents.over, function() {
		
		$(this).addClass('previous-button-hover');

	}).bind($.mouseEvents.out, function() {
		
		$(this).removeClass('previous-button-hover');

	}).bind($.mouseEvents.down, function() {
		
		$(this).addClass('previous-button-down');

	}).bind($.mouseEvents.up, function() {
		
		$(this).removeClass('previous-button-down');

	}).click(function() {
		
		$('.magazine').turn('previous');

	});


	resizeViewport();

	$('.magazine').addClass('animated');

}

// Zoom icon

 $('.zoom-icon').bind('mouseover', function() { 
 	
 	if ($(this).hasClass('zoom-icon-in'))
 		$(this).addClass('zoom-icon-in-hover');

 	if ($(this).hasClass('zoom-icon-out'))
 		$(this).addClass('zoom-icon-out-hover');
 
 }).bind('mouseout', function() { 
 	
 	 if ($(this).hasClass('zoom-icon-in'))
 		$(this).removeClass('zoom-icon-in-hover');
 	
 	if ($(this).hasClass('zoom-icon-out'))
 		$(this).removeClass('zoom-icon-out-hover');

 }).bind('click', function() {

 	if ($(this).hasClass('zoom-icon-in'))
 		$('.magazine-viewport').zoom('zoomIn');
 	else if ($(this).hasClass('zoom-icon-out'))	
		$('.magazine-viewport').zoom('zoomOut');

 });

 $('#canvas').hide();


// Load the HTML4 version if there's not CSS transform

yepnope({
	test : Modernizr.csstransforms,
	yep: ['../lib/turn.js'],
	nope: ['../lib/turn.html4.min.js'],
	both: ['../lib/zoom.min.js', 'js/magazine.js', 'css/magazine.css'],
	complete: loadApp
});

</script>

</body>
</html>