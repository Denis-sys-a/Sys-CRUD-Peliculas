<?php if (isset($peliculaEditar['id'])): ?>
    <a href="./" class="float-end"><i class="bi bi-arrow-clockwise"></i> limpiar</a>
<?php endif; ?>

<form action="<?php echo isset($peliculaEditar['id']) ? 'acciones/actualizarPelicula.php' : 'acciones/acciones.php'; ?>" method="POST">
    <?php if (isset($peliculaEditar['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $peliculaEditar['id']; ?>" />
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required value="<?php echo $peliculaEditar['titulo'] ?? ''; ?>" />
    </div>
    <div class="mb-3">
        <label class="form-label">Director</label>
        <input type="text" name="director" class="form-control" required value="<?php echo $peliculaEditar['director'] ?? ''; ?>" />
    </div>
    <div class="mb-3">
        <label class="form-label">Género</label>
        <input type="text" name="genero" class="form-control" required value="<?php echo $peliculaEditar['genero'] ?? ''; ?>" />
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Año de estreno</label>
            <input type="number" name="anio_estreno" class="form-control" min="1900" max="2100" required value="<?php echo $peliculaEditar['anio_estreno'] ?? ''; ?>" />
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Duración (min)</label>
            <input type="number" name="duracion_min" class="form-control" min="1" required value="<?php echo $peliculaEditar['duracion_min'] ?? ''; ?>" />
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Clasificación</label>
        <?php $clasificacionActual = $peliculaEditar['clasificacion'] ?? ''; ?>
        <select name="clasificacion" class="form-select" required>
            <option value="">Seleccione</option>
            <?php foreach (['G', 'PG', 'PG-13', 'R', 'NC-17'] as $clasificacion): ?>
                <option value="<?php echo $clasificacion; ?>" <?php echo $clasificacionActual === $clasificacion ? 'selected' : ''; ?>>
                    <?php echo $clasificacion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Sinopsis</label>
        <textarea name="sinopsis" class="form-control" rows="3" required><?php echo $peliculaEditar['sinopsis'] ?? ''; ?></textarea>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            <?php echo isset($peliculaEditar['id']) ? 'Actualizar película' : 'Guardar película'; ?>
        </button>
    </div>
</form>