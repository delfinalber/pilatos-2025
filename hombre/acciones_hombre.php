<?php
# aqui llamamos la sesion 
session_start();

# datos de conexión
const DB_HOST='localhost';
const DB_USER='root';
const DB_PASS='';
const DB_NAME='pilatos';

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
  $cod_hombre = intval($_POST['cod_hombre'] ?? 0);
  $ruta1 = guardarFoto($cod_hombre, $_FILES['foto1_hombre'] ?? []);
  $ruta2 = guardarFoto($cod_hombre, $_FILES['foto2_hombre'] ?? []);
  $ruta3 = guardarFoto($cod_hombre, $_FILES['foto3_hombre'] ?? []);
  $ruta4 = guardarFoto($cod_hombre, $_FILES['foto4_hombre'] ?? []);
  $nom_produc_hombre = trim($_POST['nom_produc_hombre'] ?? '');
  $descripcion_hombre = trim($_POST['descripcion_hombre'] ?? '');
  $precio_hombre = trim($_POST['precio_hombre] ?? '');

  







  

 #insertar a la tabla hombre
  $stmt = db()->prepare("INSERT INTO hombre (cod_hombre,img_hombre_1,img_hombre_2,img_hombre_3,img_hombre_4,nom_produc_hombre,descripcion_hombre,precion_hombre) VALUES (?,?,?,?,?,?,?,?)");
  // cod:int, email:str, nom:str, tel:str, ruta:str
  $stmt->bind_param('issss',$cod,$email,$nom,$tel,$ruta);
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
  $id=intval($_GET['id'] ?? 0);
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
    $stmt=db()->prepare("DELETE FROM estudiante WHERE id_estudiante=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $_SESSION['flash']=$stmt->errno?('Error: '.$stmt->error):'Registro eliminado.';
  }
  header('Location: '.$redirect); exit;
}
# actualizar en el modal
if ($accion === 'actualizar') {
  $id = intval($_POST['id_estudiante'] ?? 0);
  $cod = intval($_POST['cod_estudiante'] ?? 0);
  $email = trim($_POST['email_estudiante'] ?? '');
  $nom = trim($_POST['nom_estudiante'] ?? '');
  $tel = preg_replace('/\D/', '', $_POST['tel_estudiante'] ?? '');
  $ruta = guardarFoto($cod, $_FILES['foto_estudiante'] ?? []);

  if ($id <= 0 || $cod <= 0 || $nom === '' || strlen($tel) < 7 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['flash'] = 'Datos inválidos.';
      header('Location: '.$redirect);
      exit;
  }
# actualizar pero en la tabla estudiante
  if ($ruta) {
      $stmt = db()->prepare("UPDATE estudiante SET cod_estudiante=?, email_estudiante=?, nom_estudiante=?, tel_estudiante=?, foto_estudiante=? WHERE id_estudiante=?");
      $stmt->bind_param('issssi', $cod, $email, $nom, $tel, $ruta, $id);
  } else {
      $stmt = db()->prepare("UPDATE estudiante SET cod_estudiante=?, email_estudiante=?, nom_estudiante=?, tel_estudiante=? WHERE id_estudiante=?");
      $stmt->bind_param('isssi', $cod, $email, $nom, $tel, $id);
  }

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
