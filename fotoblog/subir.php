<?php
function mostrarRespuesta($mensaje, $exito = true) {
  $color = $exito ? '#4caf50' : '#f44336'; // Verde o rojo
  echo "
    <html>
    <head>
      <title>Resultado de la importación</title>
      <style>
        body {
          background-color: #000;
          color: #fff;
          font-family: 'Helvetica Neue', sans-serif;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          height: 100vh;
          margin: 0;
        }
        .respuesta {
          background-color: $color;
          padding: 20px 30px;
          border-radius: 12px;
          box-shadow: 0 0 15px rgba(0,0,0,0.4);
          text-align: center;
        }
        a {
          display: inline-block;
          margin-top: 20px;
          color: #fff;
          text-decoration: none;
          background-color: #222;
          padding: 10px 20px;
          border-radius: 10px;
          transition: background 0.3s ease;
        }
        a:hover {
          background-color: #444;
        }
      </style>
    </head>
    <body>
      <div class='respuesta'>
        <h2>$mensaje</h2>
        <a href='index.php'>Volver a la galería</a>
      </div>
    </body>
    </html>
  ";
}

// Lógica de carga
$archivo = $_FILES['archivo'];

if ($archivo['error'] === UPLOAD_ERR_OK) {
    $tipo = mime_content_type($archivo['tmp_name']);
    $nombre = basename($archivo['name']);

    if (str_starts_with($tipo, 'image/')) {
        $destino = "assets/imagenes/$nombre";
    } elseif (str_starts_with($tipo, 'video/')) {
        $destino = "assets/videos/$nombre";
    } else {
        mostrarRespuesta("❌ Tipo de archivo no permitido.", false);
        exit;
    }

    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
        mostrarRespuesta("✅ Archivo importado correctamente.");
    } else {
        mostrarRespuesta("❌ Error al mover el archivo.", false);
    }
} else {
    mostrarRespuesta("❌ Error al subir archivo.", false);
}
?>
