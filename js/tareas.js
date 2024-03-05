(function(){
        
        const NuevaTareaBtn = document.querySelector('#nuevaTarea');
        NuevaTareaBtn.addEventListener('click', mostrarFormulario);
        
        function mostrarFormulario() {
            const modal = document.createElement('DIV');
            modal.classList.add('modal');
            modal.innerHTML = `
                <form class="formulario nueva-tarea" method="POST">
                <legend>Añade una nueva tarea</legend>
                <div class="campo">
                    <label>Titulo</titulo>
                    <input type="text" name="titulo" /><br/>
                    <label>Tarea</label>
                    <textarea
                    name="tarea"
                    placeholder="Añadir Tarea al Proyecto Actual"
                    id="tarea"
                ></textarea>
                </div>
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value=" agregar pendiente " 
                    />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
                </form>
            `;
            layout = document.querySelector('#layout');
            layout.appendChild(modal);

        
            const cerrarModalBtn = modal.querySelector('.cerrar-modal');
            cerrarModalBtn.addEventListener('click', cerrarModal);
            
        }


        function cerrarModal() {
            // Elimina el modal del DOM para ocultarlo
            const modal = document.querySelector('.modal');
            if (modal) {
                modal.remove();
            }
        }


    
    
})();

