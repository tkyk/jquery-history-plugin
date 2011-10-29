$(document).ready(function() {
	var Logger = {
	    clear: function() {
		$('#history-log').val("");
	    },
	    append: function(text) {
		var dom = $('#history-log').get(0);
		dom.value+= text + "\n";
		dom.scrollTop = dom.scrollHeight;
	    }
	};

	if($.browser.msie && $.browser.version == 8) {
	    $('#ie-info').text('You are using IE8 in version '+ document.documentMode +' compatible mode.');
	}
    $('#type-info').text('The plugin is running in '+ $.history.type +' mode.');


	$.history.init(function (hash) {
		Logger.append("[callback called] hash="+ hash);
		if(hash) {
		    $("#load").text("loaded: "+ hash);
		} else {
		    // start page
		    $("#load").empty();
		}
		$('#hash-input').val(hash);
	    });

	function loadHistory(hash) {
	    Logger.append('[load history] hash='+ hash);
	    $.history.load(hash);
	}

	$(".history-links a").click(function(){
		var href = $(this).attr('href');
		hash = href.replace(/^.*?#/, '');
		Logger.append("[link clicked] href="+ href);
		loadHistory(hash);
		return false;
	    });

	$('#load-hash').click(function() {
		var hash = $('#hash-input').val();
		if(hash) {
		    loadHistory(hash);
		}
	    });
    });
