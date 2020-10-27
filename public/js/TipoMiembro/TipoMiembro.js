$(function() {
    var tipomiembroTable = $('#tipomiembro-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexTipoMiembro
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'TipoMiembro', name: 'TipoMiembro', title: 'Tipo de Miembro' },
            { data: 'Descripcion', name: 'Descripcion', title: 'Descripcion' },
            { data: 'Abreviacion', name: 'Abreviacion', title: 'Abreviacion' },
            { data: 'Requerido', name: 'Requerido', title: 'Requerido', render: function(data, type, row) {
                if (row.Requerido) {
                    return '<i class="fa fa-check text-success"></i>';
                } else {
                    return '<i class="fa fa-ban text-danger"></i>';
                }
            } },
            { data: 'Activo', name: 'Activo', title: 'Activo', render: function(data, type, row) {
                if (row.Activo) {
                    return '<i class="fa fa-check text-success"></i>';
                } else {
                    return '<i class="fa fa-ban text-danger"></i>';
                }
            } },
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

    $('#tipomiembro-table tbody').on('click', 'tr', function () {
        var data = tipomiembroTable.row( this ).data();
        vm.$options.methods.showTipoMiembro(data.id);
    });
});

var vm = new Vue({
    el: '#tipomiembro-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        tipomiembro: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newTipoMiembro () {
            vm.tipomiembro = {};
            $('#frm-tipomiembro').modal('show');
        },
        showTipoMiembro (id) {
            axios.post( urlShowTipoMiembro, { id: id, tipomiembro: 6 })
                .then ( result => {
                        response = result.data;
                    vm.tipomiembro = response.data;
                    $('#view-tipomiembro').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editTipoMiembro () {
            $('#frm-tipomiembro').modal('show');  
            $('#view-tipomiembro').modal('hide');
        },
        saveTipoMiembro () {
            axios.post( urlSaveTipoMiembro, vm.tipomiembro)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-tipomiembro').modal('hide');
                    var tipomiembroTabla = $('#tipomiembro-table').DataTable();
                    tipomiembroTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteTipoMiembro () {
            // axios.post( urlDestroyConsulta, {id : vm.consulta.id} )
            //     .then( result => {
            //         response = result.data;
            //         toastr.success(response.msg, 'Correcto!');
            //         var consultaTabla = $('#consulta-table').DataTable();
            //         consultaTabla.draw();
            //         $('#view-consulta').modal('hide');
            //     })
            //     .catch( error => {
            //         console.log ( error );
            //     })
            //$('#view-consulta').modal('hide');
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyTipoMiembro, {id : vm.tipomiembro.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var tipomiembroTabla = $('#tipomiembro-table').DataTable();
                            tipomiembroTabla.draw();
                            $('#view-tipomiembro').modal('hide');
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