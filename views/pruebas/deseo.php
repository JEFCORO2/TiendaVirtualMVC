<?php
// Verificar si hay productos en el carrito
session_start();
$carrito = $_SESSION['carrito'] ?? [];

// Función para eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'eliminar' && isset($_POST['index'])) {
            // Elimina un producto del carrito por su índice
            array_splice($carrito, $_POST['index'], 1);
            $_SESSION['carrito'] = $carrito;
        }
        if ($_POST['accion'] === 'vaciar') {
            // Vaciar el carrito
            $carrito = [];
            $_SESSION['carrito'] = $carrito;
        }
    }
}

if (!empty($carrito)) {
    $totalCarrito = 0; // Variable para almacenar el total del carrito
?>
    <div class="container mt-4">
        <h3>Carrito de Compras</h3>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Subtotal</th> <!-- Columna para el subtotal -->
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $index => $producto): 
                    $subtotal = $producto['precio'] * $producto['cantidad']; // Calcular el subtotal del producto
                    $totalCarrito += $subtotal; // Sumar el subtotal al total del carrito
                ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= htmlspecialchars($producto['titulo']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td> <!-- Mostrar el subtotal -->
                        <td>
                            <!-- Botón para eliminar un producto individual -->
                            <button 
                                class="btn btn-danger btnEliminarProducto" 
                                data-id="<?= $producto['id'] ?>">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Mostrar el total del carrito -->
        <div class="mt-3">
            <h4>Total del Carrito: $<?= number_format($totalCarrito, 2) ?></h4>
        </div>

        <!-- Botón para vaciar el carrito -->
        <button id="vaciarCarrito" class="btn btn-warning">Vaciar Carrito</button>

        <div id="paypal-button-container"></div>
        <p id="result-message"></p>

        <script>
            paypal().Buttons().render('#paypal-button-container');
        </script>
    </div>
<?php
} else {
    echo '<p class="alert alert-info">No hay productos en el carrito.</p>';
}
?>