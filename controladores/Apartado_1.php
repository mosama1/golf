<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

            $apartado = $con->prepare("SELECT * FROM apartado where idUser = '".$_POST['idUser']."' and fecha >= '".date("Y-m-d")."' group by idcategoria");
            $apartado->execute();
            $apartado=$apartado->fetchAll(PDO::FETCH_OBJ);


        foreach ($apartado as $a) {
      ?>
        <div class="muestra_" id="muestra_<?php echo $a->idDepartamento,'_',$a->idcategoria ?>">
          <div class="titulo">
            <div class="icono">

            </div>
            <div class="text">
              <?php echo $a->nombreCategoria ?>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>
                  <img src="../img/icons/fecha.png" alt="" />
                </th>
                <th>
                  <img src="../img/icons/reloj.png" alt="" />
                </th>
                <th>
                  <img src="../img/icons/factura.png" alt="" />
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $descripcion = $con->prepare("SELECT * FROM apartado where idUser = '".$_POST['idUser']."' and idcategoria = '".$a->idcategoria."'  and fecha >= '".date("Y-m-d")."' ");
              $descripcion->execute();
              $descripcion=$descripcion->fetchAll(PDO::FETCH_OBJ);

                foreach ($descripcion as $d) {
              ?>
              <tr id="<?php echo $d->id; ?>">
                <td><input type="text" name="fecha" class="fech" id="fecha" value="<?php echo date("Y-m-d", strtotime($d->fecha))?>" readonly="readonly"></td>
                <td><input type="text" name="hora[]" class="hr" value="<?php echo date("h:i a", strtotime($d->hora)) ?>" readonly="readonly"></td>
                <td class="precio">
                  <input type="text" name="precio[]" class="tl" value="<?php echo $d->precio ?>" readonly="readonly">
                  <input type="hidden" name="nombre[]" class="nmb" id="nombre" value="<?php echo $d->nombreCategoria ?>" readonly="readonly">
                  <input type="hidden" name="idDepartamento[]" class="cd" id="idDepartamento" value="<?php echo $d->idDepartamento ?>" readonly="readonly">
                  <input type="hidden" name="idCategoria[]" class="ct" value="<?php echo $d->idcategoria ?>" readonly="readonly">
                  <input type="hidden" id="idUser" name="idUser" value="<?php echo $_POST['idUser'] ?>" readonly="readonly">
                </td>
              </tr>
              <?php
                }
               ?>
            </tbody>
          </table>
        </div>
      <?php
        }
