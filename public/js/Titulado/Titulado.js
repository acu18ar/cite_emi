$(function() {
    var tituladoTable = $('#titulado-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexTitulado
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'Titulado', name: 'Titulado', title: 'Titulado' },
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

    $('#titulado-table tbody').on('click', 'tr', function () {
        var data = tituladoTable.row( this ).data();
        vm.$options.methods.showTitulado(data.id);
    });
});

var vm = new Vue({
    el: '#titulado-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        titulado: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newTitulado () {
            vm.titulado = {};
            $('#frm-titulado').modal('show');
        },
        showTitulado (id) {
            axios.post( urlShowTitulado, { id: id, titulado: 6 })
                .then ( result => {
                        response = result.data;
                    vm.titulado = response.data;
                    $('#view-titulado').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editTitulado () {
            $('#frm-titulado').modal('show');  
            $('#view-titulado').modal('hide');
        },
        saveTitulado () {
            axios.post( urlSaveTitulado, vm.titulado)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-titulado').modal('hide');
                    var tituladoTabla = $('#titulado-table').DataTable();
                    tituladoTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteTitulado () {
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
                    axios.post( urlDestroyTitulado, {id : vm.titulado.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var tituladoTabla = $('#titulado-table').DataTable();
                            tituladoTabla.draw();
                            $('#view-titulado').modal('hide');
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
