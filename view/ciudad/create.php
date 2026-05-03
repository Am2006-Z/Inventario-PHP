<section class="panel">
    <h2>Nueva ciudad</h2>

    <form method="post" class="form">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required>

        <label for="departamento_id">Departamento</label>
        <select id="departamento_id" name="departamento_id" required>
            <option value="">Seleccione uno</option>
            <?php foreach ($departamentos as $departamento): ?>
                <option value="<?= (int) $departamento['id'] ?>"><?= htmlspecialchars($departamento['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <div class="actions">
            <button class="btn" type="submit">Guardar</button>
            <a href="?controller=ciudad&action=index">Cancelar</a>
        </div>
    </form>
</section>
