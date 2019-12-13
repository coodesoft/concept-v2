<?php

class SucursalDOM {


    static function selector($sucursales){ ?>

        <div class="sucursalSelection cuatrocol">
            <?php $count = count($sucursales);
            if ( $count>1 ){ ?>
                <div>Seleccione la sucursal:</div>
                <div id="sucursalesList">
                    <select id="selectSucursal" name="sucursal" required>
                      <option value="" disabled selected>Seleccione una sucursal</option>
                      <?php foreach($sucursales as $sucursal) { ?>
                          <option value="<?php echo $sucursal['id'] ?>"><?php echo $sucursal['sucursal']?></option>
                      <?php } ?>
                    </select>
                </div>
            <?php } elseif ($count == 1) { ?>
            <div class="sucursalesList cuatrocol">
              <div>Sucursal:</div>
              <input type="text" disabled value="<?php echo $sucursales[0]['sucursal']?>" name="sucursal_name">
              <input type="hidden" value="<?php echo $sucursales[0]['id']?>" name="sucursal">
            </div>
          <?php } ?>
        </div>

    <?php }
}

?>
