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
        //carrito.push(producto);
        Swal.fire({
            title: "Aviso?",
            text: "Producto ya esta en el carrito",
            icon: "warning"
        });
    } else {
        carrito.push(producto);
        Swal.fire({
            title: "Aviso?",
            text: "Producto agregado al carrito con exito",
            icon: "success"
        });
    }

    // Guardar en Session Storage
    sessionStorage.setItem('carrito', JSON.stringify(carrito));

    enviarCarritoAlServidor();

    // Mostrar carrito actualizado (puedes tener una función mostrarCarrito() para esto)
    console.log(carrito);
}


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