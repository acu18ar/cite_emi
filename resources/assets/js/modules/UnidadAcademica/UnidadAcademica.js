$(function() {
    var unidadacademicaTable = $('#unidadacademica-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexUnidadAcademica
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'UnidadAcademica', name: 'UnidadAcademica', title: 'Unidad Académica' },
            { data: 'Sigla', name: 'Sigla', title: 'Sigla' },
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

    $('#unidadacademica-table tbody').on('click', 'tr', function () {
        var data = unidadacademicaTable.row( this ).data();
        vm.$options.methods.showUnidadAcademica(data.id);
    });
});

var vm = new Vue({
    el: '#unidadacademica-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        unidadacademica: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newUnidadAcademica () {
            vm.unidadacademica = {};
            $('#frm-unidadacademica').modal('show');
        },
        showUnidadAcademica (id) {
            axios.post( urlShowUnidadAcademica, { id: id, unidadacademica: 6 })
                .then ( result => {
                        response = result.data;
                    vm.unidadacademica = response.data;
                    $('#view-unidadacademica').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editUnidadAcademica () {
            $('#frm-unidadacademica').modal('show');  
            $('#view-unidadacademica').modal('hide');
        },
        saveUnidadAcademica () {
            axios.post( urlSaveUnidadAcademica, vm.unidadacademica)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-unidadacademica').modal('hide');
                    var unidadacademicaTabla = $('#unidadacademica-table').DataTable();
                    unidadacademicaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteUnidadAcademica () {
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
                    axios.post( urlDestroyUnidadAcademica, {id : vm.unidadacademica.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var unidadacademicaTabla = $('#unidadacademica-table').DataTable();
                            unidadacademicaTabla.draw();
                            $('#view-unidadacademica').modal('hide');
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