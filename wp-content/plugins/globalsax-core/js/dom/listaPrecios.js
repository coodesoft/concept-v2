var ListaPreciosDOM = (function($){

    var instance;

    function ListaPreciosDOM(){
        let self = this;

        self.selector = (params) => {
            let target      = params['target']
            let listas  = params['listas'];

            let html = '<div class="listaPreciosSelection cuatrocol">';

            html += '<div>Seleccione la lista de precios:</div>';
            html += '<div id="listaPreciosList">';
            html += '<select id="selectListaPrecios" name="priceList" required>';
            html += '<option value="" disabled selected>Seleccione una lista de precios</option>';

            for(let t=0; t<listas.length; t++){
                let lista = listas[t];
                html += '<option value="'+lista['list_id']+'">'+lista['name']+'</option>';
            }

            html += '</select></div></div>';


            $(target).html(html);
        }

        self.input = (params) => {
            
            let target = params['target']
            let lista  = params['list'];
            
            let html = '<div class="listaPreciosList cuatrocol">';
            
            html += '<div>Lista de precios:</div>';
            html += '<input type="text" disabled value="'+lista['list_id']+'" name="pricelist_name">';
            html += '<input type="hidden" value="'+lista['name']+'" name="priceList">';
            html += '</div>';
            
            $(target).html(html);
        
        }
    }

    return {
        getInstance: function(){
          if (!instance)
            instance = new ListaPreciosDOM();
          return instance;
        }
    }


})(jQuery);
