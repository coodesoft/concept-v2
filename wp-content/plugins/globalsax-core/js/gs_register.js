var Register = (function($){

    var instance;
    
    function Register(){

        let self = this;
        
        let events = {};
        
        
        self.subscribe = (state, fn) => {
            if (!(state in events))
                events[state] = [];
                    
            events[state].push(fn);
        }
        
        self.unsubscribe = (state, fn) => {
            //TODO: implementar el método de "desuscripción"
        }
        
        
        self.notify = (state, params) => {

            if (state in events){
                let fns = events[state];
                for(let i=0; i<fns.length; i++){
                    let fn = fns[i];
                    fn(params);
                    
                }
            }
        }
        

    }

    return {
        getInstance: function(){
            if (!instance)
                instance = new Register();
            return instance;
        }
    }

    

})(jQuery);