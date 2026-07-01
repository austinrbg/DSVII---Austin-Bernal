function confirmarAccion(mensaje) {
    return confirm(mensaje);
}

function mostrarMotivoBaja(id) {
    const motivo = prompt("Ingrese el motivo de baja del colaborador:");

    if (motivo === null) {
        return false;
    }

    if (motivo.trim() === "") {
        alert("Debe escribir un motivo de baja.");
        return false;
    }

    window.location.href = "index.php?accion=dar_baja&id=" + id + "&motivo=" + encodeURIComponent(motivo);

    return false;
}