<div class="table-responsive mt-3">
    <table class="table table-hover" id="table_peliculas">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Director</th>
                <th>Género</th>
                <th>Año</th>
                <th>Duración</th>
                <th>Clasificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peliculas as $pelicula): ?>
                <tr id="pelicula_<?php echo $pelicula['id']; ?>">
                    <td><?php echo $pelicula['id']; ?></td>
                    <td><?php echo htmlspecialchars($pelicula['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($pelicula['director']); ?></td>
                    <td><?php echo htmlspecialchars($pelicula['genero']); ?></td>
                    <td><?php echo $pelicula['anio_estreno']; ?></td>
                    <td><?php echo $pelicula['duracion_min']; ?> min</td>
                    <td><?php echo $pelicula['clasificacion']; ?></td>
                    <td>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>