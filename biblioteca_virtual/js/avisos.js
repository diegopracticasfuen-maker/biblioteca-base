
// Mostrar una alerta visual tipo Bootstrap que desaparece automáticamente
function mostrarAviso(mensaje, tipo = 'info') {
    const contenedor = document.createElement('div');
    contenedor.className = `alert alert-${tipo}`;
    contenedor.innerText = mensaje;

    contenedor.style.position = 'fixed';
    contenedor.style.top = '20px';
    contenedor.style.right = '20px';
    contenedor.style.zIndex = '9999';
    contenedor.style.minWidth = '280px';
    contenedor.style.padding = '15px';
    contenedor.style.borderRadius = '6px';
    contenedor.style.boxShadow = '0 3px 6px rgba(0,0,0,0.2)';
    contenedor.style.fontSize = '16px';

    document.body.appendChild(contenedor);

    setTimeout(() => {
        contenedor.remove();
    }, 5000);
}

// Opción manual para mostrar desde HTML o PHP
// <script>mostrarAviso('Contraseña incorrecta', 'danger');</script>

// Tipos soportados por Bootstrap: 
// 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'

// También puedes usarlo desde otros eventos:
// mostrarAviso("Reserva registrada", "success");
