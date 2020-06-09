// Avoid `console` errors in browsers that lack a console.
(function () {
  var method;
  var noop = function () { };
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});

  while (length--) {
    method = methods[length];

    // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop;
    }
  }
}());

(function(window){
	window.htmlentities = {
		/**
		 * Converts a string to its html characters completely.
		 *
		 * @param {String} str String with unescaped HTML characters
		 **/
		encode : function(str) {
			var buf = [];
			
			for (var i=str.length-1;i>=0;i--) {
				buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
			}
			
			return buf.join('');
		},
		/**
		 * Converts an html characterSet into its original character.
		 *
		 * @param {String} str htmlSet entities
		 **/
		decode : function(str) {
			return str.replace(/&#(\d+);/g, function(match, dec) {
				return String.fromCharCode(dec);
			});
		}
	};
})(window);
// Place any jQuery/helper plugins in here.
function check_email(val){
  if(!val.match(/\S+@\S+\.\S+/)){ 
      return false;
  }
  if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
      return false;
  }
  return true;
}

function check_number(selector){
  var value =selector.val();
  selector.addClass("is-danger");
  if (_.isEmpty(value) )
  {
      return false;
  }
  if (!$.isNumeric(value) )
  {
      return false;
  }
  selector.removeClass("is-danger");
  
  return true;
}
function check_chaine(selector){
  var value =selector.val();
  selector.addClass("is-danger");
  if (_.isEmpty(value) )
  {
      return false;
  }
  if (!_.isString(value) )
  {
      return false;
  }
  selector.removeClass("is-danger");
  return true;
}

function checkStrength(password)
{
    var strength = 0
   
    if (password.length > 7) strength += 1
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
    return strength;
}

function displayMessageErr(msg ,selector){
  html = '<div class="notification is-danger">\n\
  <button class="delete">\n\
  </button>' + msg + '\n\
  </span>\n\
</div>';
if (selector === undefined){
  $('#err').html(html);
}
else{
  $(selector).html(html);
}

};

function displayMessageInfo(msg){
  html = '<div class="notification is-info">\n\
  <button class="delete">\n\
  </button>' + msg + '\n\
  </span>\n\
</div>';
$('#err').html(html);
};

function clearMessageErr(){  
  $('#err').html("");
};

