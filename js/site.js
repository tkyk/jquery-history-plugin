(function($){
    var origContent = "";

    function loadContent(hash) {
        if(hash != "") {
            if(origContent == "") {
                origContent = $('#content').html();
            }
            $('#content').load(hash +".html",
                               function(){ prettyPrint(); });
        } else if(origContent != "") {
            $('#content').html(origContent);
        }
    }

    $(document).ready(function() {
            $.history.init(loadContent);
            $('#navigation a').not('.external-link').click(function(e) {
                    var url = $(this).attr('href');
                    url = url.replace(/^.*#/, '');
                    $.history.load(url);
                    return false;
                });
        });
})(jQuery);


