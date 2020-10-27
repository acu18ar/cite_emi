$(function() {
    var experienciaLaboralTable = $('#experienciaLaboral-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexExperienciaLaboral
        }, 
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'ExperienciaLaboral', name: 'ExperienciaLaboral', title: 'ExperienciaLaboral' },
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

    $('#experienciaLaboral-table tbody').on('click', 'tr', function () {
        var data = experienciaLaboralTable.row( this ).data();
        vm.$options.methods.showExperienciaLaboral(data.id);
    });
});

var vm = new Vue({
    el: '#experienciaLaboral-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        experienciaLaboral: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newExperienciaLaboral () {
            vm.experienciaLaboral = {};
            $('#frm-experienciaLaboral').modal('show');
        },
        showExperienciaLaboral (id) {
            axios.post( urlShowExperienciaLaboral, { id: id, experienciaLaboral: 6 })
                .then ( result => {
                        response = result.data;
                    vm.experienciaLaboral = response.data;
                    $('#view-experienciaLaboral').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editExperienciaLaboral () {
            $('#frm-experienciaLaboral').modal('show');  
            $('#view-experienciaLaboral').modal('hide');
        },
        saveExperienciaLaboral () {
            axios.post( urlSaveExperienciaLaboral, vm.experienciaLaboral)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-experienciaLaboral').modal('hide');
                    var experienciaLaboralTable = $('#experienciaLaboral-table').DataTable();
                    experienciaLaboralTable.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteExperienciaLaboral () {           
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyExperienciaLaboral, {id : vm.experienciaLaboral.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var experienciaLaboralTable = $('#experienciaLaboral-table').DataTable();
                            experienciaLaboralTable.draw();
                            $('#view-experienciaLaboral').modal('hide');
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