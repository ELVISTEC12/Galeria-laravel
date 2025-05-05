<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Galería de Fotos y Videos</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Galería de Fotos y Videos</h1>

  <form action="subir.php" method="POST" enctype="multipart/form-data">
    <label for="archivo">Importar archivo:</label>
    <input type="file" name="archivo" id="archivo" accept="image/*,video/*" required>
    <button type="submit">Importar</button>
  </form>

  <div class="tabs">
  <button class="tab-button active" onclick="mostrarTab('fotos')">📷 Fotos</button>
  <button class="tab-button" onclick="mostrarTab('videos')">🎥 Videos</button>
</div>

<div class="tab-content" id="fotos">
  <section class="gallery">
    <?php
    $imagenes = glob("assets/imagenes/*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    foreach ($imagenes as $img) {
        echo "<img src='$img' alt='Imagen'>";
    }
    ?>
  </section>
</div>

<div class="tab-content" id="videos" style="display: none;">
  <section class="gallery">
    <?php
    $videos = glob("assets/videos/*.{mp4,webm,ogg}", GLOB_BRACE);
    foreach ($videos as $vid) {
        echo "<video src='$vid' controls></video>";
    }
    ?>
  </section>
</div>

<div id="lightbox" class="lightbox hidden">
  <div class="lightbox-content">
    <span class="close" onclick="cerrarLightbox()">&times;</span>
    <div id="media-container"></div>
    <div id="filename" class="filename"></div> <!-- Aquí se mostrará el nombre del archivo -->
    <div class="lightbox-buttons">
      <button onclick="renombrarArchivo()">📝 Renombrar</button>
      <button onclick="eliminarArchivo()">🗑️ Eliminar</button>
    </div>
  </div>
</div>


<script>
function mostrarTab(id) {
  document.getElementById('fotos').style.display = id === 'fotos' ? 'block' : 'none';
  document.getElementById('videos').style.display = id === 'videos' ? 'block' : 'none';

  document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
  if (id === 'fotos') {
    document.querySelector('.tab-button:nth-child(1)').classList.add('active');
  } else {
    document.querySelector('.tab-button:nth-child(2)').classList.add('active');
  }
}

let archivoActual = '';

document.querySelectorAll('.gallery img, .gallery video').forEach(media => {
  media.addEventListener('click', () => {
    const src = media.getAttribute('src');
    archivoActual = src;

    const container = document.getElementById('media-container');
    const filename = document.getElementById('filename');
    const nombreArchivo = src.split('/').pop();  // Extrae solo el nombre del archivo

    // Muestra el nombre del archivo
    filename.textContent = nombreArchivo;

    container.innerHTML = media.tagName === 'IMG'
      ? `<img src="${src}" alt="Imagen">`
      : `<video src="${src}" controls autoplay></video>`;

    document.getElementById('lightbox').classList.remove('hidden');
  });
});

function cerrarLightbox() {
  document.getElementById('lightbox').classList.add('hidden');
}

function renombrarArchivo() {
  const nuevoNombre = prompt('Nuevo nombre del archivo (con extensión):');
  if (nuevoNombre) {
    window.location.href = `acciones.php?accion=renombrar&archivo=${encodeURIComponent(archivoActual)}&nuevo=${encodeURIComponent(nuevoNombre)}`;
  }
}

function eliminarArchivo() {
  if (confirm('¿Estás seguro de que quieres eliminar este archivo?')) {
    window.location.href = `acciones.php?accion=eliminar&archivo=${encodeURIComponent(archivoActual)}`;
  }
}
</script>


</body>
</html>
