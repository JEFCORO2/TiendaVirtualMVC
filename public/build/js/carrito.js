const carrito = document.querySelector('#producto');

carrito.addEventListener('click', agregarProducto);

function agregarProducto(evento) {
    evento.preventDefault();

    // Buscar el elemento más cercano con la clase 'btnAddCarrito' 
    const botonCarrito = evento.target.closest('.btnAddCarrito');

    if (botonCarrito) {
        //const cursoId = botonCarrito.getAttribute('data-id');
        const productoSeleccionado = evento.target.parentElement;

        console.log(productoSeleccionado);
    }
}