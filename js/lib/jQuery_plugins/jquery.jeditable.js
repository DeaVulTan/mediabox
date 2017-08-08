/*
 * Jeditable - jQuery in place edit plugin
 *
 * Copyright (c) 2006-2009 Mika Tuupola, Dylan Verheul
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/jeditable
 *
 * Based on editable by Dylan Verheul <dylan_at_dyve.net>:
 *    http://www.dyve.net/jquery/?editable
 *
 */

/**
  * Version 1.7.1
  *
  * ** means there is basic unit tests for this parameter.
  *
  * @name  Jeditable
  * @type  jQuery
  * @param String  target             (POST) URL or function to send edited content to **
  * @param Hash    options            additional options
  * @param String  options[method]    method to use to send edited content (POST or PUT) **
  * @param Function options[callback] Function to run after submitting edited content **
  * @param String  options[name]      POST parameter name of edited content
  * @param String  options[id]        POST parameter name of edited div id
  * @param Hash    options[submitdata] Extra parameters to send when submitting edited content.
  * @param String  options[type]      text, textarea or select (or any 3rd party input type) **
  * @param Integer options[rows]      number of rows if using textarea **
  * @param Integer options[cols]      number of columns if using textarea **
  * @param Mixed   options[height]    'auto', 'none' or height in pixels **
  * @param Mixed   options[width]     'auto', 'none' or width in pixels **
  * @param String  options[loadurl]   URL to fetch input content before editing **
  * @param String  options[loadtype]  Request type for load url. Should be GET or POST.
  * @param String  options[loadtext]  Text to display while loading external content.
  * @param Mixed   options[loaddata]  Extra parameters to pass when fetching content before editing.
  * @param Mixed   options[data]      Or content given as paramameter. String or function.**
  * @param String  options[indicator] indicator html to show when saving
  * @param String  options[tooltip]   optional tooltip text via title attribute **
  * @param String  options[event]     jQuery event such as 'click' of 'dblclick' **
  * @param String  options[submit]    submit button value, empty means no button **
  * @param String  options[cancel]    cancel button value, empty means no button **
  * @param String  options[cssclass]  CSS class to apply to input form. 'inherit' to copy from parent. **
  * @param String  options[style]     Style to apply to input form 'inherit' to copy from parent. **
  * @param String  options[select]    true or false, when true text is highlighted ??
  * @param String  options[placeholder] Placeholder text or html to insert when element is empty. **
  * @param String  options[onblur]    'cancel', 'submit', 'ignore' or function ??
  *
  * @param Function options[onsubmit] function(settings, original) { ... } called before submit
  * @param Function options[onreset]  function(settings, original) { ... } called before reset
  * @param Function options[onerror]  function(settings, original, xhr) { ... } called on error
  *
  * @param Hash    options[ajaxoptions]  jQuery Ajax options. See docs.jquery.com.
  *
  */

(function($Jq) {

    $Jq.fn.editable = function(target, options) {
        if ('disable' == target) {
            $Jq(this).data('disabled.editable', true);
            return;
        }
        if ('enable' == target) {
            $Jq(this).data('disabled.editable', false);
            return;
        }
        if ('destroy' == target) {
            $Jq(this)
                .unbind($Jq(this).data('event.editable'))
                .removeData('disabled.editable')
                .removeData('event.editable');
            return;
        }

        var settings = $Jq.extend({}, $Jq.fn.editable.defaults, {target:target}, options);

        /* setup some functions */
        var plugin   = $Jq.editable.types[settings.type].plugin || function() { };
        var submit   = $Jq.editable.types[settings.type].submit || function() { };
        var buttons  = $Jq.editable.types[settings.type].buttons
                    || $Jq.editable.types['defaults'].buttons;
        var content  = $Jq.editable.types[settings.type].content
                    || $Jq.editable.types['defaults'].content;
        var element  = $Jq.editable.types[settings.type].element
                    || $Jq.editable.types['defaults'].element;
        var reset    = $Jq.editable.types[settings.type].reset
                    || $Jq.editable.types['defaults'].reset;
        var callback = settings.callback || function() { };
        var onedit   = settings.onedit   || function() { };
        var onsubmit = settings.onsubmit || function() { };
        var onreset  = settings.onreset  || function() { };
        var onerror  = settings.onerror  || reset;

        /* show tooltip */
        if (settings.tooltip) {
            $Jq(this).attr('title', settings.tooltip);
        }

        settings.autowidth  = 'auto' == settings.width;
        settings.autoheight = 'auto' == settings.height;

        return this.each(function() {
            /* save this to self because this changes when scope changes */
            var self = this;
            /* inlined block elements lose their width and height after first edit */
            /* save them for later use as workaround */
            var savedwidth  = $Jq(self).width();
            var savedheight = $Jq(self).height();

            /* save so it can be later used by $Jq.editable('destroy') */
            $Jq(this).data('event.editable', settings.event);

            /* if element is empty add something clickable (if requested) */
            if (!$Jq.trim($Jq(this).html())) {
                $Jq(this).html(settings.placeholder);
            }

            $Jq(this).bind(settings.event, function(e) {

                /* abort if disabled for this element */
                if (true === $Jq(this).data('disabled.editable')) {
                    return;
                }

                /* prevent throwing an exeption if edit field is clicked again */
                if (self.editing) {
                    return;
                }

                /* abort if onedit hook returns false */
                if (false === onedit.apply(this, [settings, self])) {
                   return;
                }
                //ADDED BY Uzdc TO fix THE ISSUE ON CLICKING THE INDICATOR
				if($Jq(this).html().toLowerCase() == settings.indicator)
        		{
        			return;
        		}
                /* prevent default action and bubbling */
                e.preventDefault();
                e.stopPropagation();

                /* remove tooltip */
                if (settings.tooltip) {
                    $Jq(self).removeAttr('title');
                }

                /* figure out how wide and tall we are, saved width and height */
                /* are workaround for http://dev.jquery.com/ticket/2190 */
                if (0 == $Jq(self).width()) {
                    //$Jq(self).css('visibility', 'hidden');
                    settings.width  = savedwidth;
                    settings.height = savedheight;
                } else {
                    if (settings.width != 'none') {
                        settings.width =
                            settings.autowidth ? $Jq(self).width()  : settings.width;
                    }
                    if (settings.height != 'none') {
                        settings.height =
                            settings.autoheight ? $Jq(self).height() : settings.height;
                    }
                }
                //$Jq(this).css('visibility', '');

                /* remove placeholder text, replace is here because of IE */
                if ($Jq(this).html().toLowerCase().replace(/(;|")/g, '') ==
                    settings.placeholder.toLowerCase().replace(/(;|")/g, '')) {
                        $Jq(this).html('');
                }

                self.editing    = true;
                self.revert     = $Jq(self).html();
                $Jq(self).html('');

                /* create the form object */
                var form = $Jq('<form />');

                /* apply css or style or both */
                if (settings.cssclass) {
                    if ('inherit' == settings.cssclass) {
                        form.attr('class', $Jq(self).attr('class'));
                    } else {
                        form.attr('class', settings.cssclass);
                    }
                }

                if (settings.style) {
                    if ('inherit' == settings.style) {
                        form.attr('style', $Jq(self).attr('style'));
                        /* IE needs the second line or display wont be inherited */
                        form.css('display', $Jq(self).css('display'));
                    } else {
                        form.attr('style', settings.style);
                    }
                }

                /* add main input element to form and store it in input */
                var input = element.apply(form, [settings, self]);

                /* set input content via POST, GET, given data or existing value */
                var input_content;

                if (settings.loadurl) {
                    var t = setTimeout(function() {
                        input.disabled = true;
                        content.apply(form, [settings.loadtext, settings, self]);
                    }, 100);

                    var loaddata = {};
                    loaddata[settings.id] = self.id;
                    if ($Jq.isFunction(settings.loaddata)) {
                        $Jq.extend(loaddata, settings.loaddata.apply(self, [self.revert, settings]));
                    } else {
                        $Jq.extend(loaddata, settings.loaddata);
                    }
                    $Jq.ajax({
                       type : settings.loadtype,
                       url  : settings.loadurl,
                       data : loaddata,
                       async : false,
                       success: function(result) {
                          window.clearTimeout(t);
                          input_content = result;
                          input.disabled = false;
                       }
                    });
                } else if (settings.data) {
                    input_content = settings.data;
                    if ($Jq.isFunction(settings.data)) {
                        input_content = settings.data.apply(self, [self.revert, settings]);
                    }
                } else {
                    input_content = self.revert;
                }
                content.apply(form, [input_content, settings, self]);

                input.attr('name', settings.name);

                /* add buttons to the form */
                buttons.apply(form, [settings, self]);

                /* add created form to self */
                $Jq(self).append(form);

                /* attach 3rd party plugin if requested */
                plugin.apply(form, [settings, self]);

                /* focus to first visible form element */
                $Jq(':input:visible:enabled:first', form).focus();

                /* highlight input contents when requested */
                if (settings.select) {
                    input.select();
                }

                /* discard changes if pressing esc */
                input.keydown(function(e) {
                    if (e.keyCode == 27) {
                        e.preventDefault();
                        //self.reset();
                        reset.apply(form, [settings, self]);
                    }
                });

                /* discard, submit or nothing with changes when clicking outside */
                /* do nothing is usable when navigating with tab */
                var t;
                if ('cancel' == settings.onblur) {
                    input.blur(function(e) {
                        /* prevent canceling if submit was clicked */
                        t = setTimeout(function() {
                            reset.apply(form, [settings, self]);
                        }, 500);
                    });
                } else if ('submit' == settings.onblur) {
                    input.blur(function(e) {
                        /* prevent double submit if submit was clicked */
                        t = setTimeout(function() {
                            form.submit();
                        }, 200);
                    });
                } else if ($Jq.isFunction(settings.onblur)) {
                    input.blur(function(e) {
                        settings.onblur.apply(self, [input.val(), settings]);
                    });
                } else {
                    input.blur(function(e) {
                      /* TODO: maybe something here */
                    });
                }

                form.submit(function(e) {

                    if (t) {
                        clearTimeout(t);
                    }

                    /* do no submit */
                    e.preventDefault();

                    /* call before submit hook. */
                    /* if it returns false abort submitting */
                    if (false !== onsubmit.apply(form, [settings, self])) {
                        /* custom inputs call before submit hook. */
                        /* if it returns false abort submitting */
                        if (false !== submit.apply(form, [settings, self])) {

                          /* check if given target is function */
                          if ($Jq.isFunction(settings.target)) {
                              var str = settings.target.apply(self, [input.val(), settings]);
                              //Uzdc COMMENTED THE FOLLOWING LINE AND ADDED THE NEXT LINE TO SHOW THE LOADING GIF
                             // $Jq(self).html(str);
                              $Jq(self).html(settings.indicator);
                              self.editing = false;
                              callback.apply(self, [self.innerHTML, settings]);
                              /* TODO: this is not dry */
                              if (!$Jq.trim($Jq(self).html())) {
                                  $Jq(self).html(settings.placeholder);
                              }
                          } else {
                              /* add edited content and id of edited element to POST */
                              var submitdata = {};
                              submitdata[settings.name] = input.val();
                              submitdata[settings.id] = self.id;
                              /* add extra data to be POST:ed */
                              if ($Jq.isFunction(settings.submitdata)) {
                                  $Jq.extend(submitdata, settings.submitdata.apply(self, [self.revert, settings]));
                              } else {
                                  $Jq.extend(submitdata, settings.submitdata);
                              }

                              /* quick and dirty PUT support */
                              if ('PUT' == settings.method) {
                                  submitdata['_method'] = 'put';
                              }

                              /* show the saving indicator */
                              $Jq(self).html(settings.indicator);

                              /* defaults for ajaxoptions */
                              var ajaxoptions = {
                                  type    : 'POST',
                                  data    : submitdata,
                                  dataType: 'html',
                                  url     : settings.target,
                                  success : function(result, status) {
                                      if (ajaxoptions.dataType == 'html') {
                                        $Jq(self).html(result);
                                      }
                                      self.editing = false;
                                      callback.apply(self, [result, settings]);
                                      if (!$Jq.trim($Jq(self).html())) {
                                          $Jq(self).html(settings.placeholder);
                                      }
                                  },
                                  error   : function(xhr, status, error) {
                                      onerror.apply(form, [settings, self, xhr]);
                                  }
                              };

                              /* override with what is given in settings.ajaxoptions */
                              $Jq.extend(ajaxoptions, settings.ajaxoptions);
                              $Jq.ajax(ajaxoptions);

                            }
                        }
                    }

                    /* show tooltip again */
                    $Jq(self).attr('title', settings.tooltip);
                    return false;
                });
            });

            /* privileged methods */
            this.reset = function(form) {
                /* prevent calling reset twice when blurring */
                if (this.editing) {
                    /* before reset hook, if it returns false abort reseting */
                    if (false !== onreset.apply(form, [settings, self])) {
                        $Jq(self).html(self.revert);
                        self.editing   = false;
                        if (!$Jq.trim($Jq(self).html())) {
                            $Jq(self).html(settings.placeholder);
                        }
                        /* show tooltip again */
                        if (settings.tooltip) {
                            $Jq(self).attr('title', settings.tooltip);
                        }
                    }
                }
            };
        });

    };


    $Jq.editable = {
        types: {
            defaults: {
                element : function(settings, original) {
                    var input = $Jq('<input type="hidden"></input>');
                    $Jq(this).append(input);
                    return(input);
                },
                content : function(string, settings, original) {
                    $Jq(':input:first', this).val(string);
                },
                reset : function(settings, original) {
                  original.reset(this);
                },
                buttons : function(settings, original) {
                    var form = this;
                    if (settings.submit) {
                        /* if given html string use that */
                        if (settings.submit.match(/>$/)) {
                            var submit = $Jq(settings.submit).click(function() {
                                if (submit.attr("type") != "submit") {
                                    form.submit();
                                }
                            });
                        /* otherwise use button with given string as text */
                        } else {
                            var submit = $Jq('<button type="submit" />');
                            submit.html(settings.submit);
                        }
                        $Jq(this).append(submit);
                    }
                    if (settings.cancel) {
                        /* if given html string use that */
                        if (settings.cancel.match(/>$/)) {
                            var cancel = $Jq(settings.cancel);
                        /* otherwise use button with given string as text */
                        } else {
                            var cancel = $Jq('<button type="cancel" />');
                            cancel.html(settings.cancel);
                        }
                        $Jq(this).append(cancel);

                        $Jq(cancel).click(function(event) {
                            //original.reset();
                            if ($Jq.isFunction($Jq.editable.types[settings.type].reset)) {
                                var reset = $Jq.editable.types[settings.type].reset;
                            } else {
                                var reset = $Jq.editable.types['defaults'].reset;
                            }
                            reset.apply(form, [settings, original]);
                            return false;
                        });
                    }
                }
            },
            text: {
                element : function(settings, original) {
                    var input = $Jq('<input />');
                    if (settings.width  != 'none') { input.width(settings.width);  }
                    if (settings.height != 'none') { input.height(settings.height); }
                    /* https://bugzilla.mozilla.org/show_bug.cgi?id=236791 */
                    //input[0].setAttribute('autocomplete','off');
                    input.attr('autocomplete','off');
                    $Jq(this).append(input);
                    return(input);
                }
            },
            textarea: {
                element : function(settings, original) {
                    var textarea = $Jq('<textarea />');
                    if (settings.rows) {
                        textarea.attr('rows', settings.rows);
                    } else if (settings.height != "none") {
                        textarea.height(settings.height);
                    }
                    if (settings.cols) {
                        textarea.attr('cols', settings.cols);
                    } else if (settings.width != "none") {
                        textarea.width(settings.width);
                    }
                    $Jq(this).append(textarea);
                    return(textarea);
                }
            },
            select: {
               element : function(settings, original) {
                    var select = $Jq('<select />');
                    $Jq(this).append(select);
                    return(select);
                },
                content : function(data, settings, original) {
                    /* If it is string assume it is json. */
                    if (String == data.constructor) {
                        eval ('var json = ' + data);
                    } else {
                    /* Otherwise assume it is a hash already. */
                        var json = data;
                    }
                    for (var key in json) {
                        if (!json.hasOwnProperty(key)) {
                            continue;
                        }
                        if ('selected' == key) {
                            continue;
                        }
                        var option = $Jq('<option />').val(key).append(json[key]);
                        $Jq('select', this).append(option);
                    }
                    /* Loop option again to set selected. IE needed this... */
                    $Jq('select', this).children().each(function() {
                        if ($Jq(this).val() == json['selected'] ||
                            $Jq(this).text() == $Jq.trim(original.revert)) {
                                $Jq(this).attr('selected', 'selected');
                        }
                    });
                }
            }
        },

        /* Add new input type */
        addInputType: function(name, input) {
            $Jq.editable.types[name] = input;
        }
    };

    // publicly accessible defaults
    $Jq.fn.editable.defaults = {
        name       : 'value',
        id         : 'id',
        type       : 'text',
        width      : 'auto',
        height     : 'auto',
        event      : 'click.editable',
        onblur     : 'cancel',
        loadtype   : 'GET',
        loadtext   : 'Loading...',
        placeholder: 'Click to edit',
        loaddata   : {},
        submitdata : {},
        ajaxoptions: {}
    };

})(jQuery);
//Uzdc: Create a custom input type for checkboxes
$Jq.editable.addInputType("multipleselect", {

                element : function(settings, original) {
                    var select = $Jq('<select multiple="multiple">');
                    $Jq(this).append(select);
                    return(select);
                },
                content : function(data, settings, original) {
                    /* If it is string assume it is json. */
                    if (String == data.constructor) {
                        eval ('var json = ' + data);
                    } else {
                    /* Otherwise assume it is a hash already. */
                        var json = data;
                    }
                    for (var key in json) {
                        if (!json.hasOwnProperty(key)) {
                            continue;
                        }
                        if ('selected' == key) {
                            continue;
                        }
                        var option = $Jq('<option />').val(key).append(json[key]);
                        $Jq('select', this).append(option);
                    }
                    /* Loop option again to set selected. IE needed this... */

                    var which = json['selected'];
                    var selected_arr = which.split('/');
                	$Jq('select', this).children().each(function() {
                		for (i = 0; i < selected_arr.length; i++){
                    		if ($Jq(this).val() == selected_arr[i]) {
                        		$Jq(this).attr('selected', 'selected');
                        	}
                        }
                    });
                }
});
