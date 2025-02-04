// Seleccionar todos los enlaces de "Agregar al carrito"
const botonesAgregarCarrito = document.querySelectorAll('.btnAddCarrito');

// Añadir el evento a cada enlace
botonesAgregarCarrito.forEach(boton => {
    boton.addEventListener('click', function(event) {
        event.preventDefault();  // Evitar la redirección del enlace
        agregarAlCarrito(event);
    });
});

// Función para agregar productos al carrito
function agregarAlCarrito(event) {
    const boton = event.target.closest('a');  // Obtener el enlace donde se hizo clic
    const id = boton.getAttribute('data-id');
    const titulo = boton.getAttribute('data-titulo');
    const precio = boton.getAttribute('data-precio');

    const producto = {
        id: id,
        titulo: titulo,
        precio: parseFloat(precio),
        cantidad: 1
    };

    // Verificar si el carrito ya tiene el producto
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    const existeProducto = carrito.some(item => item.id === producto.id);
    if (existeProducto) {
        carrito = carrito.map(item => {
            if (item.id === producto.id) {
                item.cantidad++;
            }
            return item;
        });
        Swal.fire({
            title: "Aviso",
            text: "La cantidad aumento",
            icon: "success"
        });
    } else {
        carrito.push(producto);
        Swal.fire({
            title: "Aviso",
            text: "Producto agregado al carrito con éxito",
            icon: "success"
        });
    }

    // Guardar en Session Storage
    sessionStorage.setItem('carrito', JSON.stringify(carrito));

    enviarCarritoAlServidor();
    mostrarCarrito();
}

// Función para vaciar el carrito
function vaciarCarrito() {
    sessionStorage.removeItem('carrito'); // Eliminar el carrito de sessionStorage
    Swal.fire({
        title: "Carrito vaciado",
        text: "El carrito ha sido vaciado",
        icon: "success"
    });

    enviarCarritoAlServidor(); // Notificar al servidor que el carrito está vacío
    mostrarCarrito(); // Actualizar la vista del carrito
}

// Función para eliminar un producto individual
function eliminarProducto(id) {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    carrito = carrito.filter(producto => producto.id !== id); // Eliminar producto por ID

    sessionStorage.setItem('carrito', JSON.stringify(carrito)); // Guardar el carrito actualizado
    
    // Eliminar visualmente el producto del DOM
    const productoElemento = document.querySelector(`.productoCarrito[data-id="${id}"]`);
    if (productoElemento) {
        productoElemento.remove(); // Eliminar el elemento del DOM
    }

    Swal.fire({
        title: "Producto eliminado",
        text: "El producto ha sido eliminado del carrito",
        icon: "success"
    });

    enviarCarritoAlServidor(); // Notificar al servidor que el carrito se actualizó
    mostrarCarrito(); // Actualizar la vista del carrito
}

// Función para enviar el carrito actualizado al servidor
function enviarCarritoAlServidor() {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    console.log('Carrito que se envía al servidor:', carrito);

    fetch('/tienda/recibirCarrito', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ carrito: carrito })
    })
    .then(response => {
        return response.text(); // Cambia a .text() para ver la respuesta cruda
    })
    .then(data => {
        console.log('Respuesta del servidor:', data); // Imprime la respuesta cruda
        try {
            const jsonResponse = JSON.parse(data); // Intenta analizar la respuesta como JSON
            console.log('Respuesta JSON:', jsonResponse);
        } catch (error) {
            console.error('Error al analizar la respuesta JSON:', error);
        }
    })
    .catch(error => console.error('Error al enviar el carrito:', error));
}

// Función para mostrar el carrito actualizado (puedes personalizar esta función)
function mostrarCarrito() {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    
    // Selecciona el contenedor donde muestras los productos del carrito
    const carritoContainer = document.getElementById('carritoContainer');
    
    // Limpia el contenido anterior del carrito
    carritoContainer.innerHTML = '';
    
    // Si el carrito está vacío, muestra un mensaje
    if (carrito.length === 0) {
        carritoContainer.innerHTML = '<p>El carrito está vacío</p>';
    } else {
        carrito.forEach(producto => {
            const productoElemento = `
                <div class="productoCarrito">
                    <span>${producto.titulo} - $${producto.precio} x ${producto.cantidad}</span>
                    <button class="btnEliminarProducto" data-id="${producto.id}">Eliminar</button>
                </div>`;
            carritoContainer.innerHTML += productoElemento;
        });
    }

    // Recargar los eventos de los botones después de actualizar el carrito
    recargarEventosBotones();
}

// Agregar evento al botón de vaciar carrito
document.getElementById('vaciarCarrito').addEventListener('click', function(event) {
    event.preventDefault();
    vaciarCarrito();
});

// Función para recargar eventos de los botones al eliminar productos
function recargarEventosBotones() {
    document.querySelectorAll('.btnEliminarProducto').forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault();
            const id = boton.getAttribute('data-id');
            eliminarProducto(id);
        });
    });
}

// Llamar a recargarEventosBotones cuando la página se carga
recargarEventosBotones();