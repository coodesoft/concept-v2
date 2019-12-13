var SucursalDOM = (function($){
    
    var instance;
    
    function SucursalDOM(){
        let self = this;

        self.selector = (params) => {
            let target      = params['target']
            let sucursales  = params['sucursales'];
          //  let client      = params['client'];

            let html = '<div class="sucursalSelection cuatrocol">';

          //  html += '<input id="clientId" type="hidden" name="clientId" value="'+client+'">';
            html += '<div>Seleccione la sucursal:</div>';
            html += '<div id="sucursalesList">';
            html += '<select id="selectSucursal" name="sucursal" required>';
            html += '<option value="" disabled selected>Seleccione una sucursal</option>';

            for(let t=0; t<sucursales.length; t++){
                let sucursal = sucursales[t];
                html += '<option value="'+sucursal['id']+'">'+sucursal['sucursal']+'</option>';
            }

            html += '</select></div></div>';


            $(target).html(html);                    
        }
    
        self.input = (params) => {
            let target = params['target'];
            let sucursal = params['sucursal'];
            
            let html = '<div class="sucursalesList cuatrocol">';
            
            html += '<div>Sucursal:</div>';
            html += '<input type="text" disabled value="'+sucursal['id']+'" name="sucursal_name">';
            html += '<input type="hidden" value="'+sucursal['sucursal']+'" name="sucursal">';
            html += '</div>';
              
            $(target).html(html);
          
            
        }        
    }
    
    return {
        getInstance: function(){
          if (!instance)
            instance = new SucursalDOM();
          return instance;
        }
    }   
        
    
})(jQuery);