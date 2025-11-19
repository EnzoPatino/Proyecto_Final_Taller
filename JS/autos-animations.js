// Animaciones y efectos interactivos para las páginas de autos
// Archivo de prueba para ver efectos con JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Agregar clase animate-on-scroll a los contenedores para activar las animaciones
    const contenidoDivs = document.querySelectorAll('.contenido, .contenido-container');
    contenidoDivs.forEach(div => {
        div.classList.add('animate-on-scroll');
        
        // Hacer visibles los elementos que ya están en el viewport
        setTimeout(() => {
            const rect = div.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isVisible) {
                const elements = div.querySelectorAll('h1, h2, h3, p');
                elements.forEach(el => {
                    const elRect = el.getBoundingClientRect();
                    if (elRect.top < window.innerHeight && elRect.bottom > 0) {
                        el.classList.add('visible');
                    }
                });
            }
        }, 100);
    });
    
    // 2. Animación de fade-in al hacer scroll (Intersection Observer)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observar todos los elementos de contenido
    const contenidoElements = document.querySelectorAll('.contenido h1, .contenido h2, .contenido h3, .contenido p, .contenido-container h1, .contenido-container h2, .contenido-container h3, .contenido-container p');
    contenidoElements.forEach(el => {
        observer.observe(el);
    });

    // 2. Efecto de resaltado dinámico en los títulos
    const titulos = document.querySelectorAll('.contenido h1, .contenido h2, .contenido h3, .contenido-container h1, .contenido-container h2, .contenido-container h3');
    titulos.forEach(titulo => {
        titulo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        titulos.forEach(t => {
            t.addEventListener('mouseleave', function() {
                if (!this.classList.contains('h3')) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    });

    // 3. Contador de caracteres en tiempo real (ejemplo de utilidad)
    const parrafos = document.querySelectorAll('.contenido p, .contenido-container p');
    parrafos.forEach(p => {
        p.addEventListener('click', function() {
            const caracteres = this.textContent.length;
            const palabras = this.textContent.split(/\s+/).filter(word => word.length > 0).length;
            
            // Crear tooltip temporal
            const tooltip = document.createElement('div');
            tooltip.textContent = `${palabras} palabras, ${caracteres} caracteres`;
            tooltip.style.cssText = `
                position: absolute;
                background: #0b3a66;
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 12px;
                pointer-events: none;
                z-index: 1000;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(tooltip);
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + 'px';
            tooltip.style.top = (rect.top - 30) + 'px';
            
            setTimeout(() => {
                tooltip.remove();
            }, 2000);
        });
    });

    // 4. Efecto de "pulso" en las imágenes al pasar el mouse
    const imagenes = document.querySelectorAll('.imagenes-container img');
    imagenes.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.boxShadow = '0 4px 16px rgba(11, 58, 102, 0.3)';
            this.style.transition = 'all 0.3s ease';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        });
    });

    // 5. Animación de carga inicial (fade in general)
    setTimeout(() => {
        const container = document.querySelector('.container');
        if (container) {
            container.style.opacity = '0';
            container.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                container.style.opacity = '1';
            }, 100);
        }
    }, 100);

    // 6. Efecto de "marca" al hacer click en los párrafos (resaltado temporal)
    parrafos.forEach(p => {
        p.style.cursor = 'pointer';
        p.addEventListener('click', function() {
            const originalBg = this.style.backgroundColor;
            this.style.backgroundColor = '#e8f4f8';
            this.style.transition = 'background-color 0.3s ease';
            
            setTimeout(() => {
                this.style.backgroundColor = originalBg;
            }, 1000);
        });
    });
});

