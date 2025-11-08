import $ from 'jquery';

(function($){
    var REST_ROOT = (typeof MVA_Config !== 'undefined' && MVA_Config.rest_url) ? MVA_Config.rest_url : '/wp-json/mva/v1';
    var NONCE = (typeof MVA_Config !== 'undefined' && MVA_Config.nonce) ? MVA_Config.nonce : '';

    function fetchTop(period, container) {
        var url = REST_ROOT + '/top?period=' + encodeURIComponent(period) + '&limit=10';
        container.find('.mva-loading').show();
        fetch(url, {
            credentials: 'same-origin'
        }).then(function(r){ return r.json(); }).then(function(data){
            container.find('.mva-loading').hide();
            var list = container.find('.mva-list-items');
            if (!list.length) {
                list = $('<div class="mva-list-items"></div>');
                container.find('.mva-list').empty().append(list);
            } else {
                list.empty();
            }

            if (!data.success || !data.items || data.items.length === 0) {
                list.append('<div class="mva-empty">No articles found.</div>');
                return;
            }

            console.log(data.items);

            data.items.forEach(function(item){
                var line = $('<div class="mva-line"></div>');
                line.append('<div class="mva-rank">'+ item.rank +'.</div>');
                line.append('<div class="mva-title"><a href="'+ item.link +'">'+ item.title +'</a></div>');
                list.append(line);
            });
        }).catch(function(){
            container.find('.mva-loading').hide();
            container.find('.mva-list').html('<div class="mva-error">Error loading items</div>');
        });
    }

    function countView(postId) {
        if (!postId) {
            return;
        }

        var url = REST_ROOT + '/count-view';
        var body = new FormData();
        body.append('post_id', postId);
        body.append('_wpnonce', NONCE);
        fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            body: body
        }).then(function(r){ return r.json(); }).then(function(data){
        }).catch(function(){
        });
    }

    $(document).ready(function(){
        $('.mva-widget').each(function(){
            var container = $(this);
            var postId = container.data('post-id') || '';

            if (postId && $('body').hasClass('single-post')) {
                countView(postId);
            }

            fetchTop('week', container);

            container.on('click', '.mva-tab', function(e){
                e.preventDefault();
                var tab = $(this);
                if (tab.hasClass('mva-active')) return;
                tab.siblings().removeClass('mva-active');
                tab.addClass('mva-active');
                var period = tab.data('period') || 'week';
                fetchTop(period, container);
            });
        });
    });

})(jQuery);
