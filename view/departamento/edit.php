<section class="panel">
    <h2>Editar departamento</h2>

    <form method="post" class="form">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" value="<?= htmlspecialchars($departamento['nombre']) ?>" required>

        <div class="actions">
            <button class="btn" type="submit">Actualizar</button>
            <a href="?controller=departamento&action=index">Cancelar</a>
        </div>
    </form>
</section>
