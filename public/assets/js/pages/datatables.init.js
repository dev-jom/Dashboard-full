$(document).ready(function () {
    try {
        console.log('[DT] jQuery version:', $.fn.jquery);
        console.log('[DT] DataTables present:', !!$.fn.DataTable, 'version:', $.fn.dataTable ? $.fn.dataTable.version : 'n/a');
        console.log('[DT] .datatable elements:', $('.datatable').length);
    } catch (e) {
        // ignore
    }
    // Initialize .datatable tables in an idempotent way
    if ($('.datatable').length && $.fn.DataTable) {
        $('.datatable').each(function () {
            try {
                if ($.fn.DataTable.isDataTable(this)) {
                    console.log('[DT] Destroying existing instance for', this);
                    $(this).DataTable().destroy();
                }
            } catch (e) { /* ignore */ }

            $(this).DataTable({
                dom: '<"top"lf>rt<"bottom"ip>',
                responsive: true,
                pageLength: 5,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json',
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                columnDefs: [
                    { targets: 5, orderable: false }
                ],
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                }
            });
        });
    }

    try {
        // Optional basic table
        $("#datatable").DataTable({
            language: {
            },
            drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") }
        });

        // Scroll vertical table in index
        if ($("#scroll-vertical-datatable").length && $.fn.DataTable) {
            $("#scroll-vertical-datatable").DataTable({
                // Mostrar somente busca no topo e info no rodapé
                dom: '<"top"f>rt<"bottom"i>',
                scrollY: "268px",
                scrollCollapse: true,
                paging: false,
                language: {
                    // Mantém ícones caso algum estilo use paginação, mas ela está desativada
                }
            });
        }

        // Buttons table only if plugin exists
        if ( $("#datatable-buttons").length && $.fn.dataTable && $.fn.dataTable.Buttons ) {
            var a = $("#datatable-buttons").DataTable({
                lengthChange: false,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") },
                buttons: ["copy", "excel", "pdf", "colvis"]
            });
            a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
        }

        if ($("#selection-datatable").length) {
            $("#selection-datatable").DataTable({
                select: { style: "multi" },
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") }
            });
        }

        if ($("#key-datatable").length) {
            $("#key-datatable").DataTable({
                keys: true,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") }
            });
        }

        if ($("#complex-header-datatable").length) {
            $("#complex-header-datatable").DataTable({
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") },
                columnDefs: [{ visible: false, targets: -1 }]
            });
        }

        if ($("#stateSaving-datatable").length) {
            $("#stateSaving-datatable").DataTable({
                stateSave: true,
                language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") }
            });
        }

        if ($("#alternative-page-datatable").length) {
            $("#alternative-page-datatable").DataTable({
                pagingType: "full_numbers",
                drawCallback: function () { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") }
            });
        }
    } catch (e) {
        // ignore errors from optional tables not present on the page
    }
});