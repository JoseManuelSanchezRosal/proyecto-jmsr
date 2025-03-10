<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD catalogo</title>
    <link rel="stylesheet" href="estilos-crud.css"> <!-- Enlazar archivo CSS -->
</head>

<?php

$host = "localhost";  
$dbname = "bbdd_catalogo_jmsr"; // ⚠️ Asegúrate de que este es el nombre correcto en MySQL
$username = "root";  
$password = "";  

try {
    // Crear la conexión con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexión establecida";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}





// Obtener todos los productos
$productos = $pdo->query("SELECT p.id_producto, p.nombre_producto, p.descripcion_producto, p.cantidad_producto, f.nombre_fabricante, c.nombre_categoria FROM productos p JOIN fabricantes f ON p.id_fabricante = f.id_fabricante JOIN categorias c ON p.id_categoria = c.id_categoria")->fetchAll(PDO::FETCH_ASSOC);

// Obtener fabricantes y categorías para los formularios
$fabricantes = $pdo->query("SELECT * FROM fabricantes")->fetchAll(PDO::FETCH_ASSOC);
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);

// Agregar un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $nombre = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion_producto'];
    $cantidad = $_POST['cantidad_producto'];
    $id_fabricante = $_POST['id_fabricante'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "INSERT INTO productos (nombre_producto, descripcion_producto, cantidad_producto, id_fabricante, id_categoria)
            VALUES (:nombre, :descripcion, :cantidad, :id_fabricante, :id_categoria)";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion, 'cantidad' => $cantidad, 'id_fabricante' => $id_fabricante, 'id_categoria' => $id_categoria])) {
        echo "Producto agregado correctamente.";
        header("Location: index.php");
    } else {
        echo "Error al agregar el producto.";
    }
}

// Editar un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion_producto'];
    $cantidad = $_POST['cantidad_producto'];
    $id_fabricante = $_POST['id_fabricante'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "UPDATE productos SET nombre_producto = :nombre, descripcion_producto = :descripcion, cantidad_producto = :cantidad, id_fabricante = :id_fabricante, id_categoria = :id_categoria WHERE id_producto = :id_producto";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion, 'cantidad' => $cantidad, 'id_fabricante' => $id_fabricante, 'id_categoria' => $id_categoria, 'id_producto' => $id_producto])) {
        echo "Producto editado correctamente.";
        header("Location: index.php");
    } else {
        echo "Error al editar el producto.";
    }
}

// Eliminar un producto
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $id_producto = $_GET['id_producto'];
    
    $sql = "DELETE FROM productos WHERE id_producto = :id_producto";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['id_producto' => $id_producto])) {
        echo "Producto eliminado correctamente.";
        header("Location: index.php");
    } else {
        echo "Error al eliminar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
</head>
<body>

<h1>Lista de Productos</h1>

<table border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Fabricante</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto['nombre_producto'] ?></td>
            <td><?= $producto['descripcion_producto'] ?></td>
            <td><?= $producto['cantidad_producto'] ?></td>
            <td><?= $producto['nombre_fabricante'] ?></td>
            <td><?= $producto['nombre_categoria'] ?></td>
            <td>
                <a href="index.php?accion=editar&id_producto=<?= $producto['id_producto'] ?>">Editar</a>
                <a href="index.php?accion=eliminar&id_producto=<?= $producto['id_producto'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Agregar Producto</h2>
<form method="POST">
    <input type="hidden" name="accion" value="agregar">
    Nombre: <input type="text" name="nombre_producto" required><br>
    Descripción: <textarea name="descripcion_producto" required></textarea><br>
    Cantidad: <input type="number" name="cantidad_producto" required><br>
    Fabricante:
    <select name="id_fabricante">
        <?php foreach ($fabricantes as $fab): ?>
            <option value="<?= $fab['id_fabricante'] ?>"><?= $fab['nombre_fabricante'] ?></option>
        <?php endforeach; ?>
    </select><br>
    Categoría:
    <select name="id_categoria">
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nombre_categoria'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Guardar</button>
</form>

<?php
// Editar un producto
if (isset($_GET['accion']) && $_GET['accion'] == 'editar' && isset($_GET['id_producto'])):
    $id_producto = $_GET['id_producto'];
    $producto = $pdo->prepare("SELECT * FROM productos WHERE id_producto = :id_producto");
    $producto->execute(['id_producto' => $id_producto]);
    $producto = $producto->fetch(PDO::FETCH_ASSOC);
?>

<h2>Editar Producto</h2>
<form method="POST">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">
    Nombre: <input type="text" name="nombre_producto" value="<?= $producto['nombre_producto'] ?>" required><br>
    Descripción: <textarea name="descripcion_producto" required><?= $producto['descripcion_producto'] ?></textarea><br>
    Cantidad: <input type="number" name="cantidad_producto" value="<?= $producto['cantidad_producto'] ?>" required><br>
    Fabricante:
    <select name="id_fabricante">
        <?php foreach ($fabricantes as $fab): ?>
            <option value="<?= $fab['id_fabricante'] ?>" <?= $fab['id_fabricante'] == $producto['id_fabricante'] ? 'selected' : '' ?>><?= $fab['nombre_fabricante'] ?></option>
        <?php endforeach; ?>
    </select><br>
    Categoría:
    <select name="id_categoria">
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $producto['id_categoria'] ? 'selected' : '' ?>><?= $cat['nombre_categoria'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Actualizar</button>
</form>

<?php endif; ?>

</body>
</html>
