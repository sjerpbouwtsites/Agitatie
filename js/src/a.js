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

function kopieerShare(shareDaddy){
	$s = shareDaddy.first();
	if ($s.length) {
		$("#footer-share-kopie").append($s.clone());
		var a = $(".artikel-meta.blok");
		if (a.length) a.after($s.clone());
		$s.remove();
	}
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


function bookingformAanpassing() {

	//past HTML aan zodat ze conform andere knoppen zijn.

	var nepKnoppen = [
		{
			sel: 		'.rtb-booking-form .add-message a',
			mdiClass: 	'pencil',
		},
		{
			sel: 		'.rtb-booking-form button[type="submit"]',
			mdiClass: 	'check',
		},
		{
			sel: 		'.rtb-booking-form .rtb-checkbox label:first-child',
			mdiClass: 	'format-list-checks',
		}
	];

	var k, $el, $elT;

	for (var i = nepKnoppen.length - 1; i >= 0; i--) {
		k = nepKnoppen[i];
		$el = $(k.sel);
		if ($el.length) {
			$elT = $el.text();
			$el.empty();
			$el.append("<span>"+$elT+"</span>");
			$el.append("<i class='mdi mdi-"+k.mdiClass+"'></i>");
		}
	}

	$(".rtb-checkbox label:first-child").on('click', function(){
		$(this).toggleClass('open');
	});

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

function carouselInit(){
	var
	wi = window.innerWidth,
	s = wi > 899 ? 3 : wi > 599 ? 2 : 1;

	$('.menu-gerechten-carousel').slick({
	  infinite: true,
	  slidesToShow: s,
	  slidesToScroll: 1,
	  arrows: true,
	  autoplay: true,
	  autoplaySpeed: 2500,
	  prevArrow: "<i class='mdi mdi-chevron-left'></i>",
	  nextArrow: "<i class='mdi mdi-chevron-right'></i>",
	});

}

function footerOpenSluit(){

	var fbT = $(".widget_easy_facebook_feed h3 a").text() + " ";
	$(".widget_easy_facebook_feed h3 a").remove();
	$(".widget_easy_facebook_feed h3").text(fbT).append($("#stek-voet h3").first().find('i').clone());


	$("#stek-voet").on('click', 'h3', function(){
		this.parentNode.classList.toggle('open');
	});
}

function artCLinkTrigger(){
	$('.art-c').on('click', 'div', function(e){

		if (this.classList.contains('art-rechts')) {
			this.querySelector('a').click();
		}

	});
}


window.onload = function(){

	init();

	klikBaas();

	verschrikkelijkeHacks();

	footerOpenSluit();

	artCLinkTrigger();

	if (doc.querySelector('.carousel')) carouselInit();

/*	var shareDaddy = $('.sharedaddy');
	if (shareDaddy.length) kopieerShare(shareDaddy);
*/
	videoPlayer();

	if (doc.getElementById('agenda-filter')) agendaFilter();

	if (doc.querySelector('.rtb-booking-form')) bookingformAanpassing();

};

