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



$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'registro_usuario.php';

if ($accion==='crear') {
  $usuario = trim($_POST['usuario'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if (!filter_var($usuario, FILTER_VALIDATE_EMAIL) || $password === '') {
    $_SESSION['flash']='Datos inválidos. Verifique correo y contraseña.';
    header('Location: '.$redirect); exit;
  }

  $stmt = db()->prepare("INSERT INTO sesion (usuario,password) VALUES (?,?)");
  $stmt->bind_param('ss',$usuario,$password);
  if($stmt->execute()){
    $_SESSION['flash']='Registro completado correctamente.';
    header('Location: '.$redirect.'?ok=1'); exit;
  } else {
    $_SESSION['flash']='Error: '.$stmt->error;
    header('Location: '.$redirect); exit;
  }
}

if ($accion==='eliminar') {
  $id=intval($_GET['id_sesion'] ?? 0);
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
    $stmt=db()->prepare("DELETE FROM sesion WHERE id_sesion=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $_SESSION['flash']=$stmt->errno?('Error: '.$stmt->error):'Registro eliminado.';
  }
  header('Location: '.$redirect); exit;
}

if ($accion === 'actualizar') {
  $id = intval($_POST['id_sesion'] ?? 0);
  $usuario = trim($_POST['usuario'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($id <= 0 || !filter_var($usuario, FILTER_VALIDATE_EMAIL) || $password === '') {
      $_SESSION['flash'] = 'Datos inválidos. Verifique correo y contraseña.';
      header('Location: '.$redirect);
      exit;
  }

  $stmt = db()->prepare("UPDATE sesion SET usuario=?, password=? WHERE id_sesion=?");
  $stmt->bind_param('ssi', $usuario, $password, $id);

  if ($stmt->execute()) {
      $_SESSION['flash'] = 'Registro actualizado correctamente.';
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
