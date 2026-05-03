<section class="panel">
    <div class="panel-head">
        <h2>Departamentos</h2>
        <a class="btn" href="?controller=departamento&action=create">Nuevo</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($departamentos as $departamento): ?>
            <tr>
                <td><?= (int) $departamento['id'] ?></td>
                <td><?= htmlspecialchars($departamento['nombre']) ?></td>
                <td>
                    <a href="?controller=departamento&action=edit&id=<?= (int) $departamento['id'] ?>">Editar</a>
                    <a class="danger" href="?controller=departamento&action=delete&id=<?= (int) $departamento['id'] ?>" onclick="return confirm('Eliminar departamento?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
