<?php
require_once 'config.php';

// Obtener todas las tareas
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll();

// Agregar nueva tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = trim($_POST['title']);
    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, status) VALUES (?, 'pendiente')");
        $stmt->execute([$title]);
        header("Location: index.php");
        exit();
    }
}

// Eliminar tarea
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Cambiar estado
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = CASE WHEN status = 'completada' THEN 'pendiente' ELSE 'completada' END WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Gestor de Tareas</h1>
        
        <!-- Formulario para agregar tarea -->
        <form method="POST" class="mb-8">
            <div class="flex gap-2">
                <input type="text" name="title" placeholder="Nueva tarea..." required
                    class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" name="add" 
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </form>

        <!-- Lista de tareas -->
        <div class="space-y-4">
            <?php foreach ($tasks as $task): ?>
                <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <a href="?toggle=<?= $task['id'] ?>" class="text-lg">
                            <?php if ($task['status'] === 'completada'): ?>
                                <i class="fas fa-check-circle text-green-500"></i>
                            <?php else: ?>
                                <i class="far fa-circle text-gray-400"></i>
                            <?php endif; ?>
                        </a>
                        <span class="<?= $task['status'] === 'completada' ? 'line-through text-gray-500' : 'text-gray-800' ?>">
                            <?= htmlspecialchars($task['title']) ?>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <a href="edit.php?id=<?= $task['id'] ?>" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?delete=<?= $task['id'] ?>" class="text-red-500 hover:text-red-600" 
                           onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
