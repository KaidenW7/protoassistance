(async () => {
    // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
    const respuestaRaw = await fetch("controlador/obtener_datos.php");
    // Decodificar como JSON
    const respuesta = await respuestaRaw.json();
    // Convertir los valores de asistencias, inasistencias e incapacidades a números
    const asistencias = parseInt(respuesta.asistencias);
    const inasistencias = parseInt(respuesta.inasistencias);
    const incapacidades = parseInt(respuesta.incapacidades);
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    const etiquetas = ["Asistencias", "Inasistencias", "Incapacidades"];
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const total = asistencias + inasistencias + incapacidades;
    const porcentajeAsistencias = ((asistencias / total) * 100).toFixed(2);
    const porcentajeInasistencias = ((inasistencias / total) * 100).toFixed(2);
    const porcentajeIncapacidades = ((incapacidades / total) * 100).toFixed(2);

    const datosAsistencias = {
        data: [porcentajeAsistencias, porcentajeInasistencias, porcentajeIncapacidades],
        backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2'],
        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
        borderWidth: 1,
        hoverBackgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(75, 192, 192, 0.5)'],
        hoverBorderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
        hoverOffset: 4
    };

    // ...

    new Chart($grafica, {
        type: 'doughnut', // Tipo de gráfica
        data: {
            labels: etiquetas,
            datasets: [datosAsistencias]
        },
        options: {
            cutoutPercentage: 60, // Controla el tamaño del agujero central (0 = sin agujero)
            plugins: {
                doughnutlabel: {
                    labels: [
                        {
                            text: 'Asistencias: ' + porcentajeAsistencias + '%',
                            font: { size: 16 },
                            color: ('rgba(54, 162, 235, 1')
                        },
                        {
                            text: 'Inasistencias: ' + porcentajeInasistencias + '%',
                            font: { size: 16 },
                            color: ('rgba(255, 99, 132, 1')
                        },
                        {
                            text: 'Incapacidades: ' + porcentajeIncapacidades + '%',
                            font: { size: 16 },
                            color: ('rgba(75, 192, 192, 1')
                        }
                    ]
                }
            }
        }
    });
})();
//------
