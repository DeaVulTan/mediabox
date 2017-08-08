/*
 * 	loopedSlider 0.5.6 - jQuery plugin
 *	written by Nathan Searles	
 *	http://nathansearles.com/loopedslider/
 *
 *	Copyright (c) 2009 Nathan Searles (http://nathansearles.com/)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *	Compatible with jQuery 1.3.2+
 *
 */

/*
 *	markup example for $Jq("#loopedSlider").loopedSlider();
 *
 *	<div id="loopedSlider">	
 *		<div class="container">
 *			<div class="slides">
 *				<div><img src="01.jpg" alt="" /></div>
 *				<div><img src="02.jpg" alt="" /></div>
 *				<div><img src="03.jpg" alt="" /></div>
 *				<div><img src="04.jpg" alt="" /></div>
 *			</div>
 *		</div>
 *		<a href="#" class="previous">previous</a>
 *		<a href="#" class="next">next</a>	
 *	</div>
 *
*/

if(typeof jQuery != 'undefined') {
	jQuery(function($) {
		$Jq.fn.extend({
			loopedSlider: function(options) {
				var settings = $Jq.extend({}, $Jq.fn.loopedSlider.defaults, options);
			
				return this.each(
					function() {
					if($Jq.fn.jquery < '1.3.2') {return;}
					var $t = $Jq(this);
					var o = $Jq.metadata ? $Jq.extend({}, settings, $t.metadata()) : settings;
					
					var distance = 0;
					var times = 1;
					var slides = $Jq(o.slides,$t).children().size();
					var width = $Jq(o.slides,$t).children().outerWidth();
					var position = 0;
					var active = false;
					var number = 0;
					var interval = 0;
					var restart = 0;
					var pagination = $Jq("."+o.pagination+" li a",$t);

					if(o.addPagination && !$Jq(pagination).length){
						var buttons = slides;
						$Jq($t).append("<ul class="+o.pagination+">");
						$Jq(o.slides,$t).children().each(function(){
							if (number<buttons) {
								$Jq("."+o.pagination,$t).append("<li><a rel="+(number+1)+" href=\"#\" >"+(number+1)+"</a></li>");
								number = number+1;
							} else {
								number = 0;
								return false;
							}
							$Jq("."+o.pagination+" li a:eq(0)",$t).parent().addClass("active");
						});
						pagination = $Jq("."+o.pagination+" li a",$t);
					} else {
						$Jq(pagination,$t).each(function(){
							number=number+1;
							$Jq(this).attr("rel",number);
							$Jq(pagination.eq(0),$t).parent().addClass("active");
						});
					}

					if (slides===1) {
						$Jq(o.slides,$t).children().css({position:"absolute",left:position});
						return;
					}

					$Jq(o.slides,$t).css({width:(slides*width)});

					$Jq(o.slides,$t).children().each(function(){
						$Jq(this).css({position:"absolute",left:position,display:"block"});
						position=position+width;
					});

					$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({position:"absolute",left:-width});

					if (slides>3) {
						$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({position:"absolute",left:-width});
					}

					if(o.autoHeight){autoHeight(times);}

					$Jq(".next",$t).click(function(){
						if(active===false) {
							animate("next",true);
							if(o.autoStart){
								if (o.restart) {autoStart();}
								else {clearInterval(sliderIntervalID);}
							}
						} return false;
					});

					$Jq(".previous",$t).click(function(){
						if(active===false) {	
							animate("prev",true);
							if(o.autoStart){
								if (o.restart) {autoStart();}
								else {clearInterval(sliderIntervalID);}
							}
						} return false;
					});

					if (o.containerClick) {
						$Jq(o.container,$t).click(function(){
							if(active===false) {
								animate("next",true);
								if(o.autoStart){
									if (o.restart) {autoStart();}
									else {clearInterval(sliderIntervalID);}
								}
							} return false;
						});
					}

					$Jq(pagination,$t).click(function(){
						if ($Jq(this).parent().hasClass("active")) {return false;}
						else {
							times = $Jq(this).attr("rel");
							$Jq(pagination,$t).parent().siblings().removeClass("active");
							$Jq(this).parent().addClass("active");
							animate("fade",times);
							if(o.autoStart){
								if (o.restart) {autoStart();}
								else {clearInterval(sliderIntervalID);}
							}
						} return false;
					});

					if (o.autoStart) {
						sliderIntervalID = setInterval(function(){
							if(active===false) {animate("next",true);}
						},o.autoStart);
						function autoStart() {
							if (o.restart) {
							clearInterval(sliderIntervalID,interval);
							clearTimeout(restart);
								restart = setTimeout(function() {
									interval = setInterval(	function(){
										animate("next",true);
									},o.autoStart);
								},o.restart);
							} else {
								sliderIntervalID = setInterval(function(){
									if(active===false) {animate("next",true);}
								},o.autoStart);
							}
						};
					}

					function current(times) {
						if(times===slides+1){times = 1;}
						if(times===0){times = slides;}
						$Jq(pagination,$t).parent().siblings().removeClass("active");
						$Jq(pagination+"[rel='" + (times) + "']",$t).parent().addClass("active");
					};

					function autoHeight(times) {
						if(times===slides+1){times=1;}
						if(times===0){times=slides;}	
						var getHeight = $Jq(o.slides,$t).children(":eq("+(times-1)+")",$t).outerHeight();
						$Jq(o.container,$t).animate({height: getHeight},o.autoHeight);					
					};		

					function animate(dir,clicked){	
						active = true;	
						switch(dir){
							case "next":
								times = times+1;
								distance = (-(times*width-width));
								current(times);
								if(o.autoHeight){autoHeight(times);}
								if(slides<3){
									if (times===3){$Jq(o.slides,$t).children(":eq(0)").css({left:(slides*width)});}
									if (times===2){$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({position:"absolute",left:width});}
								}
								$Jq(o.slides,$t).animate({left: distance}, o.slidespeed,function(){
									if (times===slides+1) {
										times = 1;
										$Jq(o.slides,$t).css({left:0},function(){$Jq(o.slides,$t).animate({left:distance})});							
										$Jq(o.slides,$t).children(":eq(0)").css({left:0});
										$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({ position:"absolute",left:-width});				
									}
									if (times===slides) $Jq(o.slides,$t).children(":eq(0)").css({left:(slides*width)});
									if (times===slides-1) $Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({left:(slides*width-width)});
									active = false;
								});					
								break; 
							case "prev":
								times = times-1;
								distance = (-(times*width-width));
								current(times);
								if(o.autoHeight){autoHeight(times);}
								if (slides<3){
									if(times===0){$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({position:"absolute",left:(-width)});}
									if(times===1){$Jq(o.slides,$t).children(":eq(0)").css({position:"absolute",left:0});}
								}
								$Jq(o.slides,$t).animate({left: distance}, o.slidespeed,function(){
									if (times===0) {
										times = slides;
										$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({position:"absolute",left:(slides*width-width)});
										$Jq(o.slides,$t).css({left: -(slides*width-width)});
										$Jq(o.slides,$t).children(":eq(0)").css({left:(slides*width)});
									}
									if (times===2 ) $Jq(o.slides,$t).children(":eq(0)").css({position:"absolute",left:0});
									if (times===1) $Jq(o.slides,$t).children(":eq("+ (slides-1) +")").css({position:"absolute",left:-width});
									active = false;
								});
								break;
							case "fade":
								times = [times]*1;
								distance = (-(times*width-width));
								current(times);
								if(o.autoHeight){autoHeight(times);}
								$Jq(o.slides,$t).children().fadeOut(o.fadespeed, function(){
									$Jq(o.slides,$t).css({left: distance});
									$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({left:slides*width-width});
									$Jq(o.slides,$t).children(":eq(0)").css({left:0});
									if(times===slides){$Jq(o.slides,$t).children(":eq(0)").css({left:(slides*width)});}
									if(times===1){$Jq(o.slides,$t).children(":eq("+(slides-1)+")").css({ position:"absolute",left:-width});}
									$Jq(o.slides,$t).children().fadeIn(o.fadespeed);
									active = false;
								});
								break; 
							default:
								break;
							}					
						};
					}
				);
			}
		});
		$Jq.fn.loopedSlider.defaults = {
			container: ".container", //Class/id of main container. You can use "#container" for an id.
			slides: ".slides", //Class/id of slide container. You can use "#slides" for an id.
			pagination: "pagination", //Class name of parent ul for numbered links. Don't add a "." here.
			containerClick: true, //Click slider to goto next slide? true/false
			autoStart: 0, //Set to positive number for true. This number will be the time between transitions.
			restart: 0, //Set to positive number for true. Sets time until autoStart is restarted.
			slidespeed: 300, //Speed of slide animation, 1000 = 1second.
			fadespeed: 200, //Speed of fade animation, 1000 = 1second.
			autoHeight: 0, //Set to positive number for true. This number will be the speed of the animation.
			addPagination: false //Add pagination links based on content? true/false
		};
	});
}