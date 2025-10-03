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



    $(document).ready(function () {
    $('table[id^="#InformeIndividual"]').each(function () {
        var modalContent = $(this).closest('.modal-content');
        var nombreAlumno = modalContent.data('nombre');
        var apellidoAlumno = modalContent.data('apellido');
        var dniAlumno = modalContent.data('dni');

        var table = new DataTable(this, {
            dom: '<"d-flex justify-content-between align-items-center mb-2"B>t<"d-flex justify-content-between mt-2"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-success me-2',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    filename: 'Reporte_Asistencias_' + nombreAlumno + '_' + apellidoAlumno,
                    title: 'Reporte de Asistencias de ' + nombreAlumno + ' ' + apellidoAlumno + ' (' + dniAlumno + ')',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-outline-danger me-2',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
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
    const api = this.api(); // referencia a la tabla actual
    const $botones = $(api.buttons().container());

    // Evitar duplicados: si ya existen filtros, no los agrega
    if ($botones.find('.filtros-fecha').length === 0) {

        const $filtros = $(`
            <div class="filtros-fecha d-flex align-items-center ms-3">
                <input type="date" class="fecha-desde form-control form-control-sm me-2">
                <input type="date" class="fecha-hasta form-control form-control-sm me-2">
                <button class="btn-filtrar btn btn-primary btn-sm me-2">Filtrar</button>
                <button class="btn-limpiar btn btn-secondary btn-sm">Limpiar</button>
            </div>
        `);

        $botones.append($filtros);

        
        $filtros.find('.btn-filtrar').on('click', function () {
            const desde = $filtros.find('.fecha-desde').val();
            const hasta = $filtros.find('.fecha-hasta').val();

            
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(f => !f._customFilter);

            
            const filtroPorFecha = function (settings, data) {
                if (settings.nTable !== api.table().node()) return true; // solo filtra su propia tabla
                const fechaCell = data[0]; // 1° columna
                const fechaJS = new Date(fechaCell.split(' ')[0]);
                const desdeJS = desde ? new Date(desde) : null;
                const hastaJS = hasta ? new Date(hasta) : null;

                if (desdeJS && fechaJS < desdeJS) return false;
                if (hastaJS && fechaJS > hastaJS) return false;
                return true;
            };
            filtroPorFecha._customFilter = true;

            $.fn.dataTable.ext.search.push(filtroPorFecha);
            api.draw();

            // Mensaje si no hay registros
            if (api.rows({ filter: 'applied' }).data().length === 0) {
                $(api.table().body()).html(
                    `<tr><td colspan="3" class="text-center text-muted">
                        No hay asistencias en el rango seleccionado.
                      </td></tr>`
                );
            }
        });

        $filtros.find('.btn-limpiar').on('click', function () {
            $filtros.find('.fecha-desde').val('');
            $filtros.find('.fecha-hasta').val('');
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(f => !f._customFilter);
            api.draw();
        });
    }
}

        });
    });
});


</script>