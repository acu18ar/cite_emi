$(function() {
    var estadocivilTable = $('#estadocivil-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexEstadoCivil
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'EstadoCivil', name: 'EstadoCivil', title: 'Estado Civil' },
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

    $('#estadocivil-table tbody').on('click', 'tr', function () {
        var data = estadocivilTable.row( this ).data();
        vm.$options.methods.showEstadoCivil(data.id);
    });
});

var vm = new Vue({
    el: '#estadocivil-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        estadocivil: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newEstadoCivil () {
            vm.estadocivil = {};
            $('#frm-estadocivil').modal('show');
        },
        showEstadoCivil (id) {
            axios.post( urlShowEstadoCivil, { id: id, estadocivil: 6 })
                .then ( result => {
                        response = result.data;
                    vm.estadocivil = response.data;
                    $('#view-estadocivil').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editEstadoCivil () {
            $('#frm-estadocivil').modal('show');  
            $('#view-estadocivil').modal('hide');
        },
        saveEstadoCivil () {
            axios.post( urlSaveEstadoCivil, vm.estadocivil)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-estadocivil').modal('hide');
                    var estadocivilTabla = $('#estadocivil-table').DataTable();
                    estadocivilTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteEstadoCivil () {
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
                    axios.post( urlDestroyEstadoCivil, {id : vm.estadocivil.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var estadocivilTabla = $('#estadocivil-table').DataTable();
                            estadocivilTabla.draw();
                            $('#view-estadocivil').modal('hide');
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
