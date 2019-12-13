var Requester = (function($){

    var instance;

    function Requester(){

        let self = this;

        self.request = (params, callback) => {

            $.post(ajaxurl, params, function(response){
               if (callback != undefined)
                   callback(response);
            });
        }
    }

    return {
        getInstance: function(){
            if (!instance)
                instance = new Requester();
            return instance;
        }
    }



})(jQuery);
