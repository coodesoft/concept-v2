<?php

// TODO: corregir el html  porque es copia de SucursalDOM
class ListaPreciosDOM {


    static function selector($listas){ ?>

        <div class="listaPreciosSelection cuatrocol" style="margin-right:1%">
            <?php if (count($listas) > 1) {?>
              <div>Seleccione la lista de precios:</div>
              <div id="listaPreciosList">
                  <select name="priceList" id ="selectListaPrecios" required>
                      <option  value="" disabled selected>Seleccione una lista de precios</option>
                      <?php foreach ($listas as $key => $lista) { ?>
                          <option value="<?php echo $lista['list_id']; ?>"><?php echo $lista['name']?></option>
                      <?php }?>
                  </select>
              </div>
            <?php } else { ?>
              <div class="listaPreciosList cuatrocol">
                <div>Lista de precios:</div>
                <input type="text" disabled value="<?php echo $listas[0]['name']?>" name="pricelist_name">
                <input type="hidden" value="<?php echo $listas[0]['list_id']?>" name="priceList">
              </div>
            <?php } ?>
        </div>

    <?php }
}

?>
