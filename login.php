<div id="back">
  <div class="back_degradado"></div>
  
</div>
<div class="login-box">

  <div class="login-logo">
    <img src="vistas/img/plantilla/logo_brivait.svg" class="img-responsive" style="padding: 0px 100px 0px 100px; width: 100%;">
  </div>

  <!-- /.login-logo -->
  <div class="card">

    <div class="card-body login-card-body">

      <h4 class="login-box-msg py-3">Cotizaciones de Servicios</h4>


      <form method="post">
        <!-- Usuario -->
        <div class="input-group mb-3">

          <input type="text" class="form-control py-4" placeholder="Usuario" name="ingUsuario" required>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>

        </div>

        <!-- Password -->
        <div class="input-group mb-4">

          <input type="password" class="form-control py-4" placeholder="Contraseña" name="ingPassword" required>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

        </div>

        <div class="row justify-content-center">
          <!-- Boton -->
          <div class="col-7">
            <button type="submit" class="btn btn-block text-white" style="background: #fa7e07; border-color: #fa7e07; ">Ingresar</button>
          </div> 

        </div>

        <?php 

          $login = new ControladorUsuarios();
          $login -> ctrIngresoUsuario();

         ?>

      </form>
    </div>
  </div>
</div>