<?php
$accion = $_GET['accion'] ?? '';
$archivo = $_GET['archivo'] ?? '';
$nuevo = $_GET['nuevo'] ?? '';

$archivo = urldecode($archivo);
$nuevo = urldecode($nuevo);

function redirigir($msg) {
  header("Location: index.php?mensaje=" . urlencode($msg));
  exit;
}

if (!file_exists($archivo)) {
  redirigir("❌ Archivo no encontrado.");
}

switch ($accion) {
  case 'eliminar':
    if (unlink($archivo)) {
      redirigir("✅ Archivo eliminado.");
    } else {
      redirigir("❌ Error al eliminar.");
    }
    break;

    case 'renombrar':
        $directorio = dirname($archivo);
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        $nuevoNombre = pathinfo($nuevo, PATHINFO_FILENAME); // Solo nombre, sin extensión
    
        // Si el nuevo nombre no tiene extensión, se la agregamos
        if (pathinfo($nuevo, PATHINFO_EXTENSION) === '') {
            $nuevo .= '.' . $extension;
        }
    
        $nuevoPath = "$directorio/$nuevo";
        if (rename($archivo, $nuevoPath)) {
            redirigir("✅ Archivo renombrado a '$nuevo'.");
        } else {
            redirigir("❌ Error al renombrar.");
        }
        break;
    

  default:
    redirigir("⚠️ Acción no válida.");
}
