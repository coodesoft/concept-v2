var State = (function($){

  var instance;

  function State(){
      let self = this;

      self.NO_SUCURSALES        = '10000';

      self.LIST_SUCURSALES      = '10001';
      
      self.SINGLE_SUCURSAL      = '10002';

      self.SINGLE_PRICELIST     = '20000';

      self.MULTIPLE_PRICELIST   = '20001';

      self.UPDATE_PRICELIST     = '30000';

      self.PARAM_ERROR          = '70000';

  }

  return {
    getInstance: function(){
      if (!instance)
        instance = new State();
      return instance;
    }
  }

})(jQuery);
