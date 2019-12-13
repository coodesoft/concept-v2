(function($){

  var loadUserContentCallback = function(form, action, target, callback){
    var data = {
      'data': $(form).serialize(),
      'action': action,
    }

    $.post(ajaxurl, data, function(data){
        $(target).html(data);
        $('body').removeClass('gbs-progress');

        if (callback != undefined)
          callback(data);
    });
  }

  var sendContent = function(form, action, target, callback){
    var data = {
      'data': $(form).serialize(),
      'action': action,
    }
    $.post(ajaxurl, data, function(data){
      data = JSON.parse(data);

      if (target instanceof jQuery)
        target.html(data['variations-added']);
      else
        $(target).html(data['variations-added']);

      $('body').removeClass('gbs-progress');
      if (callback != undefined)
        callback(data);
    });
  }

  var enviarPedido = function(){
    let selectCliente = $('#clientesList select').length;
    let clienteSerialize = $('#clientesList select').serialize();

    if ( !selectCliente || (selectCliente && clienteSerialize.length)){
      $('body').addClass('gbs-progress');

      var data = {
        'action': 'gbs_create_order',
        'data' : $('form.gbs-cart-form').serialize(),
        'user' : clienteSerialize,
      }
      $.post(ajaxurl, data, function(data){
        $('body').removeClass('gbs-progress');
        data = JSON.parse(data);
        let response = '<p class="cart-response '+data['status']+'">'+data['msg']+'</p>';
        $('#gbsCheckout').html(response);
      });
    } else{
      alert('Debe seleccionar una Razón Social');
    }
  }



  $(document).ready(function(){
    let rootCatalog = '#gbsCatalog';
    let rootCartForm = '.gbs-cart-form';
    let tabNavigator = TabNavigator.getInstance('#gbsCatalog');
    tabNavigator.run();



    $(rootCatalog).on('click', 'span.gbs-close', function(){
      $(this).closest('.gbs-dialog').removeClass('active');
      $(this).closest('.gbs-dialog').find('.body').empty();
    });



    $(rootCartForm).on('click', '#gbsEnviarPedido', function(){
      enviarPedido();
    })



  });






})(jQuery);
