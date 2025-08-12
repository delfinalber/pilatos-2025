<?php
session_start();

const DB_HOST='localhost';
const DB_USER='root';
const DB_PASS='';
const DB_NAME='pilatos';

function db(){
  static $m=null;
  if($m===null){
    $m=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if($m->connect_errno){ http_response_code(500); exit('Error DB'); }
    $m->set_charset('utf8mb4');
  }
  return $m;
}
function guardarFoto($cod,$file){
  if(empty($file['name'])||$file['error']!==UPLOAD_ERR_OK) return null;
  $dir=__DIR__.'/img/fotos/';
  if(!is_dir($dir)) mkdir($dir,0775,true);
  $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
  if(!in_array($ext,['jpg','jpeg','png','webp','gif'])) return null;
  $name='est_'.intval($cod).'_'.time().'.'.$ext;
  $dest=$dir.$name;
  if(!is_uploaded_file($file['tmp_name'])) return null;
  if(!move_uploaded_file($file['tmp_name'],$dest)) return null;
  return 'img/fotos/'.$name;
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

if ($accion==='crear') {
  $cod = intval($_POST['cod_estudiante'] ?? 0);
  $email = trim($_POST['email_estudiante'] ?? '');
  $nom = trim($_POST['nom_estudiante'] ?? '');
  $tel = preg_replace('/\D/','', $_POST['tel_estudiante'] ?? '');
  $ruta = guardarFoto($cod, $_FILES['foto_estudiante'] ?? []);

  if ($cod<=0 || $nom==='' || strlen($tel)<7 || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash']='Datos inválidos.';
    header('Location: registro_estudiante.php'); exit;
  }

  $stmt = db()->prepare("INSERT INTO estudiante (cod_estudiante,email_estudiante,nom_estudiante,tel_estudiante,foto_estudiante) VALUES (?,?,?,?,?)");
  $stmt->bind_param('issis',$cod,$email,$nom,$tel,$ruta);
  if($stmt->execute()){
    $_SESSION['flash']='Registro completado correctamente.';
    header('Location: registro_estudiante.php?ok=1'); exit;
  } else {
    $_SESSION['flash']='Error: '.$stmt->error;
    header('Location: registro_estudiante.php'); exit;
  }
}

if ($accion==='eliminar') {
  $id=intval($_GET['id'] ?? 0);
  if($id>0){
    $stmt=db()->prepare("DELETE FROM estudiante WHERE id_estudiante=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $_SESSION['flash']=$stmt->errno?('Error: '.$stmt->error):'Registro eliminado.';
  }
  header('Location: registro_estudiante.php'); exit;
}

if ($accion === 'actualizar') {
    $id = intval($_POST['id_estudiante'] ?? 0);
    $cod = intval($_POST['cod_estudiante'] ?? 0);
    $email = trim($_POST['email_estudiante'] ?? '');
    $nom = trim($_POST['nom_estudiante'] ?? '');
    $tel = preg_replace('/\D/', '', $_POST['tel_estudiante'] ?? '');
    $ruta = guardarFoto($cod, $_FILES['foto_estudiante'] ?? []);

    if ($id <= 0 || $cod <= 0 || $nom === '' || strlen($tel) < 7 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash'] = 'Datos inválidos.';
        header('Location: registro_estudiante.php');
        exit;
    }

    if ($ruta) {
        $stmt = db()->prepare("UPDATE estudiante SET cod_estudiante=?, email_estudiante=?, nom_estudiante=?, tel_estudiante=?, foto_estudiante=? WHERE id_estudiante=?");
        $stmt->bind_param('issssi', $cod, $email, $nom, $tel, $ruta, $id);
    } else {
        $stmt = db()->prepare("UPDATE estudiante SET cod_estudiante=?, email_estudiante=?, nom_estudiante=?, tel_estudiante=? WHERE id_estudiante=?");
        $stmt->bind_param('isssi', $cod, $email, $nom, $tel, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['flash'] = 'Registro actualizado correctamente.';
        // Eliminar caché e historial
        header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Location: registro_estudiante.php?ok=1');
        exit;
    } else {
        $_SESSION['flash'] = 'Error: ' . $stmt->error;
        header('Location: registro_estudiante.php');
        exit;
    }
}
?>

<!-- Modal Editar Estudiante -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" id="formEditar" method="post" action="acciones.php" enctype="multipart/form-data" autocomplete="off" style="background-color: #fff; border-radius: 0.5rem;">
      <input type="hidden" name="accion" value="actualizar">
      <input type="hidden" name="id_estudiante" id="edit_id_estudiante">
      <input type="hidden" name="redirect" value="registro_estudiante.php">
      <div class="modal-header" style="background-color: #0d6efd; color: #fff;">
        <h5 class="modal-title" id="modalEditarLabel">Editar Estudiante</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" style="background-color: #f8f9fa;">
        <div class="mb-2">
          <label class="form-label" style="color: #0d6efd;">Código estudiante</label>
          <input type="number" class="form-control" name="cod_estudiante" id="edit_cod_estudiante" maxlength="11" required>
        </div>
        <div class="mb-2">
          <label class="form-label" style="color: #0d6efd;">Nombre</label>
          <input type="text" class="form-control" name="nom_estudiante" id="edit_nom_estudiante" required>
        </div>
        <div class="mb-2">
          <label class="form-label" style="color: #0d6efd;">Email</label>
          <input type="email" class="form-control" name="email_estudiante" id="edit_email_estudiante" required>
        </div>
        <div class="mb-2">
          <label class="form-label" style="color: #0d6efd;">Teléfono</label>
          <input type="tel" class="form-control" name="tel_estudiante" id="edit_tel_estudiante" minlength="7" maxlength="12" required>
        </div>
        <div class="mb-3">
          <label class="form-label" style="color: #0d6efd;">Foto (se guardará la ruta)</label>
          <input type="file" class="form-control" name="foto_estudiante" id="edit_foto_estudiante" accept="image/*">
          <div class="form-text">Se almacena en img/fotos</div>
          <div id="edit_foto_actual" class="mt-2"></div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #f8f9fa;">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
<!-- Fin Modal Editar Estudiante -->

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
>Editar</button>
