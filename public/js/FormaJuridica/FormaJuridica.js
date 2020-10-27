$(function() {
    var formajuridicaTable = $('#formajuridica-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexFormaJuridica
        }, 
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'FormaJuridica', name: 'FormaJuridica', title: 'Forma Juridica' },
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

    $('#formajuridica-table tbody').on('click', 'tr', function () {
        var data = formajuridicaTable.row( this ).data();
        vm.$options.methods.showFormaJuridica(data.id);
    });
});

var vm = new Vue({
    el: '#formajuridica-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        formajuridica: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newFormaJuridica () {
            vm.formajuridica = {};
            $('#frm-formajuridica').modal('show');
        },
        showFormaJuridica (id) {
            axios.post( urlShowFormaJuridica, { id: id, formajuridica: 6 })
                .then ( result => {
                        response = result.data;
                    vm.formajuridica = response.data;
                    $('#view-formajuridica').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editFormaJuridica () {
            $('#frm-formajuridica').modal('show');  
            $('#view-formajuridica').modal('hide');
        },
        saveFormaJuridica () {
            axios.post( urlSaveFormaJuridica, vm.formajuridica)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-formajuridica').modal('hide');
                    var formajuridicaTable = $('#formajuridica-table').DataTable();
                    formajuridicaTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteFormaJuridica () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyFormaJuridica, {id : vm.formajuridica.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var formajuridicaTable = $('#formajuridica-table').DataTable();
                            formajuridicaTable.draw();
                            $('#view-formajuridica').modal('hide');
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