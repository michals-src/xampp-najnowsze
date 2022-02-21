jQuery(document).ready(function( $ ) {
	"use strict";

/*
** Header Image =====
*/
	var entryHeader = $('.entry-header');
	
	// Parallax Effect
	if ( entryHeader.attr('data-parallax') == '1' ) {
		entryHeader.parallax({ imageSrc: entryHeader.attr('data-image') });
	}

/*
** Main Navigation =====
*/
	// Navigation Hover 
	$('#top-menu, #main-menu').find('li').hover(function () {
	    $(this).children('.sub-menu').stop().fadeToggle( 200 );
	}, function() {
		$(this).children('.sub-menu').stop().fadeToggle( 200 );
	});

	// Mobile Menu
	$('.mobile-menu-btn').on( 'click', function() {
		$('.mobile-menu-container').slideToggle();
	});

	// Responsive Menu 
	$( '#mobile-menu .menu-item-has-children' ).prepend( '<div class="sub-menu-btn"></div>' );
	$( '#mobile-menu .sub-menu' ).before( '<span class="sub-menu-btn-icon icon-angle-down"></span>' );

	// Responsive sub-menu btn
	$('.sub-menu-btn').on( 'click', function(){
		$(this).closest('li').children('.sub-menu').slideToggle();
		$(this).closest('li').children('.sub-menu-btn-icon').toggleClass( 'fa-rotate-270' );
	});

	$( window ).on( 'resize', function() {
		if ( $('.main-menu-container').css('display') === 'block' ) {
			$( '.mobile-menu-container' ).css({ 'display' : 'none' });
		}
	});

	// Search Form
	$('.main-nav-icons').after($('.main-nav-search #searchform').remove());
	var mainNavSearch = $('#main-nav #searchform');
	
	mainNavSearch.find('#s').attr( 'placeholder', mainNavSearch.find('#s').data('placeholder') );

	$('.main-nav-search').on( 'click', function() {
		if ( mainNavSearch.css('display') === 'none' ) {
			mainNavSearch.fadeIn();
			$('.main-nav-search .svg-inline--fa:last-of-type').show();
			$('.main-nav-search .svg-inline--fa:first-of-type').hide();
		} else {
			mainNavSearch.fadeOut();
			$('.main-nav-search .svg-inline--fa:last-of-type').hide();
			$('.main-nav-search .svg-inline--fa:first-of-type').show();
		}
	});


/*
** Featured Slider =====
*/
	var RTL = false;
	if( $('html').attr('dir') == 'rtl' ) {
	RTL = true;
	}

	$('#featured-slider').slick({
		prevArrow: '<span class="prev-arrow icon-angle-left"></span>',
		nextArrow: '<span class="next-arrow icon-angle-right"></span>',
		dotsClass: 'slider-dots',
		adaptiveHeight: true,
		rtl: RTL,
		speed: 750,
  		customPaging: function(slider, i) {
            return '';
        }
	});


/*
** Sidebars =====
*/

	// Sticky Sidebar
	function bardstickySidebar() {
		if ( $( '.main-content' ).data('sidebar-sticky') === 1 ) {		
			var SidebarOffset = 0;

			if ( $("#main-nav").attr( 'data-fixed' ) === '1' ) {
				SidebarOffset = 40;
			}

			$('.sidebar-left,.sidebar-right').stick_in_parent({
				parent: ".main-content",
				offset_top: SidebarOffset,
				spacer: '.sidebar-left-wrap,.sidebar-right-wrap'
			});

			if ( $('.mobile-menu-btn').css('display') !== 'none' ) {
				$('.sidebar-left,.sidebar-right').trigger("sticky_kit:detach");
			}
		}
	}

	// Sidebar Alt Scroll
	$('.sidebar-alt').perfectScrollbar({
		suppressScrollX : true,
		includePadding : true,
		wheelSpeed: 3.5
	});

	// Sidebar Alt
	$('.main-nav-sidebar').on('click', function () {
		$('.sidebar-alt').css( 'left','0' );
		$('.sidebar-alt-close').fadeIn( 500 );
	});

	// Sidebar Alt Close
	function bardAltSidebarClose() {
		var leftPosition = parseInt( $( ".sidebar-alt" ).outerWidth(), 10 ) + 30;
		$('.sidebar-alt').css( 'left','-'+ leftPosition +'px' );
		$('.sidebar-alt-close').fadeOut( 500 );
	}
	
	$('.sidebar-alt-close, .sidebar-alt-close-btn').on('click', function () {
		bardAltSidebarClose();
	});

	// Instagram Columns
	var instagram = $( '.footer-instagram-widget .null-instagram-feed li a' ),
	instagramColumn = $( '.footer-instagram-widget .null-instagram-feed li' ).length;
	instagram.css({
		 'width'	: '' + 100 / instagramColumn +'%',
		 'opacity'	: '1'
	});

/*
** Scroll Top Button =====
*/

	$('.scrolltop').on( 'click', function() {
		$('html, body').animate( { scrollTop : 0 }, 800 );
		return false;
	});


/*
** Preloader =====
*/
	if ( $('.bard-preloader-wrap').length ) {

		$( window ).on( 'load', function() {
			setTimeout(function(){
				$('.bard-preloader-wrap > div').fadeOut( 600 );
				$('.bard-preloader-wrap').fadeOut( 1500 );
			}, 300);
		});

	}


/*
** Window Resize =====
*/

	$( window ).on( 'resize', function() {

		if ( $('.mobile-menu-btn').css('display') === 'none' ) {
			$( '.mobile-menu-container' ).css({ 'display' : 'none' });
		}
		
		bardstickySidebar();

		bardAltSidebarClose();
	});


/*
** Window Load =====
*/

	$( window ).on( 'load', function() {
		bardstickySidebar();
	});


/*
** Run Functions =====
*/
	// FitVids
	$('.slider-item, .post-media').fitVids();



$(".hamburger-menu-btn").on("click", function(e){

	e.preventDefault();
	$('.top-bar-mobile-overall').toggleClass('in');

});



/*
** Animations ======
*/

//var trigger1 = new enedScroll.Trigger( 'Trigger-1', 0 );
// var trigger2 = new enedScroll.Trigger( 'Trigger-2', 100 );
// var Scene1 = new enedScroll( $('.content-test'), trigger1, { selectors: [0, 0], visual: { 
// 	show_selectors: false, show_trigger: false } } );

// Scene1.pin( $('.container-a'), [[ 1.5, 0, '--bg-pinning']] );
// Scene1.add( $('#text-b'), [
// 	[{ 'opacity': '[0,1]'}, 0.3, 0.35]
// ]);
// Scene1.add( $('.container-a'), [
// 	[{ 'transform': 'scale([0.9,1])'}, 0.35, 0.2]
// ]);
// Scene1.add( $('.black-courtain'), [
// 	[{ 'opacity': '[0,0.7]' }, 0.35, 0.25],
// 	[{ 'opacity': '[0.7,0.85]' }, 0.2, 0.3],
// ]);
// Scene1.add( $('.content-test-inner #text-a'), [
// 	[{ 'transform': 'translateY([0,-315]px)'}, 0.35, 0.7]
// ]);
// Scene1.add( $('.content-test-inner #text-b'), [
// 	[{ 'transform': 'translateY([0,-315]px)'}, 0.35, 0.7]
// ]);

//$('.offer-2--figure').css({ 'transform': 'translateY(-' + $('.offer-2--header').outerHeight() + 'px)' });


// var trigger1 = new enedScroll.Trigger( 'Trigger-1', 0.1 );

// var frame_1_subhead = new enedScroll( $('.site-frame-1'), trigger1, { selectors: [0, 0], visual: { 
// 	show_selectors: false, show_trigger: false } } );

// frame_1_subhead.add( $(".site-frame-1-subhead .--subheadline"), [
// 	[{"transform": "translateY([" + $('.site-frame-1-subhead .--headline').outerHeight() + ",0]px)"}, 0.1,0]
// ]);

// frame_1_subhead.add( $(".site-frame-1-subhead .--headline"), [
// 	[{"opacity": "[0,1]"}, 0.1,0.05]
// ]);

// var Scene3 = new enedScroll( $('.site-frame-container'), trigger1, { selectors: [0, 0], visual: { 
// 	show_selectors: false, show_trigger: false } } );

// Scene3.pin( $(".offer-1-scene"), [[ 2, 0, "offer-1-scene--pin"]] );
// Scene3.add( $(".offer-1-figure"), [
// 	[{ "width": "[25,50]%", "height": "[50,100]vh", "border-radius": "[50,0]px" }, .65, 0.1 ],
// 	[{ "transform": "translateX([-50,0]%) translateY(-50%)" }, .65, 0.15 ]
// ]);

// Scene3.add( $('.site-frame-container'), [
// 	[{ "background-color": "rgba([0,248],[0,248],[0,248],1)" }, .3, 0.65 ]
// ]);
// Scene3.add( $(".offer-1-headline"), [
// 	[{ "transform": "translateY([100,0]%)", "opacity": "[0,1]" }, .15, 1.1 ]
// ]);
// Scene3.add( $(".offer-1-overview"), [
// 	[{ "height": "[0," + $(".offer-1-overview-content").outerHeight() + "]px" }, .25, 1.15 ]
// ]);

// Scene3.add( $(".offer-1-viewline"), [
// 	[{ "transform": "translateY([100,0]%)", "opacity": "[0,1]" }, .25, 1.15 ]
// ], "0.1");



// var Massage__Scene = new enedScroll( $('.offer-2--figure'), trigger1, { selectors: [0, 0], visual: { 
// 	show_selectors: false, show_trigger: false } } );

// Massage__Scene.add( $('.offer-2--figure img'), [
// 	[{"transform": "scale([1,1.35])"}, "100%", 0]
// ]);

var site_text_slider = function( children = [] ){

	this.children = children;
	this.childrenClassName = "slide--item";
	this.parent = null;
	this.onPlay = false;
	this.time = 5500;
	this.interval = null;

	this.currentIndex = 0;
	this.nextIndex = 0;

	this.currentSlide = null;
	this.nextSlide = null;


}

site_text_slider.prototype = {
	setParent: function( parent ){
		this.parent = parent;
		return this;
	},
	setTime: function( time ){
		this.time = time;
		return this;
	},
	setChildrenClassName: function( className ){
		this.childrenClassName = className;
		return this;
	},
	start: function(){
		for( var slider_el in slider_content ){
			var dom_parent = document.createElement("div");
			for( var dom_content in slider_content[slider_el] ){
				var dom_text = document.createElement("h1");
				dom_text.style.fontSize = "51px";
				dom_text.style.color = "#b1afb1";
				dom_text.innerHTML = slider_content[slider_el][dom_content];
				dom_text.className = this.childrenClassName + "-" + dom_content;
				dom_parent.appendChild( dom_text );

			}

			if( slider_el != 0){
				dom_parent.style.height = "0";
			}
			$( this.parent ).append( dom_parent );
		}

		if( this.children.length > 1 )
			var _this = this;
			setTimeout(function(){
				$( _this.parent + " div" ).eq(0).find("h1").addClass("in");
				_this.onPlay = true;
				_this.loop();
			}, 500);

	},
	slideNext: function( e ){

		var slideHeight = 0;

		e.currentIndex = ( e.children.length <= e.currentIndex ) ? 0 : e.currentIndex;
		e.nextIndex = ( e.children.length <= ( e.currentIndex + 1 ) ) ? 0 : ( e.currentIndex + 1 );

		e.currentSlide = $( e.parent + " div").eq( e.currentIndex );
		e.nextSlide = $( e.parent + " div").eq( e.nextIndex );

		for( var slideContent in e.children[ e.currentIndex ] ){
			slideHeight += $("." + e.childrenClassName + "-" + slideContent).outerHeight();
		}

		$(e.currentSlide).find(".in").removeClass("in").addClass("out");
		
		$(e.currentSlide).find(".out").last().one( "transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", function(ev){

				if( ev.originalEvent.propertyName == "opacity" ){

					$(e.currentSlide).find(".out").removeClass("out");
					$(e.currentSlide).css( "height", "0");

					$(e.nextSlide).css( "height", slideHeight + "px");

					for( var slideContent in e.children[ e.currentIndex ] ){
						$(e.nextSlide).find(".slide--item-" + slideContent).removeClass("out").addClass("in");
					}

					e.currentIndex++;

				}
				
		});		
		

	},
	loop: function(){
		this.interval = setInterval( this.slideNext, this.time, this );
	}
};


var slider_content = [
	["Klub fitness", "Stay Fit"],
	["Brak", "Wpisowego"],
	["Treningi", "Personalne"],
	["Zajęcia", "Grupowe"],
	["Masaże", "kinesiotaping"],
];

var site__slider1 = new site_text_slider( slider_content );
site__slider1.setParent(".slider--container").start();


// $('.qb-block').each(function(key, _this){

// 	var QB_BLOCK = new enedScroll( $(_this), trigger1, { selectors: [0, 0], visual: { 
// 		show_selectors: false, show_trigger: false } } );

// 	QB_BLOCK.setPoint(0.01, -0.45, "qb-block");
// 	QB_BLOCK.is( "qb-block", "ENTER AFTER", function(e){
// 		$(_this).addClass("in");
// 	});
// 	QB_BLOCK.is( "qb-block", "BEFORE", function(e){
// 		$(_this).removeClass("in");
// 	});


// });



}); // end dom ready