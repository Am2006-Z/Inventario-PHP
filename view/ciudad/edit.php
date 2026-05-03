<section class="panel">
    <h2>Editar ciudad</h2>

    <form method="post" class="form">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" value="<?= htmlspecialchars($ciudad['nombre']) ?>" required>

        <label for="departamento_id">Departamento</label>
        <select id="departamento_id" name="departamento_id" required>
            <?php foreach ($departamentos as $departamento): ?>
                <option value="<?= (int) $departamento['id'] ?>" <?= (int) $departamento['id'] === (int) $ciudad['departamento_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($departamento['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="actions">
            <button class="btn" type="submit">Actualizar</button>
            <a href="?controller=ciudad&action=index">Cancelar</a>
        </div>
    </form>
</section>
