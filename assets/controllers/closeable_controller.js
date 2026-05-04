import { Controller } from '@hotwired/stimulus';
	
	export default class extends Controller {
	
	    async close() {
	        // 1. Disparar la transicion CSS reduciendo el alto
	        this.element.style.overflow = 'hidden';
	        this.element.style.height = this.element.offsetHeight + 'px';
	
	        // Forzar un reflow para que el navegador registre el alto inicial
	        this.element.getBoundingClientRect();
	
	        this.element.style.height = '0';
	        this.element.style.opacity = '0';
	        this.element.style.marginBottom = '0';
	
	        // 2. Esperar a que la animacion CSS termine
	        await this.#waitForAnimation();
	
	        // 3. Limpiar el DOM completamente
	        this.element.remove();
	    }
	
	    // Metodo privado (notacion #) que devuelve una Promise
	    // que se resuelve cuando terminan todas las transiciones CSS
	    #waitForAnimation() {
	        return Promise.allSettled(
	            this.element.getAnimations().map(animation => animation.finished)
	        );
	    }
	}