<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Actualizar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $status = $_POST['status'];
    
    if (!empty($title)) {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $status, $id]);
        header("Location: index.php");
        exit();
    }
}

// Obtener tarea
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Tarea</h1>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Título de la tarea
                    </label>
                    <input type="text" name="title" id="title" value="<?= htmlspecialchars($task['title']) ?>" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Estado
                    </label>
                    <select name="status" id="status" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="pendiente" <?= $task['status'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="completada" <?= $task['status'] === 'completada' ? 'selected' : '' ?>>Completada</option>
                    </select>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" 
                        class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                        Guardar cambios
                    </button>
                    <a href="index.php" 
                        class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
