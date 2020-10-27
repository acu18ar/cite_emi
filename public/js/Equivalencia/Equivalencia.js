$(function() {
    var equivalenciaTable = $('#equivalencia-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexEquivalencia
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'NotaPlanilla', name: 'NotaPlanilla', title: 'Nota en Planilla' },
            { data: 'Equivalencia', name: 'Equivalencia', title: 'Nota Equivalente (RAC 02 / Art. 89)' },
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

    $('#equivalencia-table tbody').on('click', 'tr', function () {
        var data = equivalenciaTable.row( this ).data();
        vm.$options.methods.showEquivalencia(data.id);
    });
});

var vm = new Vue({
    el: '#equivalencia-app',
    data: {
        errorBag: {},
        equivalencia: {},
    },
    methods: {
        newEquivalencia () {
            vm.equivalencia = {};
            $('#frm-equivalencia').modal('show');
        },
        showEquivalencia (id) {
            axios.post( urlShowEquivalencia, { id: id })
                .then ( result => {
                        response = result.data;
                    vm.equivalencia = response.data;
                    $('#view-equivalencia').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editEquivalencia () {
            $('#frm-equivalencia').modal('show');  
            $('#view-equivalencia').modal('hide');
        },
        saveEquivalencia () {
            axios.post( urlSaveEquivalencia, vm.equivalencia)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-equivalencia').modal('hide');
                    var equivalenciaTabla = $('#equivalencia-table').DataTable();
                    equivalenciaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteEquivalencia () {
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
                    axios.post( urlDestroyEquivalencia, {id : vm.equivalencia.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var equivalenciaTabla = $('#equivalencia-table').DataTable();
                            equivalenciaTabla.draw();
                            $('#view-equivalencia').modal('hide');
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