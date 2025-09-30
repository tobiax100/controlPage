<script>
    new DataTable('#CursoAlumnos', {
        layout: {
            topStart: {
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn btn-outline-danger', // Usar clase de Bootstrap para el botón PDF
                    text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM8.5 1.5V4a1 1 0 0 0 1 1h2.5L8.5 1.5zm-.5 6h-1v2h1v-2zm2.204 2.09a.5.5 0 0 0 .592-.806A2.996 2.996 0 0 0 8 6.25a2.996 2.996 0 0 0-2.795 1.534.5.5 0 0 0 .592.806A2.01 2.01 0 0 1 8 7.25c.77 0 1.459.44 1.794 1.09z"/></svg> PDF',
                    filename: 'Reporte_Curso_Alumnos', // Nombre del archivo descargado (sin extensión)
                    orientation: 'portrait', // Orientación: 'portrait' o 'landscape'
                    pageSize: 'A4', // Tamaño de la página
                    title: 'Reporte de Curso Alumnos', // Título del archivo
                }]
            }
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json' // Cargar el archivo de traducción en español con URL completa
        },
        searching: false, // Elimina el campo de búsqueda
        paging: false, // Elimina la paginación
        info: true // Mostrar información de la tabla
    });



    $(document).ready(function() {
    
    $('table[id^="#InformeIndividual"]').each(function() {
        var modalContent = $(this).closest('.modal-content');
        var nombreAlumno = modalContent.data('nombre');  
        var apellidoAlumno = modalContent.data('apellido'); 
        var dniAlumno = modalContent.data('dni');  

        new DataTable(this, {
            dom: '<"d-flex justify-content-between mb-2"Bf>t<"d-flex justify-content-between mt-2"ip>', // Separar botones y búsqueda
            buttons: [
                {
                    extend: 'excelHtml5', 
                    className: 'btn btn-success', 
                    text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5.707a1 1 0 0 0-.293-.707L10.707 0a1 1 0 0 0-.707-.293zM8 4V1h2v3H8zM3 1h2v3H3V1zm0 12V5h10v8H3z"/></svg> Excel',
                    filename: 'Reporte_Asistencias_' + nombreAlumno + '_' + apellidoAlumno, // Nombre del archivo Excel con el nombre del alumno
                    title: 'Reporte de Asistencias de ' + nombreAlumno + ' ' + apellidoAlumno + ' (' + dniAlumno + ')', // Título del reporte
                    exportOptions: {
                        columns: ':visible' // Exportar solo las columnas visibles
                    }
                },
                {
                        extend: 'pdfHtml5',
                        className: 'btn btn-outline-danger',
                        text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM8.5 1.5V4a1 1 0 0 0 1 1h2.5L8.5 1.5zm-.5 6h-1v2h1v-2zm2.204 2.09a.5.5 0 0 0 .592-.806A2.996 2.996 0 0 0 8 6.25a2.996 2.996 0 0 0-2.795 1.534.5.5 0 0 0 .592.806A2.01 2.01 0 0 1 8 7.25c.77 0 1.459.44 1.794 1.09z"/></svg> PDF',
                        filename: 'Reporte_Asistencias_' + nombreAlumno + '_' + apellidoAlumno,
                        title: 'Reporte de Asistencias de ' + nombreAlumno + ' ' + apellidoAlumno + ' (' + dniAlumno + ')',
                        orientation: 'portrait',
                        pageSize: 'A4'
                    }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json' 
            },
            searching: false,
            info: false,
            paging: true,
            pagingType: 'simple_numbers', 
            initComplete: function () {
                // Usar clases de Bootstrap 5 para los botones de paginación
                $('.dataTables_paginate .paginate_button').addClass('btn btn-outline-primary btn-sm');
            }
        });
        
    });
});

</script>