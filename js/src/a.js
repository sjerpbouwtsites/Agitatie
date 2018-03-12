var doc, body, html, aside, i, l;

function klikBaas(){

	body.addEventListener('click', function(e){

		var
		funcNamen = ['schakel', 'scroll'],
		f;

		for (var i = funcNamen.length - 1; i >= 0; i--) {
			f = funcNamen[i];
			if (e.target.classList.contains(f) || e.target.parentNode.classList.contains(f)) {
				window[f](e);
			}
		}

	});

}

function init() {
	doc = document;
	body = doc.getElementsByTagName('body')[0] || null;
	html = doc.getElementsByTagName('html')[0] || null;
	aside = doc.getElementById('zijbalk') || null;
}

function verschrikkelijkeHacks(){

	if (aside) {
		var
		l = aside.getElementsByTagName('section').length;

		var
		c = (l%2 === 0 ? 'even' : 'oneven');

		aside.classList.add('sectietal-'+c);
	}

}



function videoPlayer () {

	$('video ~ .knop').hover(function(){
		if (this.classList.contains('speel-video')) {
			this.classList.add('in-wit');
		} else {
			this.classList.remove('in-wit');
		}
	}, function(){
		if (this.classList.contains('speel-video')) {
			this.classList.remove('in-wit');
		} else {
			this.classList.add('in-wit');
		}
	});

	$('body').on('click', '.speel-video', function(e){
		e.preventDefault();
		console.log(this, $(this).closest('vid-doos').find('video'));
		$(this).closest('.vid-doos').find('video').click();
		//this.parentNode.getElementsByTagName('video')[0].click();
	});

	$('body').on('click', 'video', function(){
		if (this.paused) {
			this.classList.remove('pause');
			this.classList.add('speelt');
			this.play();
		} else {
			this.classList.remove('speelt');
			this.classList.add('pause');
			this.pause();
		}

	});
}



function artCLinkTrigger(){
	$('.art-c').on('click', 'div', function(e){

		if (this.classList.contains('art-rechts')) {
			this.querySelector('a').click();
		}

	});
}

function kopmenuSubMobiel() {

	if (!$('.kopmenu-mobiel:visible').length) {
		return false;
		//niet mobiel
	}


	$("#menu-kopmenu .menu-item-has-children > a").each(function(){
		$(this).append($("<i class='mdi mdi-plus-circle-outline'></i>"));
	});

	$("#menu-kopmenu").on('click', 'i', function(e){
		e.preventDefault();
		if ($(this).hasClass('mdi-plus-circle-outline')) {
			$(this).removeClass('mdi-plus-circle-outline');
			$(this).addClass('mdi-minus-circle-outline');
		} else {
			$(this).removeClass('mdi-minus-circle-outline');
			$(this).addClass('mdi-plus-circle-outline');
		}
		$(this).closest('.menu-item-has-children').find('ul').first().toggle();
	});

}


window.onload = function(){

	init();

	klikBaas();

	verschrikkelijkeHacks();

	artCLinkTrigger();

	if (doc.querySelector('.carousel')) carouselInit();

/*	var shareDaddy = $('.sharedaddy');
	if (shareDaddy.length) kopieerShare(shareDaddy);
*/
	videoPlayer();

	if (doc.getElementById('agenda-filter')) agendaFilter();

	kopmenuSubMobiel();


};

