<?php
# aqui llamamos la sesion 
session_start();

# datos de conexión
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','pilatos');

# Función conexión a la base de datos
function db(){
  static $m=null;
  if($m===null){
    $m=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if($m->connect_errno){ http_response_code(500); exit('Error DB'); }
    $m->set_charset('utf8mb4');
  }
  # retorna la conexion a la base de datos
  return $m;
}

#funcion para guardar la foto, con el formato permitido, la ubicación o directorio donde se guarda la foto
function guardarFoto($cod,$file){
  if(empty($file['name'])||$file['error']!==UPLOAD_ERR_OK) return null;
  #directorio o ubicacion de la foto
  $dir=__DIR__.'/img/fotos/';
  if(!is_dir($dir)) mkdir($dir,0775,true);
  $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
  #formato de la foto
  if(!in_array($ext,['jpg','jpeg','png','webp','gif'])) return null;

  $name='est_'.intval($cod).'_'.time().'.'.$ext;
  $dest=$dir.$name;

  if(!is_uploaded_file($file['tmp_name'])) return null;
  # validación si no se modifica la foto se deja la misma sin problema
  if(!move_uploaded_file($file['tmp_name'],$dest)) return null;

  // Ruta relativa para guardar en la BD
  return 'img/fotos/'.$name;
}
# acciones para el registro nuevo de un estudiante
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'registro_hombre.php';
# recibir información del formulario registro aprendiz
if ($accion==='crear') {
  $cod = intval($_POST['cod_hombre'] ?? 0);
  $ruta1 = guardarFoto($cod, $_FILES['img_hombre_1'] ?? []);
  $ruta2 = guardarFoto($cod, $_FILES['img_hombre_2'] ?? []);
  $ruta3 = guardarFoto($cod, $_FILES['img_hombre_3'] ?? []);
  $ruta4 = guardarFoto($cod, $_FILES['img_hombre_4'] ?? []);
  $nom = trim($_POST['nom_produc_hombre'] ?? '');
  $descripcion = trim($_POST['descripcion_hombre'] ?? '');
  $precio = trim($_POST['precio_hombre'] ?? '');  
  #  validación de que los campos cumpla con los requerimientos de javascript
  if ($cod<=0 || $nom==='' || $descripcion=== '' || $precio=== '') {
    $_SESSION['flash']='Datos inválidos.';
    header('Location: '.$redirect); exit;
  }
 #insertar a la tabla estudiantes
  $stmt = db()->prepare("INSERT INTO hombre (cod_hombre,img_hombre_1,img_hombre_2,img_hombre_3,img_hombre_4,nom_produc_hombre,descripcion_hombre,precio_hombre) VALUES (?,?,?,?,?,?,?,?)");
  // cod:int, ruta1:str, ruta2:str, ruta3:str, ruta4:str, nom:str, descripcion:str, precio:str
  $stmt->bind_param('isssssss',$cod,$ruta1,$ruta2,$ruta3,$ruta4,$nom,$descripcion,$precio);
  // Validar que al menos una imagen haya sido subida, si no, asignar una imagen por defecto
  if(!$ruta1 && !$ruta2 && !$ruta3 && !$ruta4){
    $ruta1 = 'img/fotos/default.png'; // Asegúrate de tener esta imagen en el directorio correspondiente
  }
  if($stmt->execute()){
    #si todos los campos estan llenos se envia o registra la información
    $_SESSION['flash']='Registro completado correctamente.';
    header('Location: '.$redirect.'?ok=1'); exit;
  } else {
    $_SESSION['flash']='Error: '.$stmt->error;
    header('Location: '.$redirect); exit;
  }
}
# Eliminar
if ($accion==='eliminar') {
  $id=intval($_GET['id_hombre'] ?? 0);
  if($id>0){
    // (Opcional) obtener y borrar archivo físico si deseas
    /*
    if ($res = db()->prepare("SELECT foto_estudiante FROM estudiante WHERE id_estudiante=?")) {
      $res->bind_param('i',$id);
      $res->execute();
      $res->bind_result($foto);
      if($res->fetch() && $foto){
        $path = __DIR__ . '/' . ltrim($foto,'/');
        if (is_file($path)) @unlink($path);
      }
      $res->close();
    }
    */
    $stmt=db()->prepare("DELETE FROM hombre WHERE id_hombre=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $_SESSION['flash']=$stmt->errno?('Error: '.$stmt->error):'Registro eliminado.';
  }
  header('Location: '.$redirect); exit;
}
# actualizar en el modal
if ($accion === 'actualizar') {
  $id = intval($_POST['id_hombre'] ?? 0);
  $cod = intval($_POST['cod_hombre'] ?? 0);
  $ruta1 = guardarFoto($cod, $_FILES['img_hombre_1'] ?? []);
  $ruta2 = guardarFoto($cod, $_FILES['img_hombre_2'] ?? []);
  $ruta3 = guardarFoto($cod, $_FILES['img_hombre_3'] ?? []);
  $ruta4 = guardarFoto($cod, $_FILES['img_hombre_4'] ?? []);
  $nom = trim($_POST['nom_produc_hombre'] ?? '');
  $descripcion = trim($_POST['descripcion_hombre'] ?? '');
  $precio = trim($_POST['precio_hombre'] ?? '');

  if ($id <= 0 || $cod <= 0 || $nom === '' || $descripcion === '' || $precio === '') {
      $_SESSION['flash'] = 'Datos inválidos.';
      header('Location: '.$redirect);
      exit;
  }

  // Obtener fotos actuales si no se suben nuevas
  $fotos_actuales = [];
  if ($stmt = db()->prepare("SELECT img_hombre_1, img_hombre_2, img_hombre_3, img_hombre_4 FROM hombre WHERE id_hombre=?")) {
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->bind_result($fotos_actuales['img_hombre_1'], $fotos_actuales['img_hombre_2'], $fotos_actuales['img_hombre_3'], $fotos_actuales['img_hombre_4']);
      $stmt->fetch();
      $stmt->close();
  }

  // Procesar nuevas fotos si se suben
  $ruta1 = guardarFoto($cod, $_FILES['img_hombre_1'] ?? []) ?: $fotos_actuales['img_hombre_1'] ?? null;
  $ruta2 = guardarFoto($cod, $_FILES['img_hombre_2'] ?? []) ?: $fotos_actuales['img_hombre_2'] ?? null;
  $ruta3 = guardarFoto($cod, $_FILES['img_hombre_3'] ?? []) ?: $fotos_actuales['img_hombre_3'] ?? null;
  $ruta4 = guardarFoto($cod, $_FILES['img_hombre_4'] ?? []) ?: $fotos_actuales['img_hombre_4'] ?? null;

  // Actualizar en la tabla hombre
  $stmt = db()->prepare("UPDATE hombre SET cod_hombre=?, img_hombre_1=?, img_hombre_2=?, img_hombre_3=?, img_hombre_4=?, nom_produc_hombre=?, descripcion_hombre=?, precio_hombre=? WHERE id_hombre=?");
  $stmt->bind_param('isssssssi', $cod, $ruta1, $ruta2, $ruta3, $ruta4, $nom, $descripcion, $precio, $id);

  if ($stmt->execute()) {
      $_SESSION['flash'] = 'Registro actualizado correctamente.';
      // Evitar caché al volver
      header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
      header('Cache-Control: post-check=0, pre-check=0', false);
      header('Pragma: no-cache');
      header('Location: '.$redirect.'?ok=1');
      exit;
  } else {
      $_SESSION['flash'] = 'Error: ' . $stmt->error;
      header('Location: '.$redirect);
      exit;
  }
}

// Si llega aquí sin coincidencia, redirigir al listado
header('Location: '.$redirect); exit;
