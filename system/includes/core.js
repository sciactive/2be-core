/*
 * 2be JavaScript Object
 *
 * Copyright (c) 2010-2013 Hunter Perrin
 *
 * Licensed under the GNU Affero GPL:
 *	  http://www.gnu.org/licenses/agpl.html
 */
// Make sure arrays have an indexOf method.
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(elt /*, from*/) {
		var len = this.length >>> 0;
		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
		if (from < 0)
			from += len;
		for (; from < len; from++) {
			if (from in this &&
				this[from] === elt)
			return from;
		}
		return -1;
	};
}

// If $_ doesn't exist, make it.
if (!window.$_) {
(function(window, document){

// Shortcut to $_.ready.
var $_ = function(fn){$_.ready(fn)};

$_.full_location="";
$_.rela_location="";
// Escape some text to put in HTML.
$_.safe=function(unsafe){
	if (typeof unsafe == "undefined")
		return "";
	var find = [/&/g, /\"/g, /\'/g, /</g, />/g], repl = ["&amp;", '&quot;', "&#039;", "&lt;", "&gt;"], r = String(unsafe);
	for (var i=0,l=find.length; i<l; i++)
		r = r.replace(find[i], repl[i]);
	return r;
}
// Unescape some text.
$_.unsafe=function(safe){
	if (typeof safe == "undefined")
		return "";
	var find = [/&amp;/g, /&quot;/g, /&#039;/g, /&lt;/g, /&gt;/g], repl = ["&", '"', "'", "<", ">"], r = String(safe);
	for (var i=0,l=find.length; i<l; i++)
		r = r.replace(find[i], repl[i]);
	return r;
}
// Cause the browser to go to a URL. (Just like the user clicked a link.)
$_.get=function(url, params, target){
	if (params) {
		url += (url.indexOf("?") == -1) ? "?" : "&";
		var parray = [];
		for (var i in params) {
			if (params.hasOwnProperty(i)) {
				if (encodeURIComponent)
					parray.push(encodeURIComponent(i)+"="+encodeURIComponent(params[i]));
				else
					parray.push(escape(i)+"="+escape(params[i]));
			}
		}
		url += parray.join("&");
	}
	if (!target || target == "_self")
		window.location = url;
	else if (target == "_top")
		window.top.location = url;
	else if (target == "_parent")
		window.parent.location = url;
	else if (target == "_blank")
		window.open(url);
	else
		window.open(url, target);
};
// Cause the browser to POST data. (Just like the user submitted a form.)
$_.post=function(url, params, target){
	var form = document.createElement("form");
	form.action = url;
	form.method = "POST";
	if (target)
		form.target = target;
	for (var i in params) {
		if (params.hasOwnProperty(i)) {
			var input = document.createElement("input");
			input.type = "hidden";
			input.name = i;
			input.value = params[i];
			form.appendChild(input);
		}
	}
	document.body.appendChild(form);
	form.submit();
	document.body.removeChild(form);
};
// Determine whether JavaScript loading is paused.
$_.paused=function(){
	return _paused;
};
// Wait to load pending JavaScript.
$_.pause=function(){
	_paused = true;
};
// Continue loading any pending JavaScript.
$_.play=function(){
	_paused = false;
	if (_loadnext_ready) {
		_loadnext_ready = false;
		_loadnext();
	}
	if (_domloaded)
		_ready();
};
// Executes a function after all JS files are loaded and the DOM is ready.
$_.ready=function(fn){
	_rdpending.push(fn);
	// If the DOM is loaded, run right now.
	if (_domloaded)
		_ready();
};
// Executes a function in turn with the loading JS files.
$_.load=function(fn){
	_pendingjs.push(fn);
	if (_pendingjs.length==1)
		_loadnext();
};
// Loads JavaScript files in turn.
$_.loadjs=function(url, multiple, attrs){
	if (_loadedjs.indexOf(url) > -1 && !multiple) return;
	// Mark that the JS is loading.
	_jsloaded = false;
	var n=document.createElement("script");
	if (attrs) {
		for (var prop in attrs) {
			if (attrs.hasOwnProperty(prop))
				n.setAttribute(prop, attrs[prop]);
		}
	}
	n.setAttribute("type","text/javascript");
	n.setAttribute("src",url);
	_pendingjs.push(n);
	if (_pendingjs.length==1)
		_loadnext();
	_loadedjs[_loadedjs.length]=url;
};
// Loads CSS files immediately.
$_.loadcss=function(url, multiple, attrs){
	if (_loadedcss.indexOf(url) > -1 && !multiple) return;
	var n=document.createElement("link");
	n.setAttribute("rel","stylesheet");
	if (attrs) {
		for (var prop in attrs) {
			if (attrs.hasOwnProperty(prop))
				n.setAttribute(prop, attrs[prop]);
		}
	}
	n.setAttribute("type","text/css");
	n.setAttribute("href",url);
	if (typeof n!="undefined")
		document.getElementsByTagName("head")[0].appendChild(n);
	_loadedcss[_loadedcss.length]=url;
};
// Notify the user.
$_.notice=function(message, title){
	alert((title ? title : "Notice") + "\n\n" + message);
};
// Show the user an error.
$_.error=function(message, title){
	alert((title ? title : "Error") + "\n\n" + message);
};

// JS loading is paused when true.
var _paused=false,
// If _loadnext is called while paused, be sure to call it again.
_loadnext_ready=false,
// List of loaded JS files.
_loadedjs=[],
// Loaded CSS files.
_loadedcss=[],
// Pending JS files.
_pendingjs=[],
// Pending ready functions.
_rdpending=[],
// Whether the DOM is ready.
_domloaded=false,
// Whether all JS/CSS files are ready.
_jsloaded=false,
_ready=function(){
	// Don't run if there's pending JS, the DOM isn't ready, or JS is paused.
	if ((_pendingjs && !_jsloaded) || !_domloaded || _paused) return;
	if (_rdpending) {
		var fn = _rdpending[0];
		while (fn) {
			_rdpending = _rdpending.slice(1);
			fn.call();
			fn = _rdpending[0];
		}
	}
	_rdpending = [];
},
// Load the next JS/CSS file.
_loadnext=function(){
	if (_paused) {
		_loadnext_ready = true;
		return;
	}
	var n = _pendingjs[0];
	if (typeof n == "undefined") {
		_jsloaded = true;
		_ready();
		return;
	}
	if (typeof n == "function"){
		n.call();
		_pendingjs = _pendingjs.slice(1);
		_loadnext();
	} else {
		if (typeof n.readyState != "undefined"){ // IE
			n.onreadystatechange = function(){
				if (n.readyState=="loaded" || n.readyState=="complete"){
					n.onreadystatechange = null;
					_pendingjs = _pendingjs.slice(1);
					_loadnext();
				}
			};
		} else { // Others
			n.onload = function(){
				_pendingjs = _pendingjs.slice(1);
				_loadnext();
			};
		}
		if (typeof n!="undefined")
			document.getElementsByTagName("head")[0].appendChild(n);
	}
};

var dom_loaded;
// Cleanup functions for the document ready method
if ( document.addEventListener ) {
	dom_loaded = function(){
		document.removeEventListener("DOMContentLoaded", dom_loaded, false);
		_domloaded = true;
		_ready();
	};

} else if ( document.attachEvent ) {
	dom_loaded = function(){
		// Make sure body exists, at least, in case IE gets a little overzealous (ticket #5443).
		if (document.readyState === "complete") {
			document.detachEvent("onreadystatechange", dom_loaded);
			_domloaded = true;
			_ready();
		}
	};
}

// The DOM ready check for Internet Explorer
var scroll_check = function(){
	if (_domloaded)
		return;
	try {
		// If IE is used, use the trick by Diego Perini
		// http://javascript.nwbox.com/IEContentLoaded/
		document.documentElement.doScroll("left");
	} catch(e) {
		setTimeout( scroll_check, 1 );
		return;
	}

	// and execute any waiting functions
	_ready();
}

if (document.attachEvent) { // IE
	// ensure firing before onload,
	// maybe late but safe also for iframes
	document.attachEvent("onreadystatechange", dom_loaded);
	// A fallback to window.onload, that will always work
	window.attachEvent("onload", function(){_domloaded = true;_ready();});
	// If IE and not a frame
	// continually check to see if the document is ready
	var toplevel = false;
	try {
		toplevel = window.frameElement == null;
	} catch(e) {}
	if (document.documentElement.doScroll && toplevel)
		scroll_check();
} else if (document.addEventListener) { // Others
	document.addEventListener("DOMContentLoaded", dom_loaded, false);
	window.addEventListener("load", function(){_domloaded = true;_ready();}, false);
}

window.$_ = $_;

})(window, window.document);
}