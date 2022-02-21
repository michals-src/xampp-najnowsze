(function($) {
    var resultCollector = Quagga.ResultCollector.create({
        capture: true,
        capacity: 20,
        blacklist: [{
            code: "WIWV8ETQZ1", format: "code_93"
        }, {
            code: "EH3C-%GU23RK3", format: "code_93"
        }, {
            code: "O308SIHQOXN5SA/PJ", format: "code_93"
        }, {
            code: "DG7Q$TV8JQ/EN", format: "code_93"
        }, {
            code: "VOFD1DB5A.1F6QU", format: "code_93"
        }, {
            code: "4SO64P4X8 U4YUU1T-", format: "code_93"
        }],
        filter: function(codeResult) {
            // only store results which match this constraint
            // e.g.: codeResult
            return true;
        }
    });
    var App = {
        init: function() {
            var self = this;

            Quagga.init(this.state, function(err) {
                if (err) {
                    return self.handleError(err);
                }
                Quagga.start();
            });
        },
        handleError: function(err) {
            console.log(err);
        },
        state: {
            inputStream: {
                type : "LiveStream",
                constraints: {
                    width: {min: 640},
                    height: {min: 480},
                    facingMode: "environment",
                    aspectRatio: {min: 1, max: 100}
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
            decoder: {
                readers : [{
                    format: "ean_8_reader",
                    config: {}
                }]
            },
            locate: true
        },
        lastResult : null
    };

    App.init();

    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;

        if (App.lastResult !== code) {
            App.lastResult = code;
        
            var data = JSON.parse($("button#fake-scanning").attr('data-item'));

            data["date"] = $('input[name="sf_scanner_date"]').val() + ' ' + $('input[name="sf_scanner_time"]').val();
            data["ean"] = code;

            var $icon = "checkmark";
            var $class = "text-success";
            
            $.ajax({
                "url": sf_manager_endpoint.ajax_url,
                "type": "POST",
                "data": data,
                success: function( response ){

                    if( response.data.error ){
                        $icon = "close";
                        $class = "text-danger";
                    }

                    var $message = $('<p class="' + $class + '"><span style="font-size: 18px;display: inline-table;vertical-align: middle;"><ion-icon name="' + $icon + '"></ion-icon></span> ' + response.data.msg + '</p>');
                    $('.monitor-messages-container .monitor-messages-list').append( $message );
                    $('.monitor-last-messages').html($message.clone());

                    alert( response.data.msg );

                }
            });

        }
    });


    $("#fake-scanning").on( "click", function( e ){

        e.preventDefault();

        var data = JSON.parse($(this).attr('data-item'));

        data["date"] = $('input[name="sf_scanner_date"]').val() + ' ' + $('input[name="sf_scanner_time"]').val();
        data["ean"] = "1500121";

        console.log(data);
        var $icon = "checkmark";
        var $class = "text-success";
        
        $.ajax({
            "url": sf_manager_endpoint.ajax_url,
            "type": "POST",
            "data": data,
            success: function( response ){

                if( response.data.error ){
                    $icon = "close";
                    $class = "text-danger";
                }

                var $message = $('<p class="' + $class + '"><span style="font-size: 18px;display: inline-table;vertical-align: middle;"><ion-icon name="' + $icon + '"></ion-icon></span> ' + response.data.msg + '</p>');
                $('.monitor-messages-container .monitor-messages-list').append( $message );
                $('.monitor-last-messages').html($message.clone());


                console.log( response );
            }
        });

    });






})(jQuery);
