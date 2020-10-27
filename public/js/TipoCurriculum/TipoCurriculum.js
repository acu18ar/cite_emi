$(function() {
    var tipoCurriculumTable = $('#tipoCurriculum-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexTipoCurriculum
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'e.Num', title: 'No.' },
            { data: 'NivelAcademico', name: 'na.NivelAcademico', title: 'Nivel Académico' },
            { data: 'TipoCurriculum', name: 'e.TipoCurriculum', title: 'TipoCurriculum' },
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

    $('#tipoCurriculum-table tbody').on('click', 'tr', function () {
        var data = tipoCurriculumTable.row( this ).data();
        vm.$options.methods.showTipoCurriculum(data.id);
    });
});

var vm = new Vue({
    el: '#tipoCurriculum-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        tipoCurriculum: {},
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
        newTipoCurriculum () {
            vm.tipoCurriculum = {};
            $('#frm-tipoCurriculum').modal('show');
        },
        showTipoCurriculum (id) {
            axios.post( urlShowTipoCurriculum, { id: id, tipoCurriculum: 6 })
                .then ( result => {
                        response = result.data;
                    vm.tipoCurriculum = response.data;
                    $('#view-tipoCurriculum').modal('show');
                }) 
                .catch ( error => {
                    console.log( error );
                });
        },
        editTipoCurriculum () {
            $('#frm-tipoCurriculum').modal('show');  
            $('#view-tipoCurriculum').modal('hide');
        },
        saveTipoCurriculum () {
            axios.post( urlSaveTipoCurriculum, vm.tipoCurriculum)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-tipoCurriculum').modal('hide');
                    var tipoCurriculumTabla = $('#tipoCurriculum-table').DataTable();
                    tipoCurriculumTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteTipoCurriculum () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyTipoCurriculum, {id : vm.tipoCurriculum.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var tipoCurriculumTabla = $('#tipoCurriculum-table').DataTable();
                            tipoCurriculumTabla.draw();
                            $('#view-tipoCurriculum').modal('hide');
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