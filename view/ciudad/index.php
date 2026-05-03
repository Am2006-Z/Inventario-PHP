<section class="panel">
    <div class="panel-head">
        <h2>Ciudades</h2>
        <a class="btn" href="?controller=ciudad&action=create">Nueva</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($ciudades as $ciudad): ?>
            <tr>
                <td><?= (int) $ciudad['id'] ?></td>
                <td><?= htmlspecialchars($ciudad['nombre']) ?></td>
                <td><?= htmlspecialchars($ciudad['departamento_nombre']) ?></td>
                <td>
                    <a href="?controller=ciudad&action=edit&id=<?= (int) $ciudad['id'] ?>">Editar</a>
                    <a class="danger" href="?controller=ciudad&action=delete&id=<?= (int) $ciudad['id'] ?>" onclick="return confirm('Eliminar ciudad?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
