$(function() {
    var nivelacademicoTable = $('#nivelacademico-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexNivelAcademico
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'NivelAcademico', name: 'NivelAcademico', title: 'Nivel Académico' },
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

    $('#nivelacademico-table tbody').on('click', 'tr', function () {
        var data = nivelacademicoTable.row( this ).data();
        vm.$options.methods.showNivelAcademico(data.id);
    });
});

var vm = new Vue({
    el: '#nivelacademico-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        nivelacademico: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newNivelAcademico () {
            vm.nivelacademico = {};
            $('#frm-nivelacademico').modal('show');
        },
        showNivelAcademico (id) {
            axios.post( urlShowNivelAcademico, { id: id, nivelacademico: 6 })
                .then ( result => {
                        response = result.data;
                    vm.nivelacademico = response.data;
                    $('#view-nivelacademico').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editNivelAcademico () {
            $('#frm-nivelacademico').modal('show');  
            $('#view-nivelacademico').modal('hide');
        },
        saveNivelAcademico () {
            axios.post( urlSaveNivelAcademico, vm.nivelacademico)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-nivelacademico').modal('hide');
                    var nivelacademicoTable = $('#nivelacademico-table').DataTable();
                    nivelacademicoTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteNivelAcademico () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyNivelAcademico, {id : vm.nivelacademico.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var nivelacademicoTable = $('#nivelacademico-table').DataTable();
                            nivelacademicoTable.draw();
                            $('#view-nivelacademico').modal('hide');
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