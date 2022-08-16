<!-- ==================
  CONTENIDO
=================== -->

<div class="content-wrapper">
  <!-- cabecera del contenido -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Administrar Usuarios</h1>

        </div>

        <!-- Ruta guia -->
        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Panel de Control</li>
          </ol>

        </div>

      </div>

    </div>
  </section>

  <!-- Contenido -->
  <section class="content">

    <div class="card">
      <div class="card-header">

        <!-- Boton Agregar usuario -->
        <button class="btn btn-primary btnAgregarUsuario" data-toggle="modal" data-target="#modalAgregarUsuario">
          <i class="fa fa-user-plus"></i> Agregar usuario
        </button>

      </div>

      <div class="card-body">

        <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%;">
          


          <thead> 
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Paterno</th>
              <th>Materno</th>
              <th>Usuario</th>
              <th>Foto</th>
              <th>Rol</th>
              <th>Estado</th>
              <th>Último ingreso</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tboby>
          <?php 

          $item = null;
          $valor = null;
          $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

          $cont = 1;
          // var_dump($usuarios);
          foreach ($usuarios as $key => $value) {
            
            echo '
            <tr>
              <td>'.$cont.'</td>
              <td>'.$value["nombre"].'</td>
              <td>'.$value["ap_paterno"].'</td>
              <td>'.$value["ap_materno"].'</td>
              <td>'.$value["usuario_login"].'</td>';

              if ($value['foto'] != "") {
                echo '<td><img src="'.$value['foto'].'" class="img-thumbnail" width="40px"></td>';
              }else{
                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
              }
                           
              echo '
              <td>'.$value["rol"].'</td>';

              if ($value["estado"] != "0") {
                echo '<td><button class="btn btn-success btn-sm btnActivar" idUsuario="'.$value["ci_usuario"].'" estadoUsuario="0">Activado</button></td>';
              }else{
                echo '<td><button class="btn btn-danger btn-sm btnActivar" idUsuario="'.$value["ci_usuario"].'" estadoUsuario="1">Desactivado</button></td>';
              }

              echo '
              <td>'.$value['ultimo_ingreso'].'</td>
              <td>
                <div class="btn-group">

                  <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value['ci_usuario'].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value['ci_usuario'].'" fotoUsuario = "'.$value['foto'].'"><i class="fa fa-trash-alt"></i></button>
                  
                </div>
                
              </td>
            </tr>';
          
          $cont++;
          }
          ?>

        </button>

          </tboby> 

        </table>

      </div>

      <!-- <div class="card-footer">
        Footer
      </div> -->

    </div>

  </section>

</div>

<!-- MODAL PARA AGREGAR USUARIO -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <form role="form" method="POST" enctype="multipart/form-data">

      <div class="modal-content">

        <!-- cabecera modal -->
        <div class="modal-header py-3" style="background: #FD7E14; color: white;">

          <h5 class="modal-title" id="agregarModalLabel">
            <i class="fa fa-user-plus"></i> Agregar Ususario
          </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <!-- contenido modal -->
        <div class="modal-body">
          
          <div class="card-body">
            
            <div class="form-group">

              <div class="form-group">

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Carnet Identidad  -->
                    <div class="form-group">
                      <label for="nuevoCarnet">Carnet de Identidad<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="nuevoCarnet" name="nuevoCarnet" required>
                    </div>

                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Nombre  -->
                    <div class="form-group">
                      <label for="inputNombre">Nombres<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="inputNombre" name="nuevoNombre" required>
                    </div>
              
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Paterno  -->
                    <div class="form-group">
                      <label for="inputPaterno">Apellido Paterno<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="inputPaterno" name="nuevoPaterno" required>
                    </div>

                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Materno  -->
                    <div class="form-group">
                      <label for="inputMaterno">Apellido Materno</label>
                      <input type="text" class="form-control" id="inputMaterno" name="nuevoMaterno" required>
                    </div>
              
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Celular  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupTelefono"><i class="fa fa-phone"></i></div>
                      </div>

                      <input type="tef" class="form-control" placeholder="Celular o Teléfono *" name="nuevoTelefono" required>
                    </div>
                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Nuevo Email  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupEmail"><i class="fa fa-envelope"></i></div>
                      </div>

                      <input type="email" class="form-control" placeholder="Ingresar email *" name="nuevoEmail" required>
                    </div>
              
                  </div>
                  
                </div>

                <hr>

                <div class="row">

                  <div class="col-lg-6 col-12">

                    <div class="card bg-light ">

                      <div class="card-body cardNuevoUsuario">
                         <!-- Input Nuevo Usuario  -->
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupLogin"><i class="fa fa-user"></i></div>
                          </div>

                          <input type="text" class="form-control" placeholder="Ingresar usuario*" name="nuevoUsuarioLogin" id="nuevoUsuarioLogin" required>
                        </div>
                        <!-- Input Nuevo Password  -->
                        <div class="input-group pt-4">
                          <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupPass"><i class="fa fa-key"></i></div>
                          </div>

                          <input type="password" class="form-control" placeholder="Ingresar contraseña*" name="nuevoPassword" required>
                        </div>
                      </div>

                    </div>            

                  </div>

                  <div class="col-lg-6 col-12">


                     <!-- Input Rol  -->
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupRol"><i class="fa fa-users"></i></div>
                      </div>

                      <select class="form-control" name="nuevoRol" id="nuevoRol" required>
                        <option value="">Seleccionar rol*</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Especial">Especial</option>
                        <option value="Vendedor">Vendedor</option>
                      </select>
                    </div>

                    <!-- Input SUBIR FOTO  -->
                    <div class="form-group pt-4">
                      <div class="panel">SUBIR FOTO</div>

                      <input type="file" class="nuevaFoto" name="nuevaFoto">
                      <small class="form-text text-muted">Peso maximo de la foto 3MB.</small>

                      <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

                    </div>

                  </div>
                  

                  
                  
                </div>
                

                <div class="row">

                  

                  <div class="col-lg-6 col-12 pt-2">
                    
              
                  </div>
                  
                </div>

              </div>

            </div>

          </div> <!-- fin body modal -->

          <!-- footer modal -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">
              Guardar usuario
            </button>

          </div><!-- fin footer modal -->

        </div>

      </div>

      <?php 
        $crearUsuario = new ControladorUsuarios();
        $crearUsuario->ctrCrearUsuario();

       ?>
    </form>
  </div>
</div>


<!-- MODAL PARA EDITAR USUARIO -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="EditarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form role="form" method="POST" enctype="multipart/form-data">

      <div class="modal-content">

        <!-- cabecera modal -->
        <div class="modal-header py-3" style="background: #FD7E14; color: white;">

          <h5 class="modal-title" id="EditarModalLabel">
            <i class="fa fa-user-plus"></i> Editar Ususario
          </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <!-- contenido modal -->
        <div class="modal-body">
          
          <div class="card-body">
            
            <div class="form-group">

              <div class="form-group">

                

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Carnet Identidad  -->
                    <div class="form-group">
                      <label for="editarCarnet">Carnet de Identidad<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="editarCarnet" name="editarCarnet" readonly>
                    </div>

                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Nombre  -->
                    <div class="form-group">
                      <label for="editarNombre">Nombre<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="editarNombre" name="editarNombre" required>
                    </div>
              
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Paterno  -->
                    <div class="form-group">
                      <label for="editarPaterno">Apellido Paterno<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="editarPaterno" name="editarPaterno" required>
                    </div>

                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Materno  -->
                    <div class="form-group">
                      <label for="editarMaterno">Apellido Materno<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="editarMaterno" name="editarMaterno" required>
                    </div>
              
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Celular  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupEditTelefono"><i class="fa fa-phone"></i></div>
                      </div>

                      <input type="tef" class="form-control" id="editarTelefono" name="editarTelefono" required><span class="text-danger">*</span>
                    </div>
                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Email  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupEditEmail"><i class="fa fa-envelope"></i></div>
                      </div>

                      <input type="email" class="form-control" id="editarEmail" name="editarEmail" required>
                    </div>
              
                  </div>
                  
                </div>

                <hr>

                <div class="row">

                  <div class="col-lg-6 col-12">
                     <!-- Input Usuario  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupEditUsuario"><i class="fa fa-user"></i></div>
                      </div>

                      <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" required>
                    </div>
                  </div>

                  <div class="col-lg-6 col-12">
                     <!-- Input Password  -->
                    <div class="input-group pt-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupEditPass"><i class="fa fa-lock"></i></div>
                      </div>

                      <input type="password" class="form-control" placeholder="Escriba la nueva contraseña" name="editarPassword" >

                      <input type="hidden" id="passwordActual" name="passwordActual">
                    </div>
              
                  </div>
                  
                </div>
                

                <div class="row">

                  <div class="col-lg-6 col-12 pt-4">
                     <!-- Input Rol  -->
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupAddonRol"><i class="fa fa-key"></i></div>
                      </div>

                      <select class="form-control" name="editarRol" id="editarRol" required>
                        <option value="">Seleccionar rol*</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Especial">Especial</option>
                        <option value="Vendedor">Vendedor</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-6 col-12 pt-4">
                    <!-- Input SUBIR FOTO  -->
                    <div class="form-group">
                      <div class="panel">SUBIR FOTO</div>

                      <input type="file" class="nuevaFoto" name="editarFoto">
                      <small class="form-text text-muted">Peso maximo de la foto 3MB.</small>

                      <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

                      <input type="hidden" name="fotoActual" id="fotoActual">

                    </div>
              
                  </div>
                  
                </div>

              </div>

            </div>

          </div>

          <!-- footer modal -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">
              Modificar usuario
            </button>

          </div>

        </div>
      </div>

      <?php 
        $crearUsuario = new ControladorUsuarios();
        $crearUsuario->ctrEditarUsuario();

       ?>
    </form>
  </div>
</div>

<?php 
  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario->ctrEliminarUsuario();

 ?>
