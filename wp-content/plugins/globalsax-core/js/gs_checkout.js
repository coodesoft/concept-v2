(function($){


    let resetPricesView = function(){
        $('.price').html('0');
        $('.total-price').html('0');
    }

    let calculatePrices = function(params){
        let target = params['target'];

        if (target != undefined)
            $(target).empty();

        let data = {
            'lista_id' : params['list']['list_id'],
            'action' : 'gs_calculate_prices_by_sucursal',
        };

        resetPricesView();
        $('body').addClass('loading-cursor');

        $.post(ajaxurl, data, function(response){
            $('body').removeClass('loading-cursor');

            response = JSON.parse(response);
            let state = response['state'];

            if ( state == State.getInstance().UPDATE_PRICELIST ){
                register.notify(response['state'], response['data']);
            } else
                alert('Se produjo un error en el envío de parámetros para calcular el precio de tu perido' + state +" - "+ state.UPDATE_PRICELIST);

        });
    }

    let updatePriceView = function(params){
        let totalPrice = 0;
        for (key in params){
            let target = params[key]['name'].toUpperCase();
            let price = params[key]['price'];
            totalPrice = totalPrice + parseFloat(price);

            $('#'+target+" .product-price .price").html('$'+price);
            $('.total-price').html('$'+totalPrice);
        }
    }

    let updatePriceListState = (response) => {
        switch (response['state']){
            case state.SINGLE_PRICELIST:
                params = { 'target' : '.priceListTarget', 'list' : response['data'] };
                break;
            case state.MULTIPLE_PRICELIST:
                params = { 'target' : '.priceListTarget', 'listas' : response['data'] };
                break;
        }

        register.notify(response['state'], params);
    }
    
    let loadListasPreciosByClient = function(params){
        let data = {
            'client' : params['client'],
            'action' : 'gs_load_pricelist_by_client',
        };
        $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);
            updatePriceListState(response);
       }); 
    }
    
    let loadListasPreciosBySucursal = function(params){
        let data = {
            'sucursal' : params['sucursal']['id'],
            'action' : 'gs_load_pricelist_by_sucursal',
        };

        $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);
            updatePriceListState(response);
       }); 
    }



    let register = Register.getInstance();
    let state = State.getInstance();

    register.subscribe(state.LIST_SUCURSALES, SucursalDOM.getInstance().selector);

    register.subscribe(state.SINGLE_SUCURSAL, SucursalDOM.getInstance().input);
    register.subscribe(state.SINGLE_SUCURSAL, loadListasPreciosBySucursal);

    register.subscribe(state.NO_SUCURSALES, loadListasPreciosByClient);

    register.subscribe(state.MULTIPLE_PRICELIST, ListaPreciosDOM.getInstance().selector);

    register.subscribe(state.SINGLE_PRICELIST, calculatePrices);
    register.subscribe(state.SINGLE_PRICELIST, ListaPreciosDOM.getInstance().input);
    
    register.subscribe(state.UPDATE_PRICELIST, updatePriceView);


    // se cargan las sucursales dependiendo de la seleccion del cliente.
    $('#clientesList').on('change', '#cliente_id', function(){
        var data = {
	       'client' : this.value,
	       'action' : 'gs_load_sucursales',
        };

        $('.sucursalTarget').empty();
        $('.priceListTarget').empty();
        $('body').addClass('loading-cursor');
        resetPricesView();

        $.post(ajaxurl, data, function(response){
            $('body').removeClass('loading-cursor');

            response = JSON.parse(response);
            let params;
                         
            switch (response['state']){
                case state.LIST_SUCURSALES:
                    params = { 'target' : '.sucursalTarget', 'sucursales' : response['data'] };
                    break;
                case state.SINGLE_SUCURSAL:
                    params = { 'target' : '.sucursalTarget', 'sucursal' : response['data'] };
                    break;
                case state.NO_SUCURSALES:
                    params = { 'client' : data['client'] };
            }
            
            register.notify( response['state'], params );

        });
	});


    // se cargan las listas de precios o se calcula el precio si es unica lista dependiendo de la sucursal
    $('#gbsCheckout').off().on('change', '#selectSucursal', function(){
        var data = {
            'sucursal': this.value,
            'action': 'gs_load_pricelist_by_sucursal',
        };

        $('.priceListTarget').empty();
        $('body').addClass('loading-cursor');
        resetPricesView();

        $.post(ajaxurl, data, function(response){
            $('body').removeClass('loading-cursor');

            response = JSON.parse(response);
            updatePriceListState(response);
        });
    });

    $('#gbsCheckout').on('change',  '#selectListaPrecios', function(){
         var data = {
            'list': {list_id: this.value},
        };
        register.notify(state.SINGLE_PRICELIST, data);
    });


})(jQuery);
