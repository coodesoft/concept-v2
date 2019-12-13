



(function($){

    let resetDynamicValues = function(){
        $('.price').html('0');
        $('.total-price').html('0');        
    }
    
    let calculatePrices = function(params){
        let target = params['target'];
        if (target != undefined)
            $(target).empty();
        let data = {
            'client' : params['client'],
            'action' : 'gs_calculate_prices',
        };
        resetDynamicValues();
        $('body').addClass('loading-cursor');

        $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);
            let state = response['state'];

            if ( state == State.getInstance().UPDATE_PRICELIST ){
                register.notify(response['state'], response['data']);
            } else{
                $('body').removeClass('loading-cursor');
                alert('Se produjo un error en el envío de parámetros para calcular el precio de tu perido' + state +" - "+ State.getInstance().UPDATE_PRICELIST);
              }


        });
    }

    let updatePriceView = function(params){
        let totalPrice = 0;
        for (key in params){
            let target = params[key]['name'].toUpperCase().replace(' ', '-');
            let price = params[key]['price'];
            totalPrice = totalPrice + parseFloat(price);

            $('#'+target+" .product-price .price").html('$'+price);
            $('.total-price').html('$'+totalPrice);
            $('body').removeClass('loading-cursor');
        }
    }

    let register = Register.getInstance();
    let state = State.getInstance();

    register.subscribe(state.LIST_SUCURSALES, SucursalDOM.getInstance().selector);
    register.subscribe(state.UPDATE_PRICELIST, updatePriceView);
    register.subscribe(state.NO_SUCURSALES, calculatePrices);

    // se cargan las sucursales dependiendo de la seleccion del cliente.
    $('#clientesList').on('change', '#cliente_id', function(){
        var data = {
	       'client' : this.value,
	       'action' : 'gs_load_sucursales',
        };
        resetDynamicValues();
        $('body').addClass('loading-cursor');
        $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);

            let params = (response['state'] == state.LIST_SUCURSALES) ?
                         { 'target' : '.sucursalTarget', 'sucursales' : response['data'] } :
                         { 'target' : '.sucursalTarget', 'client' : data['client'] } ;
            $('body').removeClass('loading-cursor');
            register.notify( response['state'], params );

        });
	});


    // se cargan las listas de precios o se calcula el precio si es unica lista dependiendo de la sucursal
    $('#gbsCheckout').off().on('change', '#selectSucursal', function(){
        var data = {
            'sucursal': this.value,
            'action': 'gs_calculate_prices',
        };

        $('body').addClass('loading-cursor');
        resetDynamicValues();
        $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);

            if (response['state'] == state.UPDATE_PRICELIST)
              register.notify(response['state'], response['data']);
        });
    });

})(jQuery);
