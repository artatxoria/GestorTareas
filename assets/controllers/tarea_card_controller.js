import { Controller } from '@hotwired/stimulus';
	
	export default class extends Controller {
	
	    // Declaramos los targets que vamos a usar
	    static targets = ['estado', 'prioridad', 'titulo'];
	
        // Definimos el valor para recibir la prioridad desde Twig
	    static values = {
	        prioridad: Number
	    }

	    connect() {
	        // Ahora podemos acceder a cada target directamente:
	        // this.estadoTarget    -> el elemento con data-tarea-card-target="estado"
	        // this.prioridadTarget -> el elemento con data-tarea-card-target="prioridad"
	        // this.tituloTarget    -> el elemento con data-tarea-card-target="titulo"
	        // Esto mostrará el título de la tarea en la consola
	        console.log("Controlador conectado en:", this.tituloTarget.innerText);
	        
            // Si la prioridad es 8 o mayor, aplicamos el borde
	        if (this.prioridadValue >= 8) {
	            this.element.style.border = "2px solid #dc2626";
	            this.element.style.borderRadius = "0.5rem";
	        }

	    }
	
	    resaltar() {
	        // Por ejemplo, resaltar el titulo al pasar el raton
	        // this.tituloTarget.classList.add('!text-red-600');
	        this.tituloTarget.style.setProperty('color', '#dc2626', 'important');
	    }
	
	    quitarResaltado() {
	        // this.tituloTarget.classList.remove('!text-red-600');
	        this.tituloTarget.style.removeProperty('color');
	    }
	}