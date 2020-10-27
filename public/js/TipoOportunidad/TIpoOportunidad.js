$(function() {
    var tipooportunidadTable = $('#tipooportunidad-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexTipoOportunidad
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'TipoOportunidad', name: 'TipoOportunidad', title: 'Tipo de Oportunidad' },
            { data: 'Descripcion', name: 'Descripcion', title: 'Descripcion' },
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

    $('#tipooportunidad-table tbody').on('click', 'tr', function () {
        var data = tipooportunidadTable.row( this ).data();
        vm.$options.methods.showTipoOportunidad(data.id);
    });
});

var vm = new Vue({
    el: '#tipooportunidad-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        tipooportunidad: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newTipoOportunidad () {
            vm.tipooportunidad = {};
            $('#frm-tipooportunidad').modal('show');
        },
        showTipoOportunidad (id) {
            axios.post( urlShowTipoOportunidad, { id: id, tipooportunidad: 6 })
                .then ( result => {
                        response = result.data;
                    vm.tipooportunidad = response.data;
                    $('#view-tipooportunidad').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editTipoOportunidad () {
            $('#frm-tipooportunidad').modal('show');  
            $('#view-tipooportunidad').modal('hide');
        },
        saveTipoOportunidad () {
            axios.post( urlSaveTipoOportunidad, vm.tipooportunidad)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-tipooportunidad').modal('hide');
                    var tipooportunidadTable = $('#tipooportunidad-table').DataTable();
                    tipooportunidadTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteTipoOportunidad () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyTipoOportunidad, {id : vm.tipooportunidad.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var tipooportunidadTable = $('#tipooportunidad-table').DataTable();
                            tipooportunidadTable.draw();
                            $('#view-tipooportunidad').modal('hide');
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