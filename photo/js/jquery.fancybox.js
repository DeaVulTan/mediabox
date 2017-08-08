/*
 * FancyBox - jQuery Plugin
 * Simple and fancy lightbox alternative
 *
 * Copyright (c) 20010 Janis Skarnelis
 * Examples and documentation at: http://fancybox.net
 *
 * Version: 1.3.0 (02/02/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

;(function($) {

	var tmp, loading, overlay, wrap, outer, inner, content, close, nav_left, nav_right;

	var selectedIndex = 0, selectedOpts = {}, selectedArray = [], currentIndex = 0, currentOpts = {}, currentArray = [];

	var ajaxLoader = null, imgPreloader = new Image, imageRegExp = /\.(jpg|gif|png|bmp|jpeg)(.*)?$/i, swfRegExp = /[^\.]\.(swf)\s*$/i;

	var loadingTimer, loadingFrame = 1;

	var start_pos, final_pos, busy = false, shadow = 20, fx = $Jq.extend($Jq('<div/>')[0], { prop: 0 }), titleh = 0, isIE6 = !$Jq.support.opacity && !window.XMLHttpRequest;

	$Jq.fn.fixPNG = function() {
		return this.each(function () {
			var image = $Jq(this).css('backgroundImage');

			if (image.match(/^url\(["']?(.*\.png)["']?\)$/i)) {
				image = RegExp.$1;
				$Jq(this).css({
					'backgroundImage': 'none',
					'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=" + ($Jq(this).css('backgroundRepeat') == 'no-repeat' ? 'crop' : 'scale') + ", src='" + image + "')"
				}).each(function () {
					var position = $Jq(this).css('position');
					if (position != 'absolute' && position != 'relative')
						$Jq(this).css('position', 'relative');
				}).css('zoom', 1);
			}
		});
	};

	$Jq.fn.fancybox = function(options) {
		$Jq(this).data('fancybox', $Jq.extend({}, options));

		$Jq(this).unbind('click.fb').bind('click.fb', function(e) {
			e.preventDefault();

			if (busy) return;

			busy = true;

			$Jq(this).blur();

			selectedArray	= [];
			selectedIndex	= 0;

			var rel = $Jq(this).attr('rel') || '';

			if (!rel || rel == '' || rel === 'nofollow') {
				selectedArray.push(this);

			} else {
				selectedArray	= $Jq("a[rel=" + rel + "], area[rel=" + rel + "]");
				selectedIndex	= selectedArray.index( this );
			}

			fancybox_start();

			return false;
		});

		return this;
	};

	/*

	Public Methods

	*/

	$Jq.fancybox = function(obj, opts) {
		if (busy) return;

		busy = true;

		selectedArray	= [];
		selectedIndex	= 0;
		if ($Jq.isArray(obj)) {
			for (var i = 0, j = obj.length; i < j; i++) {
				if (typeof obj[i] == 'object') {
					$Jq(obj[i]).data('fancybox', $Jq.extend({}, opts, obj[i]));
				} else {
					obj[i] = $Jq({}).data('fancybox', $Jq.extend({content : obj[i]}, opts));
				}
			}
			selectedArray = jQuery.merge(selectedArray, obj);

		} else {
			if (typeof obj == 'object') {
				$Jq(obj).data('fancybox', $Jq.extend({}, opts, obj));
			} else {
				obj = $Jq({}).data('fancybox', $Jq.extend({content : obj}, opts));
			}

			selectedArray.push(obj);
		}

		fancybox_start();
	};

	$Jq.fancybox.showActivity = function() {
		clearInterval(loadingTimer);

		loading.show();
		loadingTimer = setInterval(fancybox_animate_loading, 66);
	};

	$Jq.fancybox.hideActivity = function() {
		loading.hide();
	};

	$Jq.fancybox.next = function() {
		return $Jq.fancybox.pos( currentIndex + 1);
	};

	$Jq.fancybox.prev = function() {
		return $Jq.fancybox.pos( currentIndex - 1);
	};

	$Jq.fancybox.pos = function(pos) {
		if (busy) return;

		pos = parseInt(pos);

		if (pos > -1 && currentArray.length > pos) {
			selectedIndex = pos;
			fancybox_start();
		}

		if (currentOpts.cyclic && currentArray.length > 1 && pos < 0) {
			selectedIndex = currentArray.length - 1;
			fancybox_start();
		}

		if (currentOpts.cyclic && currentArray.length > 1 && pos >= currentArray.length) {
			selectedIndex = 0;
			fancybox_start();
		}

		return;
	};

	$Jq.fancybox.cancel = function() {
		if (busy) return;

		busy = true;

		$Jq.event.trigger('fancybox-cancel');

		fancybox_abort();

		if (selectedOpts && $Jq.isFunction(selectedOpts.onCancel)) {
			selectedOpts.onCancel(selectedArray, selectedIndex, selectedOpts);
		};

		busy = false;
	};

	// Note: within an iframe use - parent.$Jq.fancybox.close();
	$Jq.fancybox.close = function() {
		if (busy || wrap.is(':hidden')) return;

		busy = true;

		if (currentOpts && $Jq.isFunction(currentOpts.onCleanup)) {
			if (currentOpts.onCleanup(currentArray, currentIndex, currentOpts) === false) {
				busy = false;
				return;
			}
		};

		fancybox_abort();

		$Jq(close.add( nav_left ).add( nav_right )).hide();

		$Jq('#fancybox-title').remove();

		wrap.add(inner).add(overlay).unbind();

		$Jq(window).unbind("resize.fb scroll.fb");
		$Jq(document).unbind('keydown.fb');

		function _cleanup() {
			overlay.fadeOut('fast');

			wrap.hide();

			$Jq.event.trigger('fancybox-cleanup');

			inner.empty();

			if ($Jq.isFunction(currentOpts.onClosed)) {
				currentOpts.onClosed(currentArray, currentIndex, currentOpts);
			}

			currentArray	= selectedOpts	= [];
			currentIndex	= selectedIndex	= 0;
			currentOpts		= selectedOpts	= {};

			busy = false;
		}

		inner.css('overflow', 'hidden');

		if (currentOpts.transitionOut == 'elastic') {
			start_pos = fancybox_get_zoom_from();

			var pos = wrap.position();
			//print_r(wrap);

			if(window.opera)
			{
				final_pos = {
					top		:	pos.top ,
					left	:	pos.left,
					width	:	document.getElementById('fancybox-wrap').getDimensions().width,
					height	:	document.getElementById('fancybox-wrap').getDimensions().height
				};
			}
			else
			{
				final_pos = {
					top		:	pos.top ,
					left	:	pos.left,
					width	:	wrap.width(),
					height	:	wrap.height()
				};
			}
			//print_r(final_pos);

			if (currentOpts.opacity) {
				final_pos.opacity = 1;
			}

			fx.prop = 1;

			$Jq(fx).animate({ prop: 0 }, {
				 duration	: currentOpts.speedOut,
				 easing		: currentOpts.easingOut,
				 step		: fancybox_draw,
				 complete	: _cleanup
			});

		} else {
			wrap.fadeOut( currentOpts.transitionOut == 'none' ? 0 : currentOpts.speedOut, _cleanup);
		}
	};

	$Jq.fancybox.resize = function() {
		if (busy || wrap.is(':hidden')) return;

		busy = true;

		var c = inner.wrapInner("<div style='overflow:auto'></div>").children();
		var h = c.height();

		wrap.css({height:	h + (currentOpts.padding * 2) + titleh});
		inner.css({height:	h});

		c.replaceWith(c.children());

		$Jq.fancybox.center();
	};

	$Jq.fancybox.center = function() {
		busy = true;
		var view	= fancybox_get_viewport();
		var margin	= currentOpts.margin;
		var to		= {};

		to.top	= view[3] + ((view[1] - ((wrap.height() - titleh) + (shadow * 2 ))) * 0.5);
		to.left	= view[2] + ((view[0] - (wrap.width() + (shadow * 2 ))) * 0.5);

		to.top	= Math.max(view[3] + margin, to.top);
		to.left	= Math.max(view[2] + margin, to.left);

		wrap.css(to);

		busy = false;
	};

	/*

	Inner Methods

	*/

	function fancybox_abort() {
		loading.hide();
		imgPreloader.onerror = imgPreloader.onload = null;
		if (ajaxLoader) ajaxLoader.abort();
		tmp.empty();
	};

	function fancybox_error() {
		$Jq.fancybox('<p id="fancybox_error">The requested content cannot be loaded.<br />Please try again later.</p>', {
			'scrolling'		: 'no',
			'padding'		: 20,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none'
		});
	};

	function fancybox_start() {
		fancybox_abort();
		var obj	= selectedArray[ selectedIndex ];

		selectedOpts = $Jq.extend({}, $Jq.fn.fancybox.defaults, (typeof $Jq(obj).data('fancybox') == 'undefined' ? selectedOpts : $Jq(obj).data('fancybox')));

		var href, type, title = obj.title || $Jq(obj).title || selectedOpts.title || '';

		if (obj.nodeName && !selectedOpts.orig) {
			selectedOpts.orig = $Jq(obj).children("img:first").length ? $Jq(obj).children("img:first") : $Jq(obj);
		}

		if (title == '' && selectedOpts.orig) title = selectedOpts.orig.attr('alt');

		if (obj.nodeName && (/^(?:javascript|#)/i).test(obj.href)) {
			href = selectedOpts.href || null;
		} else {
			href = selectedOpts.href || obj.href || null;
		}

		if (selectedOpts.type) {
			type = selectedOpts.type;

			if (!href) href = selectedOpts.content;

		} else if (selectedOpts.content) {
			type	= 'html';

		} else if (href) {
			if (href.match(imageRegExp)) {
				type = 'image';

			} else if (href.match(swfRegExp)) {
				type = 'swf';

			} else if ($Jq(obj).hasClass("iframe")) {
				type = 'iframe';

			} else if (href.match(/#/)) {
				obj = href.substr(href.indexOf("#"));

				type = $Jq(obj).length > 0 ? 'inline' : 'ajax';
			} else {
				type = 'ajax';
			}
		} else {
			type = 'inline';
		}

		selectedOpts.type	= type;
		selectedOpts.href	= href;
		selectedOpts.title	= title;

		if (selectedOpts.autoDimensions && selectedOpts.type !== 'iframe' && selectedOpts.type !== 'swf') {
			selectedOpts.width		= 'auto';
			selectedOpts.height		= 'auto';
		}

		if (selectedOpts.modal) {
			selectedOpts.overlayShow		= true;
			selectedOpts.hideOnOverlayClick	= false;
			selectedOpts.hideOnContentClick	= false;
			selectedOpts.enableEscapeButton	= false;
			selectedOpts.showCloseButton	= false;
		}

		if ($Jq.isFunction(selectedOpts.onStart)) {
			if (selectedOpts.onStart(selectedArray, selectedIndex, selectedOpts) === false) {
				busy = false;
				return;
			}
		};

		tmp.css('padding', (shadow + selectedOpts.padding + selectedOpts.margin));

		$Jq('.fancybox-inline-tmp').unbind('fancybox-cancel').bind('fancybox-change', function() {
			$Jq(this).replaceWith(inner.children());
		});

		switch (type) {
			case 'html' :
				tmp.html( selectedOpts.content );

				fancybox_process_inline();
			break;

			case 'inline' :
				$Jq('<div class="fancybox-inline-tmp" />').hide().insertBefore( $Jq(obj) ).bind('fancybox-cleanup', function() {
					$Jq(this).replaceWith(inner.children());
				}).bind('fancybox-cancel', function() {
					$Jq(this).replaceWith(tmp.children());
				});

				$Jq(obj).appendTo(tmp);

				fancybox_process_inline();
			break;

			case 'image':
				busy = false;

				$Jq.fancybox.showActivity();

				imgPreloader = new Image;

				imgPreloader.onerror = function() {
					fancybox_error();
				}

				imgPreloader.onload = function() {
					imgPreloader.onerror = null;
					imgPreloader.onload = null;
					fancybox_process_image();
				}

				imgPreloader.src = href;

			break;

			case 'swf':
				var str = '';
				var emb = '';

				str += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"><param name="movie" value="' + href + '"></param>';

				$Jq.each(selectedOpts.swf, function(name, val) {
					str += '<param name="' + name + '" value="' + val + '"></param>';
					emb += ' ' + name + '="' + val + '"';
				});

				str += '<embed src="' + href + '" type="application/x-shockwave-flash" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"' + emb + '></embed></object>';

				tmp.html(str);

				fancybox_process_inline();
			break;

			case 'ajax':
				var selector	= href.split('#', 2);
				var data		= selectedOpts.ajax.data || {};

				if (selector.length > 1) {
					href = selector[0];

					typeof data == "string" ? data += '&selector=' + selector[1] : data['selector'] = selector[1];
				}

				busy = false;
				$Jq.fancybox.showActivity();

				ajaxLoader = $Jq.ajax($Jq.extend(selectedOpts.ajax, {
					url		: href,
					data	: data,
					error	: fancybox_error,
					success : function(data, textStatus, XMLHttpRequest) {
						if (ajaxLoader.status == 200) {
							tmp.html( data );
							fancybox_process_inline();
						}
					}
				}));

			break;

			case 'iframe' :
				$Jq('<iframe id="fancybox-frame" allowtransparency="transparent" name="fancybox-frame' + new Date().getTime() + '" frameborder="0" hspace="0" scrolling="' + selectedOpts.scrolling + '" src="' + selectedOpts.href + '"></iframe>').appendTo(tmp);

				fancybox_show();
			break;
		}
	};

	function fancybox_process_image() {
		busy = true;

		selectedOpts.width	= imgPreloader.width;
		selectedOpts.height	= imgPreloader.height;

		$Jq("<img />").attr({
			'id'	: 'fancybox-img',
			'src'	: imgPreloader.src,
			'alt'	: selectedOpts.title
		}).appendTo( tmp );

		fancybox_show();
	};

	function fancybox_process_inline() {
		tmp.width(	selectedOpts.width );
		tmp.height(	selectedOpts.height );

		if (selectedOpts.width	== 'auto') selectedOpts.width	= tmp.width();
		if (selectedOpts.height	== 'auto') selectedOpts.height	= tmp.height();

		fancybox_show();
	};

	function fancybox_show() {
		loading.hide();

		if (wrap.is(":visible") && $Jq.isFunction(currentOpts.onCleanup)) {
			if (currentOpts.onCleanup(currentArray, currentIndex, currentOpts) === false) {
				$Jq.event.trigger('fancybox-cancel');

				busy = false;
				return;
			}
		};

		currentArray	= selectedArray;
		currentIndex	= selectedIndex;
		currentOpts		= selectedOpts;

		inner.get(0).scrollTop	= 0;
		inner.get(0).scrollLeft	= 0;

		if (currentOpts.overlayShow) {
			if (isIE6) {
				$Jq('select:not(#fancybox-tmp select)').filter(function() {
					return this.style.visibility !== 'hidden';
				}).css({'visibility':'hidden'}).one('fancybox-cleanup', function() {
					this.style.visibility = 'inherit';
				});
			}

			overlay.css({
				'background-color'	: currentOpts.overlayColor,
				'opacity'			: currentOpts.overlayOpacity
			}).unbind().show();
		}

		final_pos = fancybox_get_zoom_to();
		
		//fancybox_process_title();

		if (wrap.is(":visible")) {
			$Jq( close.add( nav_left ).add( nav_right ) ).hide();

			var pos = wrap.position();

			start_pos = {
				top		:	pos.top ,
				left	:	pos.left,
				width	:	wrap.width(),
				height	:	wrap.height()
			};

			var equal = (start_pos.width == final_pos.width && start_pos.height == final_pos.height);

			inner.fadeOut(currentOpts.changeFade, function() {
				$Jq.event.trigger('fancybox-change');

				inner.css({
						top			: currentOpts.padding,
						left		: currentOpts.padding,
						width		: Math.max(start_pos.width	- (currentOpts.padding * 2), 1),
						height		: Math.max(start_pos.height	- (currentOpts.padding * 2), 1)
					})
					.empty()
					.css('overflow', 'hidden');

				function finish_resizing() {
					inner.html( tmp.contents() ).fadeIn(currentOpts.changeFade, _finish);
				}

				fx.prop = 0;

				$Jq(fx).animate({ prop: 1 }, {
					 duration	: equal ? 0 : currentOpts.changeSpeed,
					 easing		: currentOpts.easingChange,
					 step		: fancybox_draw,
					 complete	: finish_resizing
				});
			});

			return;
		}

		wrap.css('opacity', 1);

		if (currentOpts.transitionIn == 'elastic') {
			start_pos = fancybox_get_zoom_from();

			inner.css({
					top			: currentOpts.padding,
					left		: currentOpts.padding,
					width		: Math.max(start_pos.width	- (currentOpts.padding * 2), 1),
					height		: Math.max(start_pos.height	- (currentOpts.padding * 2), 1)
				})
				.html( tmp.contents() );

			wrap.css(start_pos).show();
			//alert(currentOpts.toSource());
			//alert(currentOpts.width);
			if(currentOpts.width > 200)
				fancybox_process_title();
			if (currentOpts.opacity) final_pos.opacity = 0;

			fx.prop = 0;

			$Jq(fx).animate({ prop: 1 }, {
				 duration	: currentOpts.speedIn,
				 easing		: currentOpts.easingIn,
				 step		: fancybox_draw,
				 complete	: _finish
			});

		} else {
			inner.css({
					top			: currentOpts.padding,
					left		: currentOpts.padding,
					width		: Math.max(final_pos.width	- (currentOpts.padding * 2), 1),
					height		: Math.max(final_pos.height	- (currentOpts.padding * 2) - titleh, 1)
				})
				.html( tmp.contents() );

			wrap.css( final_pos ).fadeIn( currentOpts.transitionIn == 'none' ? 0 : currentOpts.speedIn, _finish );
		}
	};

	function fancybox_draw(pos) {
		var width	= Math.round(start_pos.width	+ (final_pos.width	- start_pos.width)	* pos);
		var height	= Math.round(start_pos.height	+ (final_pos.height	- start_pos.height)	* pos);

		var top		= Math.round(start_pos.top	+ (final_pos.top	- start_pos.top)	* pos);
		var left	= Math.round(start_pos.left	+ (final_pos.left	- start_pos.left)	* pos);

		wrap.css({
			'width'		: width		+ 'px',
			'height'	: height	+ 'px',
			'top'		: top		+ 'px',
			'left'		: left		+ 'px'
		});

		width	= Math.max(width - currentOpts.padding * 2, 0);
		height	= Math.max(height - (currentOpts.padding * 2 + (titleh * pos)), 0);

		inner.css({
			'width'		: width		+ 'px',
			'height'	: height	+ 'px'
		});

		if (typeof final_pos.opacity !== 'undefined') wrap.css('opacity', (pos < 0.5 ? 0.5 : pos));
	};

	function _finish() {
		inner.css('overflow', overflow = (currentOpts.scrolling == 'auto' ? (currentOpts.type == 'image' || currentOpts.type == 'iframe' || currentOpts.type == 'swf' ? 'hidden' : 'auto') : (currentOpts.scrolling == 'yes' ? 'auto' : 'visible')));

		if (!$Jq.support.opacity) {
			inner.get(0).style.removeAttribute('filter');
			wrap.get(0).style.removeAttribute('filter');
		}

		$Jq('#fancybox-title').show();

		if (currentOpts.hideOnContentClick)	inner.one('click',		$Jq.fancybox.close);
		if (currentOpts.hideOnOverlayClick)	overlay.one('click',	$Jq.fancybox.close);

		if (currentOpts.showCloseButton) close.show();

		fancybox_set_navigation();

		$Jq(window).bind("resize.fb", $Jq.fancybox.center);

		currentOpts.centerOnScroll ? $Jq(window).bind("scroll.fb", $Jq.fancybox.center) : $Jq(window).unbind("scroll.fb");

		if ($Jq.isFunction(currentOpts.onComplete)) currentOpts.onComplete(currentArray, currentIndex, currentOpts);

		busy = false;

		fancybox_preload_images();
	};

	function fancybox_get_zoom_to() {
		var view	= fancybox_get_viewport();
		var to		= {};

		var margin = currentOpts.margin;
		var resize = currentOpts.autoScale;

		var horizontal_space	= (shadow + margin) * 2 ;
		var vertical_space		= (shadow + margin) * 2 ;
		var double_padding		= (currentOpts.padding * 2);

		if (currentOpts.width.toString().indexOf('%') > -1) {
			to.width = ((view[0] * parseFloat(currentOpts.width)) / 100) - (shadow * 2) ;
			resize = false;

		} else {
			to.width = currentOpts.width + double_padding;
		}

		if (currentOpts.height.toString().indexOf('%') > -1) {
			to.height = ((view[1] * parseFloat(currentOpts.height)) / 100) - (shadow * 2);
			resize = false;

		} else {
			to.height = currentOpts.height + double_padding;
		}

		if (resize && (to.width > (view[0] - horizontal_space) || to.height > (view[1] - vertical_space))) {
			if (selectedOpts.type == 'image' || selectedOpts.type == 'swf') {
				horizontal_space	+= double_padding;
				vertical_space		+= double_padding;

				var ratio = Math.min(Math.min( view[0] - horizontal_space, currentOpts.width) / currentOpts.width, Math.min( view[1] - vertical_space, currentOpts.height) / currentOpts.height);

				to.width	= Math.round(ratio * (to.width	- double_padding)) + double_padding;
				to.height	= Math.round(ratio * (to.height	- double_padding)) + double_padding;

			} else {
				to.width	= Math.min(to.width,	(view[0] - horizontal_space));
				to.height	= Math.min(to.height,	(view[1] - vertical_space));
			}
		}

		to.top	= view[3] + ((view[1] - (to.height	+ (shadow * 2 ))) * 0.5);
		to.left	= view[2] + ((view[0] - (to.width	+ (shadow * 2 ))) * 0.5);

		if (currentOpts.autoScale == false) {
			to.top	= Math.max(view[3] + margin, to.top);
			to.left	= Math.max(view[2] + margin, to.left);
		}

		return to;
	};

	function fancybox_get_zoom_from() {
		var orig	= selectedOpts.orig ? $Jq(selectedOpts.orig) : false;
		var from 	= {};

		if (orig && orig.length) {
			var pos = fancybox_get_obj_pos(orig);

			from = {
				width	: (pos.width	+ (currentOpts.padding * 2)),
				height	: (pos.height	+ (currentOpts.padding * 2)),
				top		: (pos.top		- currentOpts.padding - shadow),
				left	: (pos.left		- currentOpts.padding - shadow)
			};

		} else {
			var view = fancybox_get_viewport();

			from = {
				width	: 1,
				height	: 1,
				top		: view[3] + view[1] * 0.5,
				left	: view[2] + view[0] * 0.5
			};
		}
		return from;
	};
	 
	function fancybox_set_navigation() {
		$Jq(document).unbind('keydown.fb').bind('keydown.fb', function(e) {
			if (e.keyCode == 27 && currentOpts.enableEscapeButton) {
				e.preventDefault();
				$Jq.fancybox.close();

			} else if (e.keyCode == 37) {
				e.preventDefault();
				$Jq.fancybox.prev();

			} else if (e.keyCode == 39) {
				e.preventDefault();
				$Jq.fancybox.next();
			}
		});

		if ($Jq.fn.mousewheel) {
			wrap.unbind('mousewheel.fb');

			if (currentArray.length > 1) {
				wrap.bind('mousewheel.fb', function(e, delta) {
					e.preventDefault();

					if (busy || delta == 0) return;

					delta > 0 ? $Jq.fancybox.prev() : $Jq.fancybox.next();
				});
			}
		}

		if (!currentOpts.showNavArrows) return;

		if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex != 0) {
			nav_left.show();
		}

		if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex != (currentArray.length -1)) {
			nav_right.show();
		}
	};

	function fancybox_preload_images() {
		if ((currentArray.length -1) > currentIndex) {
			var href = currentArray[ currentIndex + 1 ].href;

			if (typeof href !== 'undefined' && href.match(imageRegExp)) {
				var objNext = new Image();
				objNext.src = href;
			}
		}

		if (currentIndex > 0) {
			var href = currentArray[ currentIndex - 1 ].href;

			if (typeof href !== 'undefined' && href.match(imageRegExp)) {
				var objNext = new Image();
				objNext.src = href;
			}
		}
	};

	function fancybox_animate_loading() {
		if (!loading.is(':visible')){
			clearInterval(loadingTimer);
			return;
		}

		$Jq('div', loading).css('top', (loadingFrame * -40) + 'px');

		loadingFrame = (loadingFrame + 1) % 12;
	};

	function fancybox_get_viewport() {
		return [ $Jq(window).width(), $Jq(window).height(), $Jq(document).scrollLeft(), $Jq(document).scrollTop() ];
	};

	function fancybox_get_obj_pos(obj) {
		var pos		= obj.offset();

		pos.top		+= parseFloat( obj.css('paddingTop') )	|| 0;
		pos.left	+= parseFloat( obj.css('paddingLeft') )	|| 0;

		pos.top		+= parseFloat( obj.css('border-top-width') )	|| 0;
		pos.left	+= parseFloat( obj.css('border-left-width') )	|| 0;
		if(window.opera)
		{
			var divid = obj.selector;
			var origdivid=divid.substr(1);
			pos.width	= document.getElementById(origdivid).getDimensions().width;
			pos.height	= document.getElementById(origdivid).getDimensions().height;
		}
		else
		{
			pos.width	= obj.width();
			pos.height	= obj.height();
		}

		return pos;
	};

	function fancybox_process_title() {
		$Jq('#fancybox-title').remove();

		titleh = 0;

		if (currentOpts.titleShow == false) return;

		var obj		= currentArray[ currentIndex ];
		var title	= currentOpts.title;

		title = $Jq.isFunction(currentOpts.titleFormat) ? currentOpts.titleFormat(title, currentArray, currentIndex, currentOpts) : fancybox_format_title(title);

		if (!title || title == '') return;

		var width	= final_pos.width - (currentOpts.padding * 2);
		var titlec	= 'fancybox-title-' + currentOpts.titlePosition;

		$Jq('<div id="fancybox-title" class="' + titlec + '" />').css({
			'width'			: width,
			'paddingLeft'	: currentOpts.padding,
			'paddingRight'	: currentOpts.padding
		}).html(title).appendTo('body');

		switch (currentOpts.titlePosition) {
			case 'inside':
				titleh = $Jq("#fancybox-title").outerHeight(true) - currentOpts.padding;
				final_pos.height += titleh;
			break;

			case 'over':
				$Jq('#fancybox-title').css('bottom', currentOpts.padding);
			break;

			default:
				$Jq('#fancybox-title').css('bottom', $Jq("#fancybox-title").outerHeight(true) * -1);
			break;
		}

		$Jq('#fancybox-title').appendTo( outer ).hide();

		if (isIE6) {
			$Jq('#fancybox-title span').fixPNG();
		}
	};

	function fancybox_format_title(title) {
		if (title && title.length) {
			switch (currentOpts.titlePosition) {
				case 'inside':
					return title;
				break;

				case 'over':
					return '<span id="fancybox-title-over">' + title + '</span>';
				break;

				default:
					return '<span id="fancybox-title-wrap"><span id="fancybox-title-left"></span><span id="fancybox-title-main">' + title + '</span><span id="fancybox-title-right"></span></span>';
				break;
			}
		}

		return false;
	};

	function fancybox_init() {
		//alert(managePhotoCommentsPage);
		if ($Jq("#fancybox-wrap").length) return;

		$Jq('body').append(
			tmp			= $Jq('<div id="fancybox-tmp"></div>'),
			loading		= $Jq('<div id="fancybox-loading"><div></div></div>'),
			overlay		= $Jq('<div id="fancybox-overlay"></div>'),
			wrap		= $Jq('<div id="fancybox-wrap"></div>')
		);

		if(managePhotoCommentsPage)
		{
			outer = $Jq('<div id="fancybox-outer"></div>')
				.append('<div class="fancy-bg clsShadow" id="fancy-bg-n"></div><div class="fancy-bg clsShadow" id="fancy-bg-ne"></div><div class="fancy-bg clsShadow" id="fancy-bg-e"></div><div class="fancy-bg clsShadow" id="fancy-bg-se"></div><div class="fancy-bg clsShadow" id="fancy-bg-s"></div><div class="fancy-bg clsShadow" id="fancy-bg-sw"></div><div class="fancy-bg clsShadow" id="fancy-bg-w"></div><div class="fancy-bg clsShadow" id="fancy-bg-nw"></div>')
				.appendTo( wrap );
		}
		else if(photoslidelistmanage)
		{
			outer = $Jq('<div id="fancybox-outer"></div>')
				.append('<div class="fancy-bg clsShadow" id="fancy-bg-n"></div><div class="fancy-bg clsShadow" id="fancy-bg-ne"></div><div class="fancy-bg clsShadow" id="fancy-bg-e"></div><div class="fancy-bg clsShadow" id="fancy-bg-se"></div><div class="fancy-bg clsShadow" id="fancy-bg-s"></div><div class="fancy-bg clsShadow" id="fancy-bg-sw"></div><div class="fancy-bg clsShadow" id="fancy-bg-w"></div><div class="fancy-bg clsShadow" id="fancy-bg-nw"></div>')
				.appendTo( wrap );
		}
		else if(createmoviemaker)
		{
			outer = $Jq('<div id="fancybox-outer"></div>')
				.append('<div class="fancy-bg clsShadow" id="fancy-bg-n"></div><div class="fancy-bg clsShadow" id="fancy-bg-ne"></div><div class="fancy-bg clsShadow" id="fancy-bg-e"></div><div class="fancy-bg clsShadow" id="fancy-bg-se"></div><div class="fancy-bg clsShadow" id="fancy-bg-s"></div><div class="fancy-bg clsShadow" id="fancy-bg-sw"></div><div class="fancy-bg clsShadow" id="fancy-bg-w"></div><div class="fancy-bg clsShadow" id="fancy-bg-nw"></div>')
				.appendTo( wrap );
		}
		else
		{
				outer = $Jq('<div id="fancybox-outer"></div>')
				.append('<div class="fancy-bg" id="fancy-bg-n"></div><div class="fancy-bg" id="fancy-bg-ne"></div><div class="fancy-bg" id="fancy-bg-e"></div><div class="fancy-bg" id="fancy-bg-se"></div><div class="fancy-bg" id="fancy-bg-s"></div><div class="fancy-bg" id="fancy-bg-sw"></div><div class="fancy-bg" id="fancy-bg-w"></div><div class="fancy-bg" id="fancy-bg-nw"></div>')
				.appendTo( wrap );
		}
		if(managePhotoCommentsPage)
		{
				outer.append(
					inner		= $Jq('<div id="fancybox-inner"></div>'),
					close		= $Jq('<a id="fancybox-close" class="clsPhotoVideoEditLinks clsmanagePhotoCommentsPage" title="Close"></a>'),
		
					nav_left	= $Jq('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
					nav_right	= $Jq('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
				);
		}
		else if(photoslidelistmanage)
		{
				outer.append(
					inner		= $Jq('<div id="fancybox-inner"></div>'),
					close		= $Jq('<a id="fancybox-close" class="clsPhotoVideoEditLinks clsphotoslidelistmanage" title="Close"></a>'),
		
					nav_left	= $Jq('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
					nav_right	= $Jq('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
				);
		}
		else if(createmoviemaker)
		{
				outer.append(
					inner		= $Jq('<div id="fancybox-inner"></div>'),
					close		= $Jq('<a id="fancybox-close" class="clsPhotoVideoEditLinks clsphotoslidelistmanage" title="Close"></a>'),
		
					nav_left	= $Jq('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
					nav_right	= $Jq('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
				);
		}
		else
		{
			outer.append(
				inner		= $Jq('<div id="fancybox-inner"></div>'),
				close		= $Jq('<a id="fancybox-close" class="clsPhotoVideoEditLinks" title="Close"></a>'),
	
				nav_left	= $Jq('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
				nav_right	= $Jq('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
			);
		}

		close.click($Jq.fancybox.close);
		loading.click($Jq.fancybox.cancel);

		nav_left.click(function(e) {
			e.preventDefault();
			$Jq.fancybox.prev();
		});

		nav_right.click(function(e) {
			e.preventDefault();
			$Jq.fancybox.next();
		});

		if (!$Jq.support.opacity) {
			outer.find('.fancy-bg').fixPNG();
		}

		if (isIE6) {
			$Jq(close.add('.fancy-ico').add('div', loading)).fixPNG();

			overlay.get(0).style.setExpression('height',	"document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px'");
			loading.get(0).style.setExpression('top',		"(-20 + (document.documentElement.clientHeight ? document.documentElement.clientHeight/2 : document.body.clientHeight/2 ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop )) + 'px'");

			outer.prepend('<iframe id="fancybox-hide-sel-frame" src="javascript:\'\';" scrolling="no" frameborder="0" ></iframe>');
		}
	};

	$Jq.fn.fancybox.defaults = {
		padding				:	10,
		margin				:	20,
		opacity				:	false,
		modal				:	false,
		cyclic				:	false,
		scrolling			:	'auto',	// 'auto', 'yes' or 'no'

		width				:	560,
		height				:	340,

		autoScale			:	true,
		autoDimensions		:	true,
		centerOnScroll		:	false,

		ajax				:	{},
		swf					:	{ wmode: 'transparent' },

		hideOnOverlayClick	:	true,
		hideOnContentClick	:	false,

		overlayShow			:	true,
		overlayOpacity		:	0.3,
		overlayColor		:	'#666',

		titleShow			:	true,
		titlePosition		:	'outside',	// 'outside', 'inside' or 'over'
		titleFormat			:	null,

		transitionIn		:	'fade',	// 'elastic', 'fade' or 'none'
		transitionOut		:	'fade',	// 'elastic', 'fade' or 'none'

		speedIn				:	450,
		speedOut			:	450,

		changeSpeed			:	300,
		changeFade			:	'fast',

		easingIn			:	'swing',
		easingOut			:	'swing',

		showCloseButton		:	true,
		showNavArrows		:	true,
		enableEscapeButton	:	true,

		onStart				:	null,
		onCancel			:	null,
		onComplete			:	null,
		onCleanup			:	null,
		onClosed			:	null
	};

	$Jq(document).ready(function() {
		fancybox_init();
	});

})(jQuery);