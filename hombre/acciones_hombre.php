<?php
# aqui llamamos la sesion 
session_start();

require_once 'config.php';

#funcion para guardar la foto, con el formato permitido, la ubicación o directorio donde se guarda la foto
function guardarFoto($cod,$file){
  if(empty($file['name'])||$file['error']!==UPLOAD_ERR_OK) return null;
  #directorio o ubicacion de la foto
  $dir=__DIR__.'/img/fotos/';
  if(!is_dir($dir)) mkdir($dir,0775,true);
  $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
  #formato de la foto
  if(!in_array($ext,['jpg','jpeg','png','webp','gif'])) return null;

  // Generar sufijo único por cada imagen usando un hash del nombre temporal y microtime
  $unique = substr(md5($file['tmp_name'] . microtime(true)), 0, 8);
  $name='hom_'.intval($cod).'_'.$unique.'.'.$ext;
  $dest=$dir.$name;

  if(!is_uploaded_file($file['tmp_name'])) return null;
  # validación si no se modifica la foto se deja la misma sin problema
  if(!move_uploaded_file($file['tmp_name'],$dest)) return null;

  // Ruta relativa para guardar en la BD
  return 'img/fotos/'.$name;
}
# acciones para el registro nuevo de un hombre
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'registro_hombre.php';
# recibir información del formulario registro hombre
if ($accion==='crear') {
  $cod = intval($_POST['cod_hombre'] ?? 0);
  $ruta1 = guardarFoto($cod, $_FILES['img_hombre_1'] ?? []) ?: '';
  $ruta2 = guardarFoto($cod, $_FILES['img_hombre_2'] ?? []) ?: '';
  $ruta3 = guardarFoto($cod, $_FILES['img_hombre_3'] ?? []) ?: '';
  $ruta4 = guardarFoto($cod, $_FILES['img_hombre_4'] ?? []) ?: '';
  $nom = trim($_POST['nom_produc_hombre'] ?? '');
  $descripcion = trim($_POST['descripcion_hombre'] ?? '');
  $precio = trim($_POST['precio_hombre'] ?? '');  
  #  validación de que los campos cumpla con los requerimientos de javascript
  if ($cod<=0 || $nom==='' || $descripcion=== '' || $precio=== '') {
    $_SESSION['flash']='Datos inválidos.';
    header('Location: '.$redirect); exit;
  }
 #insertar a la tabla hombre
  try {
    // Verificar conexión antes de ejecutar la consulta
    $db = verificarConexion();
    $stmt = $db->prepare("INSERT INTO hombre (cod_hombre,img_hombre_1,img_hombre_2,img_hombre_3,img_hombre_4,nom_produc_hombre,descripcion_hombre,precio_hombre) VALUES (?,?,?,?,?,?,?,?)");
    
    if (!$stmt) {
      throw new Exception("Error al preparar la consulta: " . $db->error);
    }
    
    // cod:int, ruta1:str, ruta2:str, ruta3:str, ruta4:str, nom:str, descripcion:str, precio:str
    $stmt->bind_param('isssssss',$cod,$ruta1,$ruta2,$ruta3,$ruta4,$nom,$descripcion,$precio);
    
    if($stmt->execute()){
      #si todos los campos estan llenos se envia o registra la información
      $_SESSION['flash']='Registro completado correctamente.';
      header('Location: '.$redirect.'?ok=1'); exit;
    } else {
      throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Error en registro hombre: " . $e->getMessage());
    $_SESSION['flash']='Error al registrar: ' . $e->getMessage();
    header('Location: '.$redirect); exit;
  } finally {
    if (isset($stmt)) {
      $stmt->close();
    }
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
    try {
      $db = verificarConexion();
      $stmt = $db->prepare("DELETE FROM hombre WHERE id_hombre=?");
      if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $db->error);
      }
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $_SESSION['flash'] = 'Registro eliminado.';
      } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
      }
    } catch (Exception $e) {
      error_log("Error al eliminar hombre: " . $e->getMessage());
      $_SESSION['flash'] = 'Error al eliminar: ' . $e->getMessage();
    } finally {
      if (isset($stmt)) {
        $stmt->close();
      }
    }
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
  try {
    $db = verificarConexion();
    $stmt = $db->prepare("SELECT img_hombre_1, img_hombre_2, img_hombre_3, img_hombre_4 FROM hombre WHERE id_hombre=?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($fotos_actuales['img_hombre_1'], $fotos_actuales['img_hombre_2'], $fotos_actuales['img_hombre_3'], $fotos_actuales['img_hombre_4']);
        $stmt->fetch();
        $stmt->close();
    }
  } catch (Exception $e) {
    error_log("Error al obtener fotos actuales: " . $e->getMessage());
  }

  // Procesar nuevas fotos si se suben, mantener las actuales si no se suben nuevas
  $ruta1 = guardarFoto($cod, $_FILES['img_hombre_1'] ?? []) ?: $fotos_actuales['img_hombre_1'] ?? null;
  $ruta2 = guardarFoto($cod, $_FILES['img_hombre_2'] ?? []) ?: $fotos_actuales['img_hombre_2'] ?? null;
  $ruta3 = guardarFoto($cod, $_FILES['img_hombre_3'] ?? []) ?: $fotos_actuales['img_hombre_3'] ?? null;
  $ruta4 = guardarFoto($cod, $_FILES['img_hombre_4'] ?? []) ?: $fotos_actuales['img_hombre_4'] ?? null;

  // Actualizar en la tabla hombre
  try {
    $db = verificarConexion();
    $stmt = $db->prepare("UPDATE hombre SET cod_hombre=?, img_hombre_1=?, img_hombre_2=?, img_hombre_3=?, img_hombre_4=?, nom_produc_hombre=?, descripcion_hombre=?, precio_hombre=? WHERE id_hombre=?");
    
    if (!$stmt) {
      throw new Exception("Error al preparar la consulta: " . $db->error);
    }
    
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
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Error al actualizar hombre: " . $e->getMessage());
    $_SESSION['flash'] = 'Error al actualizar: ' . $e->getMessage();
    header('Location: '.$redirect);
    exit;
  } finally {
    if (isset($stmt)) {
      $stmt->close();
    }
  }
}

// Exportar todos los registros a Excel (CSV)
if ($accion === 'exportar') {
  try {
    $db = verificarConexion();
    $resultado = $db->query("SELECT id_hombre, cod_hombre, img_hombre_1, img_hombre_2, img_hombre_3, img_hombre_4, nom_produc_hombre, descripcion_hombre, precio_hombre, IFNULL(fecha_creacion, '') AS fecha_creacion FROM hombre ORDER BY id_hombre DESC");

    // Encabezados para forzar descarga como archivo de Excel compatible (CSV)
    $filename = 'hombre_'.date('Ymd_His').'.csv';
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // BOM para que Excel detecte UTF-8 correctamente
    echo "\xEF\xBB\xBF";

    $salida = fopen('php://output', 'w');

    // Encabezados de columnas (en español)
    fputcsv($salida, [
      'ID',
      'Código',
      'Imagen 1',
      'Imagen 2',
      'Imagen 3',
      'Imagen 4',
      'Nombre del producto',
      'Descripción',
      'Precio',
      'Fecha de creación'
    ]);

    if ($resultado && $resultado->num_rows) {
      while ($fila = $resultado->fetch_assoc()) {
        fputcsv($salida, [
          $fila['id_hombre'],
          $fila['cod_hombre'],
          $fila['img_hombre_1'],
          $fila['img_hombre_2'],
          $fila['img_hombre_3'],
          $fila['img_hombre_4'],
          $fila['nom_produc_hombre'],
          $fila['descripcion_hombre'],
          $fila['precio_hombre'],
          $fila['fecha_creacion']
        ]);
      }
    }

    fclose($salida);
    exit;
  } catch (Exception $e) {
    error_log('Error al exportar hombres: '.$e->getMessage());
    $_SESSION['flash'] = 'Error al exportar.';
    header('Location: '.$redirect);
    exit;
  }
}

// Si llega aquí sin coincidencia, redirigir al listado
header('Location: '.$redirect); exit;
