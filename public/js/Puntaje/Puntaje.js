$(function() {
    var puntajeTable = $('#puntaje-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexPuntaje
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Puntaje', name: 'Puntaje', title: 'Puntaje' },
            { data: 'Descripcion', name: 'Descripcion', title: 'Descripcion' },
            { data: 'Valor', name: 'Valor', title: 'Valor' },
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

    $('#puntaje-table tbody').on('click', 'tr', function () {
        var data = puntajeTable.row( this ).data();
        vm.$options.methods.showPuntaje(data.id);
    });
});

var vm = new Vue({
    el: '#puntaje-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        puntaje: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newPuntaje () {
            vm.puntaje = {};
            $('#frm-puntaje').modal('show');
        },
        showPuntaje (id) {
            axios.post( urlShowPuntaje, { id: id, puntaje: 6 })
                .then ( result => {
                        response = result.data;
                    vm.puntaje = response.data;
                    $('#view-puntaje').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editPuntaje () {
            $('#frm-puntaje').modal('show');  
            $('#view-puntaje').modal('hide');
        },
        savePuntaje () {
            axios.post( urlSavePuntaje, vm.puntaje)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-puntaje').modal('hide');
                    var puntajeTabla = $('#puntaje-table').DataTable();
                    puntajeTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deletePuntaje () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyPuntaje, {id : vm.puntaje.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var puntajeTabla = $('#puntaje-table').DataTable();
                            puntajeTabla.draw();
                            $('#view-puntaje').modal('hide');
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