window.onload = function () {
    menutoggle();
    openForm();
    closeForm();
    mensaje();
    buscarGuias();
}

function menutoggle() {

    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');

    menu.onclick = () => {
        sidenavbar.classList.toggle('active');
        content.classList.toggle('active');
    }
}

function task_del(id) {

    fetch('php/deltask.php', {
        method: 'POST',
        body: JSON.stringify({
            id: id
        }), // Puedes enviar datos en el cuerpo de la solicitud
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(data => {
            if (data.success = true) {
                location.reload();
            } else {
                console.error("Error al actualizar el registro");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });


}

function generaResponsiva() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
    <form class="formulario nueva-tarea" action="includes/templates/responsivas/formatoresponsiva.php" method="POST">
        <legend>Generar Responsiva</legend>
        <div class="campo">
            <label for="tag">TAG DEL EQUIPO:</label>
            <input type="text" id="tag" name="tag" placeholder="Ejem. CELCUL188" value="" />
        </div>
        <div class="opciones">
            <input type="submit" placeholder="Enviar" />
            <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
        </div>
    </form>
    `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);
}

function subirResponsiva() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class="formulario nueva-tarea" action="/mv2/includes/functions/subirResponsiva.php" method="POST" enctype="multipart/form-data">
        
    <fieldset class="formulario-field">
        <legend>NUEVO SEGUIMIENTO</legend>
       
       
        <div class="campo">
            <label for="tag">Tag:</label>
            <input type="text" id="tag" name="tag" placeholder="Tag del Equipo" value="">
        </div>
        <div class="campo">
            <label for="oficina">Oficina:</label>
            <input type="text" id="oficina" name="oficina" placeholder="oficina" value="">
        </div>
        <div class="campo">
            <label for="devuser">DevUser:</label>
            <input type="text" id="devuser" name="devuser" placeholder="devuser asignado" value="">
        </div>

        <div class="campo">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="">
        </div>
        <div class="campo">
        <label for="celular">Estado:</label>
        <select id="estatus" name="estatus">
        <option value="entregado"  name="estatus">Entregado</option>
        <option value="entregado"  name="estatus">Enviado</option>
        </select>
        </div>
        <div class="campo">
        <label for="usersis">Quien atendio:</label>
        <input type="text" id="usersis" name="usersis" value="usuario">
    </fieldset>
    <fieldset class="formulario-field">
        <legend>Selecciona archivo</legend>
        <input type="file" id="file" name="ARCHIVO" accept="application/pdf, *.pdf" class="upload-menu" />
       
    </fieldset>
    <input type="submit" name="submit" placeholder="Enviar">
    <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
        </form>
    `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);


}

function abrirResponsiva(TAG) {
    pdfUrl = "/mv2/responsivas/" + TAG;
    window.open(pdfUrl, TAG, "height=700,width=500,modal=yes,alwaysRaised=yes");
}

function abrirResponsivaEquipo(TAG) {
    pdfUrl = "/mv2/responsivas/EQUIPOS/" + TAG;
    window.open(pdfUrl, TAG, "height=700,width=500,modal=yes,alwaysRaised=yes");
}


function subirResponsivaEquipo() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class="formulario nueva-tarea" action="/mv2/includes/functions/subirResponsivaEquipo.php" method="POST" enctype="multipart/form-data">
        
    <fieldset class="formulario-field">
        <legend>Registrar Equipo</legend>
       
       
        <div class="campo">
            <label for="devicename">Nombre Equipo:</label>
            <input type="text" id="devicename" name="devicename" placeholder="Tag del Equipo en OCS" value="" onblur='buscaOCS()'>
        </div>
        <div class="campo">
        <label for="oficina">Oficina:</label>
        <input type="text" id="oficina" name="oficina" placeholder="oficina" value="">
    </div>
        <div class="campo">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" placeholder="si no es ocs poner Rack" value="">
    </div>
        <div class="campo">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" placeholder="ej: NVR" value="">
        </div>
        <div class="campo">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" placeholder="marca del equipo" value="">
        </div>
        <div class="campo">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" placeholder="modelo del equipo" value="">
        </div>
        <div class="campo">
        <label for="serie">Serie:</label>
        <input type="text" id="serie" name="serie" placeholder="serie del equipo" value="">
    </div>

        <div class="campo">
        <label for="fecha">Fecha Garantía:</label>
        <input type="date" id="fecha" name="fecha" value="">
        </div>
        <div class="campo">
        <label for="celular">Estado:</label>
        <select id="estatus" name="estatus">
        <option value="Activo"  name="estatus">Activo</option>
        <option value="Baja"  name="estatus">Baja</option>
        </select>
        </div>

    </fieldset>
    <fieldset class="formulario-field">
        <legend>Agregar Factura</legend>
        <input type="file" id="file" name="Factura" accept="application/pdf, *.pdf" class="upload-menu" />
       
    </fieldset>
    <fieldset class="formulario-field">
    <legend>Agregar Responsiva</legend>
    <input type="file" id="file" name="Responsiva" accept="application/pdf, *.pdf" class="upload-menu" />
   
    </fieldset>
    <input type="submit" name="submit" placeholder="Enviar">
    <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
        </form>
    `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);

}

function buscaOCS() {
    const devicename = document.getElementById('devicename').value;

    const tipo = document.getElementById('tipo');
    const marca = document.getElementById('marca');
    const modelo = document.getElementById('modelo');
    const serie = document.getElementById('serie');

    $.ajax({
        type: "POST",
        url: 'includes/functions/buscaOCS.php',
        data: { device: devicename },
        dataType: "json",
        success: function (data) {
            if (data.result === '404') {

                alert("El nombre de equipo no fue encontrado");


            } else {

                tipo.value = data.type;
                marca.value = data.smanufacturer;
                modelo.value = data.smodel;
                serie.value = data.ssn;

            }
        },
        error: function () {
            alert("Hubo un error al realizar la solicitud AJAX");
        }
    });
}

function editarLDAP(tag) {
    const fila = document.getElementById(tag);
    // Obtener los datos de la fila seleccionada
    const usuario = fila.querySelector('td:nth-child(3)').innerText;

    const marca = fila.querySelector('td:nth-child(5)').innerText;
    const modelo = fila.querySelector('td:nth-child(6)').innerText;
    const imei = fila.querySelector('td:nth-child(7)').innerText;
    const serie = fila.querySelector('td:nth-child(8)').innerText;
    const telefono = fila.querySelector('td:nth-child(9)').innerText;

    // Obtener referencias a los elementos del formulario


    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
            
                <form class="formulario form-movil" action="" method="POST">
                <fieldset class="formulario-field" >
                <legend>Editar Tefono Movil</legend>
                <div class="campo">
                    <label>Tag:</label>
                    <input type="text" name="devicetag" value="" /><br/>
                </div>
                <div class="campo">
                    <label>DevUser:</label>
                    <input type="text" name="deviceassignedto"  value="" /><br/>
                </div>
                <div class="campo">
                    <label>Marca:</label>
                    <input type="text" name="devicebrand"  value="" /><br/>
                </div>
                <div class="campo">
                    <label>Modelo:</label>
                    <input type="text" name="devicemodel"  value="" /><br/>
                </div>
                <div class="campo">
                    <label>IMEI:</label>
                    <input type="text" name="deviceimei"  value="" /><br/>
                </div>
                <div class="campo">
                    <label>Serie:</label>
                    <input type="text" name="deviceserial"  value="" /><br/>
                </div>
                <div class="campo">
                    <label>Numero:</label>
                    <input type="text" name="devicenumber" value="" /><br/>
                    <input type="hidden" name="editar" value="1" />
                </div>
                </fieldset>
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value=" editar " 
                    />
                    <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
                </div>
                </form>
            `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);
    const devicetagInput = document.querySelector('input[name=devicetag]');
    const deviceassignedtoInput = document.querySelector('input[name=deviceassignedto]');
    const devicebrandInput = document.querySelector('input[name=devicebrand]');
    const devicemodelInput = document.querySelector('input[name=devicemodel]');
    const deviceimeiInput = document.querySelector('input[name=deviceimei]');
    const deviceserialInput = document.querySelector('input[name=deviceserial]');
    const devicenumberInput = document.querySelector('input[name=devicenumber]');

    // Llenar el formulario con los datos de la fila seleccionada
    devicetagInput.value = tag;
    deviceassignedtoInput.value = usuario;
    devicebrandInput.value = marca;
    devicemodelInput.value = modelo;
    deviceimeiInput.value = imei;
    deviceserialInput.value = serie;
    devicenumberInput.value = telefono;
}


function doSearch() {
    const tableReg = document.getElementById('tabla');
    const searchText = document.getElementById('searchTerm').value;
    let found = false;
    let total = 0;

    // Recorremos todas las filas con contenido de la tabla
    for (let i = 1; i < tableReg.rows.length; i++) {
        found = false; // Reset found for each row

        const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');

        // Recorremos todas las celdas
        for (let j = 0; j < cellsOfRow.length && !found; j++) {
            const compareWith = cellsOfRow[j].innerHTML.toLowerCase();

            // Buscamos el texto en el contenido de la celda
            if (searchText.length == 0 || compareWith.indexOf(searchText.toLowerCase()) > -1) {
                found = true;
                total++;
            }
        }

        if (found) {
            tableReg.rows[i].style.display = '';
        } else {
            // Si no ha encontrado ninguna coincidencia, esconde la fila de la tabla
            tableReg.rows[i].style.display = 'none';
        }
    }

}


function busquedaPorOfficina() {

    var select = document.getElementById('officinas');
    var optionSelect = select.options[select.selectedIndex]; //obtenemos las opciones que hay dentro del select

    var tabla = document.getElementById('tabla'); //Obtenemos la tabla
    var Pbusqueda = optionSelect.value; //obtenemos el value que esta en las obciones de la tabla
    //Se ase un recorrido a la tabla
    for (var i = 1; i < tabla.rows.length; i++) {
        var cellsOfRow = tabla.rows[i].getElementsByTagName('td') //obtiene todos los objetos'td' de la tabla y los guarda en un array
        var found = false; //puntero

        for (var j = 0; j < cellsOfRow.length && !found; j++) {

            //si encuentra coincidencia
            if (cellsOfRow[j].innerHTML === Pbusqueda) {
                found = true;

            } //si la opcion esta vacia en la busqueda found es true para que muestre todo el recorrdio
            else if (Pbusqueda == "") {
                found = true;
            }
        }
        if (found) {
            tabla.rows[i].style.display = '';
        } else {
            tabla.rows[i].style.display = 'none';

        }
    }
}


function cerrarModal() {
    // Elimina el modal del DOM para ocultarlo
    const modal = document.querySelector('.modal');
    if (modal) {
        modal.remove();
    }
}


function buscarEmpleado() {
    var usuario = document.getElementById("dunumeroempleado").value;

    $.ajax({
        type: "POST",
        url: 'includes/functions/NewDevuser.php',
        data: { devuser: usuario },
        dataType: "json",
        success: function (data) {
            if (data.error) {
                alert(data.mensaje);
                botonAgregar.disabled = true;
                newuser.style.display = "block";
                botonAgregar.disabled = false;
            } else {
                var devuserData = data;  // Acceder a todos los datos
                var usernname = devuserData.duusernname;
                var nombre = devuserData.dunombre;
                document.getElementById("dunombre").value = nombre;



                // Ahora puedes usar estas variables según sea necesario
                console.log("Número de empleado: " + numeroEmpleado);
                console.log("Oficina: " + oficina);
                console.log("Usernname: " + usernname);
                console.log("Nombre: " + nombre);
            }
        },
        error: function () {
            alert("Hubo un error al realizar la solicitud AJAX");
        }
    });
}

function salida() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class="formulario nueva-tarea" action="" method="POST">
        <legend>Salida de articulo</legend>
        <div class="campo">            
            <label for="article">Articulo:</label>
            <select id="article" name="article" class="ofi input-busc">
                <option value="1">Celular ZTE A51</option>
                <option value="2">Celular Samsung A03 32gb</option>
                <option value="3">Celular Samsung A03 64gb</option>
                <option value="4">Celular Samsung A04</option>
                <option value="5">Vidrio Templado A03</option>
                <option value="6">Protector A03</option>
            </select>
  
 
        </div>
        <div class="campo">
        <label for="cantidad">Cantidad:</label>
        <input type="text" id="cantidad" name="cantidad" placeholder="">
        </div>
        <input type="hidden" name="accion" value="salida" />
        <div class="opciones">
        <input 
        type="submit" 
        placeholder="Dar Salida">
            <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
        </div>
        </form>
    `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);
}

function entrada() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class="formulario nueva-tarea" action="" method="POST">
        <legend>Entrada Articulo</legend>
        <div class="campo">            
            <label for="article">Articulo:</label>
            <select id="article" name="article" class="ofi input-busc">
                <option value="1">Celular ZTE A51</option>
                <option value="2">Celular Samsung A03 32gb</option>
                <option value="3">Celular Samsung A03 64gb</option>
                <option value="4">Celular Samsung A04</option>
                <option value="5">Vidrio Templado A03</option>
                <option value="6">Protector A03</option>
            </select>
  
 
        </div>
        <div class="campo">
        <label for="cantidad">Cantidad:</label>
        <input type="text" id="cantidad" name="cantidad" placeholder="">
        </div>
        <input type="hidden" name="accion" value="entrada" />
        <div class="opciones">
        <input 
        type="submit" 
        placeholder="Dar Salida">
            <button type="button" class="cerrar-modal" onclick="cerrarModal()">Cancelar</button>
        </div>
        </form>
    `;
    layout = document.querySelector('#layout');
    layout.appendChild(modal);


}

function toggleSubmenu(menu) {
    // Selecciona el enlace de Inventario y su submenú
    var menuLink = document.getElementById(menu);

    var submenu = menuLink.nextElementSibling;
    console.log(submenu);
    // Agrega un evento de clic al enlace de Inventario

    // Cambia la visibilidad del submenú al hacer clic
    submenu.style.display = (submenu.style.display === "none" || submenu.style.display === "") ? "block" : "none";

}

function openForm() {
    const btnForm = document.querySelector('#guia');
    const formulario = document.querySelector('#formGuia');

    if (btnForm && formulario) {
        btnForm.addEventListener('click', () => {
            formulario.classList.toggle('ocultar');
        });
    }
}


function closeForm() {
    const iconoClose = document.querySelector('#close');

    if (iconoClose) {
        iconoClose.addEventListener('click', () => {
            const formulario = document.querySelector('#formGuia');
            if (formulario) {
                formulario.classList.toggle('ocultar');
            }
        });
    }
}

function mensaje() {
    const divMensaje = document.querySelector('#mensaje');

    if (divMensaje !== null) {
        setTimeout(() => {
            divMensaje.remove();
        }, 3000);
    }
}

function buscarGuias() {
    const buscarInput = document.getElementById('search');
    const tablaDatos = document.getElementById('tablaDatos');

    buscarInput.addEventListener('input', function () {
        const valor = this.value.toLowerCase();
        const filas = tablaDatos.querySelectorAll('.tabla__contenido tr');

        filas.forEach(function (fila) {
            const contenidoFila = fila.textContent.toLowerCase();
            if (contenidoFila.includes(valor)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

}