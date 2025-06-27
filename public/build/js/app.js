const carrito = document.querySelector("#carrito");
const listaProductos = document.querySelector("#lista-productos");
const contenedorCarrito = document.querySelector("#lista-carrito");
const btnVaciarCarrito = document.querySelector("#vaciar-carrito");
const contenedorTotal = document.querySelector("#total");
let productosCarrito = [];

cargarEventos();

function cargarEventos() {
    listaProductos.addEventListener("click", agregarProducto);

    btnVaciarCarrito.addEventListener('click', eliminarTodo);
}

function agregarProducto(e) {
    e.preventDefault();

    if (e.target.classList.contains('btn-agregar')) {
        const producto = e.target.closest('.producto');

        leerDatosProducto(producto);
    }
}

function leerDatosProducto(producto) {
    const infoProducto = {
        img: producto.querySelector('img').src,
        nombre: producto.querySelector('h3').textContent,
        descripcion: producto.querySelector('.descripcion').textContent,
        precio: parseFloat(producto.querySelector('.precio').textContent.replace(/[^\d.]/g, '')),
        id: producto.querySelector('.btn-agregar').getAttribute('data-id'),
        subTotal: parseFloat(producto.querySelector('.precio').textContent.replace(/[^\d.]/g, '')),
        cantidad: 1
    }

    if (productosCarrito.some(producto => producto.id === infoProducto.id)) {
        const productos = productosCarrito.map(producto => {
            if (producto.id === infoProducto.id) {
                producto.cantidad++;
                producto.subTotal = parseFloat((producto.precio * producto.cantidad).toFixed(2));
                return producto;
            } else {
                return producto;
            }
        })

        productosCarrito = [...productos];

    } else {
        productosCarrito = [...productosCarrito, infoProducto];
    }

    //const total = productosCarrito.reduce((acum, producto) => acum + producto.subTotal, 0).toFixed(2);

    let total = 0;

    productosCarrito.forEach(p => {
        total += p.subTotal;
    });

    total = total.toFixed(2);

    carritoHtml(total);
}


function eliminarCurso(e) {
    e.preventDefault();
}

function carritoHtml(total) {

    vaciarCarrito();
    contenedorTotal.innerHTML = '';

    const boxTotal = document.createElement('div');

    productosCarrito.forEach(producto => {

        const fila = document.createElement('tr');

        fila.innerHTML = `
            <div class="prod-seleccion">
                <div class="prod-izquierda">
                    <img src="${producto.img}" alt="prod-seleccion" />

                    <div class="prod-izquierda-info">
                        <h3>${producto.nombre}</h3>
                        <p>${producto.precio}</p>

                        <div class="btn-contador">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <p>${producto.cantidad}</p>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="btn-eliminar-seleccionado">
                    <h3>${producto.subTotal}</h3>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        `;

        contenedorCarrito.appendChild(fila);
    });

    boxTotal.classList.add('total');
    boxTotal.innerHTML = `
        <p>
            Total
        </p>

        <p>${total}</p>
    `;

    contenedorTotal.appendChild(boxTotal);
}

function vaciarCarrito() {
    while (contenedorCarrito.firstChild) {
        contenedorCarrito.removeChild(contenedorCarrito.firstChild);
    }
}

function eliminarTodo() {
    vaciarCarrito();
    productosCarrito = [];
}
