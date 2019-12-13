var TabNavigator = (function($){

    var instance;

    function TabNavigator(){


        let self = this;

        let _root;

        let _products;

        let _inputs;

        let _submitButton;

        let _actualInputFocusIndex = 0;

        let _actualProductFocusIndex = 0;

        let _variationLoadFlag = true;

        let _getProductPosition = (product) => {
          for (var i = 0; i < _products.length; i++) {
            if (_products[i] == product)
              return i;
          }
          return -1;
        }

        let _resetInputs = () => _inputs = [];

        let _updateInputs = () => {
            _actualInputFocusIndex = 0;
            _inputs = document.querySelectorAll('#gbsAddVariationToCartForm input[type="number"]');
        }

        let _updateSubmitButton = () => _submitButton = document.getElementById('gbsAddVariationToCartButton');

        let _updateProducts = () => {
            _actualProductFocusIndex = 0;
            _products = document.querySelectorAll('#gbs_productos_list li.product');
        }

        let _validateInputs = function(){
          for (var i = 0; i < _inputs.length; i++) {
            let input = _inputs[i];
            if ( (input.value % 2) != 0)
              return false;
          }
          return true;
        }

        let _getNextFocusableInput = () => {

            if (_actualInputFocusIndex < _inputs.length - 1){
                _actualInputFocusIndex++;
                _inputs[_actualInputFocusIndex].focus();
                _inputs[_actualInputFocusIndex].select();
                let input = _inputs[_actualInputFocusIndex];


                return input;
            }
            return null;
        }

        let _getPrevFocusableInput = () => {
            if (_actualInputFocusIndex > 0){
              _actualInputFocusIndex--;
              let input = _inputs[_actualInputFocusIndex];
              input.focus();
              return input;
            } else
              return null;
        }

        let _focusActualInput = () => {
          _inputs[_actualInputFocusIndex].focus();
          _inputs[_actualInputFocusIndex].select();
        }

        let _getNextFocusableProduct = () => {
            if (_actualProductFocusIndex < _products.length){
                let product =  _products[_actualProductFocusIndex];
                _actualProductFocusIndex++;
                return product;
            } else
                return null;
        }

        let _updateProductPosition = (pos) => _actualProductFocusIndex = pos;

        let _focusAddVariationToCartButton = () => {
          _submitButton.focus();

           if ( !_submitButton.classList.contains('submit-active') )
              _submitButton.classList.add('submit-active');
        }

        let _isAddVariationToCartButtonFocused = () => {
            return document.activeElement == _submitButton;
        };

        let _changeVariationLoadFlag = () => {
            _variationLoadFlag = !_variationLoadFlag;
        }

        let _getVariationLoadFlag = () => {
            return _variationLoadFlag;
        }


        let _loadContentCallback = function(form, action, target, callback){
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

        let _loadVariationTable = function(id, self, callback){
            var data = {
              'product_id': id,
              'action': 'gbs_load_variations',
            }
            _changeVariationLoadFlag();
            $.post(ajaxurl, data, function(data){

                // se limpia el contenido previamente cargado y el estilo.
                $('.product-variations').empty();
                $('.product').removeClass('active');
                $('.product-type').css('margin-bottom', "");
                $('#variation-'+id).removeClass('visible');
                // se agrega la variaci贸n actualmente solicitada
                $('#variation-'+id).html(data);
                $('#variation-'+id).addClass('visible');
                $('.gbs_data input').first().focus();

                //se setea el estilo del actual producto y su variaci贸n
                $(self).addClass('active');

                let variationHeight = $('#variation-'+id).height() + 10;
                let productContainerWidht = $('#gbs_productos_list .products').width() - 20;
                let offset = $(self).position().left;


                $(self).css('margin-bottom', variationHeight);
                $('#variation-'+id).css('width', productContainerWidht);
                $('#variation-'+id).css('left', -offset);


                $('body').removeClass('gbs-progress');

                 if (callback != undefined)
                  callback(data);

                _updateInputs();
                _updateSubmitButton();
                _changeVariationLoadFlag();

                _focusActualInput();

            });
        }

        let _sendContent = function(form, action, target, callback){
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


        let _init = () => {
            _updateProducts();
        }


        self.configure = (root) => {
            _root = root;

            document.addEventListener('keydown', function(e) {

                  if (e.shiftKey && e.which == 9){
                    e.preventDefault();
                    e.stopPropagation();
                    if (_getVariationLoadFlag() == true){

                      if ( !_isAddVariationToCartButtonFocused() ){
                        let input = _getPrevFocusableInput();
                      } else{
                        _focusActualInput();
                      }

                    }
                  } else if (e.which == 9){

                    e.preventDefault();
                    e.stopPropagation();

                    if (_getVariationLoadFlag() == true){
                        let inputFocus = _getNextFocusableInput();

                        if (inputFocus == null){

                            if ( !_isAddVariationToCartButtonFocused() )
                                _focusAddVariationToCartButton();
                            else{
                                let product = _getNextFocusableProduct();

                                if (product){
                                    let id = product.getAttribute('data-product');
                                    _loadVariationTable(id, product);
                                }
                            }
                        }
                    }

                }

                if (e.which == 13){
                    e.preventDefault();
                    e.stopPropagation();

                    if (_validateInputs()){
                      let form = $('#gbsAddVariationToCartForm').submit();
                      let product = _getNextFocusableProduct();

                      if (product){
                          let id = product.getAttribute('data-product');
                          _loadVariationTable(id, product);
                      }
                    } else{
                      alert('Se ingresaron valores impares en la tabla.');
                    }
                }
            });
        }

        self.run = () => {

            $(_root).off().on('change', '#selectCategoryForm select', function(){

                $('body').addClass('gbs-progress');
                _loadContentCallback(this, 'gbs_get_products_by_category', '#gbs_productos_list', function(){
                    _init();
                    let firstProduct = _getNextFocusableProduct();
                    let id = firstProduct.getAttribute('data-product');
                    _loadVariationTable(id, firstProduct);

                });
            });


            $(_root).on('click', 'li.product .product-description', function(){
                $('body').addClass('gbs-progress');

                let position = _getProductPosition(this.parentNode);
                _updateProductPosition(position);

                let id = this.parentNode.getAttribute('data-product');
                let product = _getNextFocusableProduct();
                _loadVariationTable(id, product);

            });


            $(_root).on('submit', '#gbsAddVariationToCartForm', function(e){
                  e.preventDefault();
                  e.stopPropagation();
                  $('body').addClass('gbs-progress');
                  let self = this;
                  let target = $(this).closest('.product-type').find('span.qty');
                  _sendContent(this, 'gbs_add_variations_to_cart', target, function(data){
                    let parent = $(self).closest('.product-variations');
                    parent.empty();
                    parent.removeClass('visible');
                    parent.css('width', "");
                    parent.css('left', "");

                    let producto = parent.closest('.product-type');
                    producto.css('margin-bottom', "");

                  });
            });

        }
    }

    return {
        getInstance: function(root){
            if (!instance)
                instance = new TabNavigator();
            instance.configure(root);
            return instance;
        }
    }



})(jQuery);
