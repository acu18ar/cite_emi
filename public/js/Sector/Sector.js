$(function() {
    var sectorTable = $('#sector-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexSector
        }, 
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'Sector', name: 'Sector', title: 'Sector' },
            { data: 'Descripcion', name: 'Descripcion', title: 'Descripción' },
            { data: 'Activo', name: 'Activo', title: 'Activo', render: function(data, type, row) {
                if ( !row.Activo ) {
                    return '<i class="fa fa-ban text-danger"></i>';
                } else {
                    return '<i class="fa fa-check text-success"></i>';
                }
            }},
            { data: 'action', name: 'action', title: 'Opciones', orderable: false, searchable: false },
        ],
        initComplete: function () {  
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? val : '', true, false).draw();
                });                             
            });
        },
        language: { "url": "/lang/datatables.es.json" },
        dom: 'lftip',
    });

    $('#sector-table tbody').on('click', 'tr', function () {
        var data = sectorTable.row( this ).data();
        vm.$options.methods.showSector(data.id);
    });
});

var vm = new Vue({
    el: '#sector-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        sector: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newSector () {
            vm.sector = {};
            $('#frm-sector').modal('show');
        },
        showSector (id) {
            axios.post( urlShowSector, { id: id, sector: 6 })
                .then ( result => {
                        response = result.data;
                    vm.sector = response.data;
                    $('#view-sector').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editSector () {
            $('#frm-sector').modal('show');  
            $('#view-sector').modal('hide');
        },
        saveSector () {
            axios.post( urlSaveSector, vm.sector)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-sector').modal('hide');
                    var sectorTable = $('#sector-table').DataTable();
                    sectorTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteSector () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroySector, {id : vm.sector.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var sectorTable = $('#sector-table').DataTable();
                            sectorTable.draw();
                            $('#view-sector').modal('hide');
                        })
                        .catch( error => {
                            console.log ( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
        }
    },
});