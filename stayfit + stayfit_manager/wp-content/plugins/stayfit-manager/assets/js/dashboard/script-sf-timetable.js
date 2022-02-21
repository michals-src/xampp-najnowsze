(function($){

    var sf_dashboard_real_editor = {
        current_item: '',
        current_item_view: '',
        current_item_container: '',
        current_item_container_status: '',
        current_item_content: '',
        current_item_data: '',
        init: function(){
            $( '#sf-dashboard-settings #sf-dashboard-settings-item .sf-dashboard-settings-item-view' ).on('click', function(event){
                event.preventDefault();
                sf_dashboard_real_editor.listenTriggerEvent( $(this).parent() );
            });
            $( document ).on('click', '.sf-dashboard-settings-item-content a[data-cancel="true"]', function(event){
                event.preventDefault();
                sf_dashboard_real_editor.listenCancelEvent();
            });
        },
        listenTriggerEvent: function( el ){
            var item = sf_dashboard_real_editor;
            item.current_item = el;
            item.current_item_view = item.current_item.find('.sf-dashboard-settings-item-view');
            item.current_item_container = item.current_item.find('.sf-dashboard-settings-item-container');
            item.current_item_container_status = item.current_item_container.find('#status-icon');
            item.current_item_content = item.current_item_container.find('.sf-dashboard-settings-item-content');
            item.current_item_data = JSON.parse(el.attr("data-item"));
            
            var endpoint = sf_manager_endpoint.ajax_url;

            /** 
             * Zamknięcie podlądu aktywnych elementów
             */
            item.go_normal_view();
            /** 
             * Dodanie podlądu dla aktywnego elementu
             */
            item.go_edit_view();

            $.ajax({
                "url": endpoint,
                "type": "POST",
                "data": item.current_item_data,
                success: function( response ){
                    item.current_item_content.html( response.data.sf_manager_tec );
                    item.current_item_container_status.css({ 'visibility': 'hidden', 'height': '0' });
                    item.current_item_content.css( 'display', 'block' );
                }
            });
        },
        listenCancelEvent: function(){
            sf_dashboard_real_editor.go_normal_view();
        },
        go_edit_view: function(){
            var item = sf_dashboard_real_editor;

            item.current_item.addClass( 'sf-dashboard-settings-item-active' );
            
            item.current_item.removeClass( 'list-group-item-action' );
            item.current_item_view.css({ 'visibility': 'hidden', 'height': '0' });
            item.current_item_view[0].style.setProperty('padding', '0', 'important');
            item.current_item_container.css( 'display', 'block' );
        
        },
        go_normal_view: function(){
            var item = $('.sf-dashboard-settings-item-active');
            if( item.length > 0 ){

                var current_item_view = item.find('.sf-dashboard-settings-item-view');
                var current_item_container = item.find('.sf-dashboard-settings-item-container');
                var current_item_container_status = current_item_container.find('#status-icon');
                var current_item_content = current_item_container.find('.sf-dashboard-settings-item-content');

                current_item_content.html('');

                if( ! item.hasClass( 'list-group-item-action' ) ){
                    item.addClass( 'list-group-item-action' );
                }

                current_item_view.css({ 'visibility': 'visible' });
                current_item_view[0].style.removeProperty('height');
                current_item_view[0].style.removeProperty('padding');

                current_item_container.css( 'display', 'none' );
                current_item_container_status.css( 'visibility', 'visible' );
                current_item_container_status[0].style.removeProperty('height');
                current_item_content.css( 'display', 'none' );

                item.removeClass('sf-dashboard-settings-item-active');
            }
        }
    };

    sf_dashboard_real_editor.init();

    var sf_dashboard_nickname_generator = function( name, surname ){

        var output = name;
        var characters = "!@#$%&1234567890";

        name_length = ( Math.random() * surname.length / 2 ) + ( Math.random() * ( ( surname.length / 2 ) + 1) + 1 );
        if( surname.length > 3 ){
            name_length = ( Math.random() * ( surname.length - ( ( Math.random() * ( surname.length / 2 ) ) + 2 ) ) ) + 1;
        }

        output += this.character( 1 );
        output += surname.slice( 0, name_length );
        output += this.character( 1 );
        output += this.character( 1 );


        this.value = output;
        return this;

    };

    sf_dashboard_nickname_generator.prototype.character = function( char_length, required = false ){
        
        var characters = "!@#$%&1234567890";
        var output = '';

        var rand_start = 0;

        if( true == required ){
            rand_start = 1;
        }

        for( var i = 0; i < char_length; i++ ){
            var start = ( Math.random() * characters.length ) + rand_start;
            var end = start + 1;
            output += characters.slice( start, end );
        }

        return output;

    }

    $('button[name="sf_dashboard_client-manager-creator[generate]"]').on( 'click', function( e ){

        e.preventDefault();

        var name = $('input[name="sf_dashboard_client-manager-creator[name]"]');
        var surname = $('input[name="sf_dashboard_client-manager-creator[surname]"]');

        if( name.val() == '' || surname.val() == '' ){
            alert( "Polę imię lub/i nazwisko jest puste, zioom." );
            return;
        }

        console.log( new sf_dashboard_nickname_generator( name.val(), surname.val() ) );

        var nickname = new sf_dashboard_nickname_generator( name.val(), surname.val() );
        $('input[name="sf_dashboard_client-manager-creator[login][rand_username]"]').val( nickname.value );
        $('input[name="sf_dashboard_client-manager-creator[login][rand_username]"]').removeAttr( "disabled");
        $('button[name="sf_dashboard_client-manager-creator[save]"]').removeAttr( "disabled");

    });


})(jQuery);