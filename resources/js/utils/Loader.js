import * as swal from 'sweetalert2';

export function showLoader(mensaje = "Cargando...", width = 600, padding = "3em", color = "#716add") {
    return swal.fire({
        title: mensaje,
        width: width,
        padding: padding,
        color: color,
        showConfirmButton: false,
        allowOutsideClick: false,
        backdrop: `
            rgba(0,0,123,0.4)
            url("https://media0.giphy.com/avatars/danielfigueirdo/mR5uHXLuePGT.gif")
            left top
            no-repeat
        `
    });
}

export function closeLoader() {
    return swal.close();
}