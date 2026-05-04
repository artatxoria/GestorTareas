import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    // Declaramos los targets que vamos a usar
    static targets = ['estado', 'prioridad', 'titulo'];

    connect() {
        // Ahora podemos acceder a cada target directamente:
        // this.estadoTarget    -> el elemento con data-tarea-card-target="estado"
        // this.prioridadTarget -> el elemento con data-tarea-card-target="prioridad"
        // this.tituloTarget    -> el elemento con data-tarea-card-target="titulo"
    }

    resaltar() {
        // Por ejemplo, resaltar el titulo al pasar el raton
        this.tituloTarget.classList.add('text-red-600');
    }

    quitarResaltado() {
        this.tituloTarget.classList.remove('text-red-600');
    }
}