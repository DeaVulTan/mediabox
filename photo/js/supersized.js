/*
Supersized - Fullscreen Slideshow jQuery Plugin
By Sam Dunn (www.buildinternet.com // www.onemightyroar.com)
Version: supersized.2.0.js // Relase Date: 5/7/09
Website: www.buildinternet.com/project/supersized
Thanks to Aen for preloading, fade effect, & vertical centering
*/

(function($){

	//Resize image on ready or resize
	$Jq.fn.supersized = function() {
		$Jq.inAnimation = false;
		$Jq.paused = false;
		var options = $.extend($Jq.fn.supersized.defaults, $Jq.fn.supersized.options);

		$Jq(window).bind("load", function(){
			$Jq('#loading').hide();
			$Jq('#supersize').fadeIn('fast');
			$Jq('#content').hide("slide", { direction: "down" }, 'slow').css('top', 480);

			$Jq('#content').mouseover(function() {
				$Jq('#content').show();
		    });

			$Jq('#slideContainer').mouseout(function() {
			   if(!$Jq.paused)
				$Jq('#content').hide();
			});
			$Jq('#slideContainer').mouseover(function() {
				$Jq('#content').show();
			});

			if ($Jq('#slideshow .activeslide').length == 0) $Jq('#supersize a:first').addClass('activeslide');
			if (options.slide_captions == 1) $Jq('#slidecaption').html($Jq('#supersize .activeslide').find('img').attr('title'));
			if (options.navigation == 0) $Jq('#navigation').hide();
			//Slideshow
			if (options.slideshow == 1){
				if (options.slide_counter == 1){ //Initiate slide counter if active
					$Jq('#slidecounter .slidenumber').html(1);
	    			$Jq('#slidecounter .totalslides').html($Jq("#supersize > *").size());
	    		}
				slideshow_interval = setInterval("nextslide()", options.slide_interval);
				if (options.navigation == 1){ //Skip if no navigation
					$Jq('#navigation a').click(function(){
   						$Jq(this).blur();
   						return false;
   					});
					//Slide Navigation
				    $Jq('#nextslide').click(function() {
				    	if($Jq.paused) return false; if($Jq.inAnimation) return false;
					    clearInterval(slideshow_interval);
					    nextslide();
					    slideshow_interval = setInterval(nextslide, options.slide_interval);
					    return false;
				    });
				    $Jq('#prevslide').click(function() {
				    	if($Jq.paused) return false; if($Jq.inAnimation) return false;
				        clearInterval(slideshow_interval);
				        prevslide();
				        slideshow_interval = setInterval(nextslide, options.slide_interval);
				        return false;
				    });
					$Jq('#nextslide img').hover(function() {
						if($Jq.paused == true) return false;
					   	$Jq(this).attr("src", forward_img);
					}, function(){
						if($Jq.paused == true) return false;
					    $Jq(this).attr("src", forward_dull_img);
					});
					$Jq('#prevslide img').hover(function() {
						if($Jq.paused == true) return false;
					    $Jq(this).attr("src", back_img);
					}, function(){
						if($Jq.paused == true) return false;
					    $Jq(this).attr("src", back_dull_img);
					});

				    //Play/Pause Button
				    $Jq('#pauseplay').click(function() {
				    	if($Jq.inAnimation) return false;
				    	var src = ($Jq(this).find('img').attr("src") === play_img) ? pause_img : play_img;
      					if (src == play_img){
      						$Jq(this).find('img').attr("src", play_img);
      						$Jq.paused = false;
					        slideshow_interval = setInterval(nextslide, options.slide_interval);
				        }else{
				        	$Jq(this).find('img').attr("src", pause_img);
				        	clearInterval(slideshow_interval);
				        	$Jq.paused = true;
				        }
      					$Jq(this).find('img').attr("src", src);
					    return false;
				    });
				    $Jq('#pauseplay').mouseover(function() {
				    	var imagecheck = ($Jq(this).find('img').attr("src") === play_dull_img);
				    	if (imagecheck){
      						$Jq(this).find('img').attr("src", play_img);
				        }else{
				        	$Jq(this).find('img').attr("src", pause_img);
				        }
				    });

				    $Jq('#pauseplay').mouseout(function() {
				    	var imagecheck = ($Jq(this).find('img').attr("src") === play_img);
				    	if (imagecheck){
      						$Jq(this).find('img').attr("src", play_dull_img);
				        }else{
				        	$Jq(this).find('img').attr("src", pause_dull_img);
				        }
				        return false;
				    });

				}
			}
		});

		$Jq(document).ready(function() {
			$Jq('#supersize').resizenow();
		});

		//Pause when hover on image
		$Jq('#supersize > *').hover(function() {
            if($Jq('#content').css("display") != "block" && !$Jq.paused)
			$Jq('#content').show("slide", { direction: "down" }, 'slow').css('top', 440);
	   		if (options.slideshow == 1 && options.pause_hover == 1){
	   			if(!($Jq.paused) && options.navigation == 1){
	   				$Jq('#pauseplay > img').attr("src", pause_img);
	   				clearInterval(slideshow_interval);
	   			}
	   		}
	   		original_title = $Jq(this).find('img').attr("title");
	   		if($Jq.inAnimation) return false; else $Jq(this).find('img').attr("title","");
	   	}, function() {
			if (options.slideshow == 1 && options.pause_hover == 1){
				if(!($Jq.paused) && options.navigation == 1){
					$Jq('#pauseplay > img').attr("src", pause_dull_img);
					slideshow_interval = setInterval(nextslide, options.slide_interval);
				}
			}
			$Jq(this).find('img').attr("title", original_title);
	   	});

		$Jq(window).bind("resize", function(){
    		$Jq('#supersize').resizenow();
		});

		$Jq('#supersize').hide();
		//$Jq('#content').hide();
		$Jq('#content').hide("slide", { direction: "down" }, 'slow').css('top', 440);
	};

	//Adjust image size
	$Jq.fn.resizenow = function() {
		var options = $Jq.extend($Jq.fn.supersized.defaults, $Jq.fn.supersized.options);
	  	return this.each(function() {

			//Define image ratio
			var ratio = options.startheight/options.startwidth;

			//Gather browser and current image size
			var imagewidth = $Jq(this).width();
			var imageheight = $Jq(this).height();
			var browserwidth = $Jq(window).width();
			var browserheight = $Jq(window).height();
			var offset;

			/*//Resize image to proper ratio
			if ((browserheight/browserwidth) > ratio){
			    $Jq(this).height(browserheight);
			    $Jq(this).width(browserheight / ratio);
			    $Jq(this).children().height(browserheight);
			    $Jq(this).children().width(browserheight / ratio);
			} else {
			    $Jq(this).width(browserwidth);
			    $Jq(this).height(browserwidth * ratio);
			    $Jq(this).children().width(browserwidth);
			    $Jq(this).children().height(browserwidth * ratio);
			}
			if (options.vertical_center == 1){
				$Jq(this).children().css('left', (browserwidth - $Jq(this).width())/2);
				$Jq(this).children().css('top', (browserheight - $Jq(this).height())/2);
			}*/
			return false;
		});
	};

	$Jq.fn.supersized.defaults = {
			startwidth: 4,
			startheight: 3,
			vertical_center: 1,
			slideshow: 1,
			navigation:1,
			transition: 1, //0-None, 1-Fade, 2-slide top, 3-slide right, 4-slide bottom, 5-slide left
			pause_hover: 0,
			slide_counter: 1,
			slide_captions: 1,
			slide_interval: 5000
	};

})(jQuery);

	//Slideshow Next Slide
	function nextslide() {
		if($Jq.inAnimation) return false;
		else $Jq.inAnimation = true;
	    var options = $Jq.extend($Jq.fn.supersized.defaults, $Jq.fn.supersized.options);
	    var currentslide = $Jq('#supersize .activeslide');
	    currentslide.removeClass('activeslide');

	    if ( currentslide.length == 0 ) currentslide = $Jq('#supersize a:last');
		//alert( currentslide.next().n());

	    var nextslide =  currentslide.next().length ? currentslide.next() : $Jq('#supersize a:first');
	    var prevslide =  nextslide.prev().length ? nextslide.prev() : $Jq('#supersize a:last');


		//Display slide counter
		if (options.slide_counter == 1){
			var slidecount = $Jq('#slidecounter .slidenumber').html();
			currentslide.next().length ? slidecount++ : slidecount = 1;
		    $Jq('#slidecounter .slidenumber').html(slidecount);
		}

		$Jq('.prevslide').removeClass('prevslide');
		prevslide.addClass('prevslide');

		//Captions require img in <a>
	    if (options.slide_captions == 1) $Jq('#slidecaption').html($Jq(nextslide).find('img').attr('title'));

	    nextslide.hide().addClass('activeslide')
	    	if (options.transition == 0){
	    		nextslide.show(); $Jq.inAnimation = false;
	    	}
	    	if (options.transition == 1){
	    		nextslide.fadeIn(500, function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 2){
	    		nextslide.show("slide", { direction: "up" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 3){
	    		nextslide.show("slide", { direction: "right" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 4){
	    		nextslide.show("slide", { direction: "down" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 5){
	    		nextslide.show("slide", { direction: "left" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}

	    $Jq('#supersize').resizenow();//Fix for resize mid-transition

	}

	//Slideshow Previous Slide
	function prevslide() {
		if($Jq.inAnimation) return false;
		else $Jq.inAnimation = true;
	    var options = $Jq.extend($Jq.fn.supersized.defaults, $Jq.fn.supersized.options);
	    var currentslide = $Jq('#supersize .activeslide');
	    currentslide.removeClass('activeslide');

	    if ( currentslide.length == 0 ) currentslide = $Jq('#supersize a:first');

	    var nextslide =  currentslide.prev().length ? currentslide.prev() : $Jq('#supersize a:last');
	    var prevslide =  nextslide.next().length ? nextslide.next() : $Jq('#supersize a:first');

		//Display slide counter
		if (options.slide_counter == 1){
			var slidecount = $Jq('#slidecounter .slidenumber').html();
			currentslide.prev().length ? slidecount-- : slidecount = $Jq("#supersize > *").size();
		    $Jq('#slidecounter .slidenumber').html(slidecount);
		}

		$Jq('.prevslide').removeClass('prevslide');
		prevslide.addClass('prevslide');

		//Captions require img in <a>
	    if (options.slide_captions == 1) $Jq('#slidecaption').html($Jq(nextslide).find('img').attr('title'));

	    nextslide.hide().addClass('activeslide')
	    	if (options.transition == 0){
	    		nextslide.show(); $Jq.inAnimation = false;
	    	}
	    	if (options.transition == 1){
	    		nextslide.fadeIn(750, function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 2){
	    		nextslide.show("slide", { direction: "down" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 3){
	    		nextslide.show("slide", { direction: "left" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 4){
	    		nextslide.show("slide", { direction: "up" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}
	    	if (options.transition == 5){
	    		nextslide.show("slide", { direction: "right" }, 'slow', function(){$Jq.inAnimation = false;});
	    	}

	    	$Jq('#supersize').resizenow();//Fix for resize mid-transition
	}
