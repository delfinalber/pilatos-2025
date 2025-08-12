<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTUDIANTES</title>
    <link rel="shrotcut icon" href="../Img/Logo.png">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
       
    

    
</head>
<body>
    
  <div class="row">
    <div class="col-md-12">
        <center>
            
            <p >ENVIOS GRATIS POR COMPRAS SUPERIORES A $350.000</p>
        </center>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      
      <center>
      
            <img id="pilatos" src="../img/Pilatos.webp" alt="" >
        
        </center>
       
    </div>
</div>

   

  <div class="row">

       <div style="text-align: center;">

         <!-- Inicio de la barra de navegacion -->

         <nav class="navbar navbar-expand-lg bg-white" style="display: inline-block;">
            <div class="container-fluid">
              <a class="navbar-brand" href="https://www.pilatos.com/" >PILATOS</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link " href="../estudiante/registro_estudiante.php"   aria-expanded="false">
                    ESTUDIANTE
                    </a>
                    
                  </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../hombre/hombre.html"   aria-expanded="false">
                          HOMBRE
                        </a>
                        
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="../mujer/mujer.html"  aria-expanded="false">
                        MUJER
                      </a>
                        
                  </li>
                      
                    <li class="nav-item ">
                      <a class="nav-link " href="../sale/sale.html"   aria-expanded="false">
                        SALE
                      </a>
                       
                    </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../nuevo/nuevo.html" >NUEVO</a>
                  </li>
                  
                </ul>
              </div>
            </div>
        </nav>

        <!--Fin de la barra de navegacion-->

       </div>

    </div>

    <div class="row">

        <div>
            <img src="../Img/Envio.jpg" alt="" style="width: 100%; padding: 10px;">
        </div>

    </div>

    <br><br>
    
  <!-- inicio formulario registro -->
  <!-- Lateral izquierdo: formulario -->
   <div class="row g-4">
 <?php
session_start();
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$mysqli = new mysqli('localhost','root','', 'pilatos');
if ($mysqli->connect_errno) { die('Error de conexión'); }
$mysqli->set_charset('utf8mb4');

$buscar = isset($_GET['buscar']) && $_GET['buscar']!=='' ? (int)$_GET['buscar'] : null;
$where = $buscar ? "WHERE cod_estudiante=".$buscar : '';
$rows = $mysqli->query("SELECT * FROM estudiante $where ORDER BY id_estudiante DESC");
function esc($s){ return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8'); }
?>
<link rel="stylesheet" href="css/app.css">
<header class="header py-3 shadow-sm">
  <div class="container">
    <h1 class="h4 mb-0">Gestión de Estudiantes</h1>
  </div>
</header>

<main class="container my-4">
  <?php if($flash): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <?php echo esc($flash); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Lateral izquierdo: formulario -->
    <div class="col-12 col-lg-4">
      <div class="card card-form shadow sidebar">
        <div class="card-body">
          <h2 class="h5 mb-3">Nuevo estudiante</h2>
          <form id="formCrear" class="needs-validation" novalidate action="acciones.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id_estudiante" value="">
            <div class="mb-2">
              <label class="form-label">Código estudiante</label>
              <input type="number" class="form-control" name="cod_estudiante" maxlength="11" required>
              <div class="invalid-feedback">Ingrese el código (numérico).</div>
            </div>
            <div class="mb-2">
              <label class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nom_estudiante" required>
              <div class="invalid-feedback">Ingrese el nombre.</div>
            </div>
            <div class="mb-2">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email_estudiante" required>
              <div class="invalid-feedback">Correo inválido.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Teléfono</label>
              <input type="tel" class="form-control" name="tel_estudiante" minlength="7" maxlength="12" required>
              <div class="invalid-feedback">Entre 7 y 12 dígitos.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Foto (se guardará la ruta)</label>
              <input type="file" class="form-control" name="foto_estudiante" accept="image/*">
              <div class="form-text">Se almacena en img/fotos</div>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" type="submit">Registrar</button>
              <button class="btn btn-outline-primary" type="reset">Limpiar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Centro: buscador + tabla -->
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow mb-3">
        <div class="card-body">
          <form class="row g-2 align-items-center" method="get">
            <div class="col-sm-8">
              <input type="number" name="buscar" class="form-control" placeholder="Buscar por cod_estudiante" value="<?php echo $buscar ? (int)$buscar : ''; ?>">
            </div>
            <div class="col-sm-4 d-flex gap-2">
              <button class="btn btn-primary w-50" type="submit">Buscar</button>
              <a class="btn btn-outline-primary w-50" href="registro_estudiante.php">Ver todos</a>
            </div>
          </form>
        </div>
      </div>

      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Foto</th>
                  <th>Fecha</th>
                  <th class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php if($rows && $rows->num_rows): ?>
                <?php while($r=$rows->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo $r['id_estudiante']; ?></td>
                    <td><?php echo $r['cod_estudiante']; ?></td>
                    <td><?php echo esc($r['nom_estudiante']); ?></td>
                    <td><?php echo esc($r['email_estudiante']); ?></td>
                    <td><?php echo esc($r['tel_estudiante']); ?></td>
                    <td>
                      <?php if(!empty($r['foto_estudiante'])): ?>
                        <img src="<?php echo esc($r['foto_estudiante']); ?>" class="img-mini" alt="">
                      <?php else: ?>—<?php endif; ?>
                    </td>
                    <td><?php echo $r['fecha']; ?></td>
                    <td class="text-end">
                      <a href="acciones.php?accion=eliminar&id=<?php echo $r['id_estudiante']; ?>" class="btn btn-sm btn-danger" data-confirm="¿Eliminar este registro?">Eliminar</a>
                      <button 
                      type="button" 
                      class="btn btn-sm btn-warning btn-editar"
                      data-id="<?php echo $r['id_estudiante']; ?>"
                      data-cod="<?php echo $r['cod_estudiante']; ?>"
                      data-nom="<?php echo esc($r['nom_estudiante']); ?>"
                      data-email="<?php echo esc($r['email_estudiante']); ?>"
                      data-tel="<?php echo esc($r['tel_estudiante']); ?>"
                      data-foto="<?php echo esc($r['foto_estudiante']); ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEditar"
                      onclick="setEditModalData(this)"
                      >Editar</button>
                      </td>
                      </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr><td colspan="8" class="text-center">Sin registros</td></tr>
                    <?php endif; ?>
                    </tbody>
                    </table>
                    </div>
                  </div>
                  </div>

                  <!-- Modal Editar Estudiante -->
                    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <?php
                    // Si se recibe un id_estudiante por GET, traer datos para el modal (edición directa por URL)
                    $editData = null;
                    if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
                      $idEdit = (int)$_GET['edit'];
                      $resEdit = $mysqli->query("SELECT * FROM estudiante WHERE id_estudiante = $idEdit LIMIT 1");
                      if ($resEdit && $resEdit->num_rows) {
                        $editData = $resEdit->fetch_assoc();
                      }
                    }
                    ?>
                    <form class="modal-content" id="formEditar" method="post" action="acciones.php" enctype="multipart/form-data" autocomplete="off" style="background-color: #fff; border-radius: 0.5rem;">
                      <input type="hidden" name="id_estudiante" id="id_estudiante" value="<?php echo isset($editData['id_estudiante']) ? esc($editData['id_estudiante']) : ''; ?>">
                      <input type="hidden" name="id_estudiante" id="id_estudiante" value="<?php echo $editData ? esc($editData['id_estudiante']) : ''; ?>">
                      <input type="hidden" name="redirect" value="registro_estudiante.php">
                      <div class="modal-header" style="background-color: #0d6efd; color: #fff;">
                      <h5 class="modal-title" id="modalEditarLabel">Editar Estudiante</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body" style="background-color: #f8f9fa;">
                      <div class="mb-2">
                        <label class="form-label" style="color: #0d6efd;">Código estudiante</label>
                        <input type="number" class="form-control" name="cod_estudiante" id="cod_estudiante" maxlength="11" required value="<?php echo $editData ? esc($editData['cod_estudiante']) : ''; ?>">
                      </div>
                      <div class="mb-2">
                        <label class="form-label" style="color: #0d6efd;">Email</label>
                        <input type="email" class="form-control" name="email_estudiante" id="email_estudiante" required value="<?php echo $editData ? esc($editData['email_estudiante']) : ''; ?>">
                      </div>
                      <div class="mb-2">
                        <label class="form-label" style="color: #0d6efd;">Nombre</label>
                        <input type="text" class="form-control" name="nom_estudiante" id="nom_estudiante" required value="<?php echo $editData ? esc($editData['nom_estudiante']) : ''; ?>">
                      </div>
                      
                      <div class="mb-2">
                        <label class="form-label" style="color: #0d6efd;">Teléfono</label>
                        <input type="tel" class="form-control" name="tel_estudiante" id="tel_estudiante" minlength="7" maxlength="12" required value="<?php echo $editData ? esc($editData['tel_estudiante']) : ''; ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label" style="color: #0d6efd;">Foto (se guardará la ruta)</label>
                        <input type="file" class="form-control" name="foto_estudiante" id="foto_estudiante" accept="image/*">
                        <div class="form-text">Se almacena in