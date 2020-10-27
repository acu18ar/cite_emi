$(function() {
    var tipoempresaTable = $('#tipoempresa-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexTipoEmpresa
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'TipoEmpresa', name: 'TipoEmpresa', title: 'Tipo de Empresa' },
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

    $('#tipoempresa-table tbody').on('click', 'tr', function () {
        var data = tipoempresaTable.row( this ).data();
        vm.$options.methods.showTipoEmpresa(data.id);
    });
});

var vm = new Vue({
    el: '#tipoempresa-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        tipoempresa: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newTipoEmpresa () {
            vm.tipoempresa = {};
            $('#frm-tipoempresa').modal('show');
        },
        showTipoEmpresa (id) {
            axios.post( urlShowTipoEmpresa, { id: id, tipoempresa: 6 })
                .then ( result => {
                        response = result.data;
                    vm.tipoempresa = response.data;
                    $('#view-tipoempresa').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editTipoEmpresa () {
            $('#frm-tipoempresa').modal('show');  
            $('#view-tipoempresa').modal('hide');
        },
        saveTipoEmpresa () {
            axios.post( urlSaveTipoEmpresa, vm.tipoempresa)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-tipoempresa').modal('hide');
                    var tipoempresaTable = $('#tipoempresa-table').DataTable();
                    tipoempresaTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteTipoEmpresa () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyTipoEmpresa, {id : vm.tipoempresa.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var tipoempresaTable = $('#tipoempresa-table').DataTable();
                            tipoempresaTable.draw();
                            $('#view-tipoempresa').modal('hide');
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