$(function() {
    var especialidadTable = $('#especialidad-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexEspecialidad
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'e.Num', title: 'No.' },
            { data: 'NivelAcademico', name: 'na.NivelAcademico', title: 'Nivel Académico' },
            { data: 'Especialidad', name: 'e.Especialidad', title: 'Especialidad' },
            { data: 'Descripcion', name: 'e.Descripcion', title: 'Descripcion' },
            { data: 'Activo', name: 'e.Activo', title: 'Estado', render: function(data, type, row) {
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

    $('#especialidad-table tbody').on('click', 'tr', function () {
        var data = especialidadTable.row( this ).data();
        vm.$options.methods.showEspecialidad(data.id);
    });
});

var vm = new Vue({
    el: '#especialidad-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        especialidad: {},
        nivelAcademicas: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        getNivelAcademicos () {
            axios.get( urlListNivelAcademica ) 
                .then( result => {
                    response = result.data;
                    vm.nivelAcademicas = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
        newEspecialidad () {
            vm.especialidad = {};
            $('#frm-especialidad').modal('show');
        },
        showEspecialidad (id) {
            axios.post( urlShowEspecialidad, { id: id, especialidad: 6 })
                .then ( result => {
                        response = result.data;
                    vm.especialidad = response.data;
                    $('#view-especialidad').modal('show');
                }) 
                .catch ( error => {
                    console.log( error );
                });
        },
        editEspecialidad () {
            $('#frm-especialidad').modal('show');  
            $('#view-especialidad').modal('hide');
        },
        saveEspecialidad () {
            axios.post( urlSaveEspecialidad, vm.especialidad)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-especialidad').modal('hide');
                    var especialidadTabla = $('#especialidad-table').DataTable();
                    especialidadTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteEspecialidad () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyEspecialidad, {id : vm.especialidad.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var especialidadTabla = $('#especialidad-table').DataTable();
                            especialidadTabla.draw();
                            $('#view-especialidad').modal('hide');
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
    mounted () {
        this.getNivelAcademicos();
    } 
});