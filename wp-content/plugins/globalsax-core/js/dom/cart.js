var CartDOM = (function($){
    
    var instance;
    
    function CartDOM(){
        let self = this;

    }
    
    return {
        getInstance: function(){
          if (!instance)
            instance = new CartDOM();
          return instance;
        }
    }   
        
    
})(jQuery);