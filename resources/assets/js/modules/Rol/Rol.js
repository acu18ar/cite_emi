$(function() {
    var rolTable = $('#rol-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexRol
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'Rol', name: 'Rol', title: 'Rol' },
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

    $('#rol-table tbody').on('click', 'tr', function () {
        var data = rolTable.row( this ).data();
        vm.$options.methods.showRol(data.id);
    });
});

var vm = new Vue({
    el: '#rol-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        rol: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newRol () {
            vm.rol = {};
            $('#frm-rol').modal('show');
        },
        showRol (id) {
            axios.post( urlShowRol, { id: id, rol: 6 })
                .then ( result => {
                        response = result.data;
                    vm.rol = response.data;
                    $('#view-rol').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editRol () {
            $('#frm-rol').modal('show');  
            $('#view-rol').modal('hide');
        },
        saveRol () {
            axios.post( urlSaveRol, vm.rol)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-rol').modal('hide');
                    var rolTabla = $('#rol-table').DataTable();
                    rolTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteRol () {
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
                    axios.post( urlDestroyRol, {id : vm.rol.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var rolTabla = $('#rol-table').DataTable();
                            rolTabla.draw();
                            $('#view-rol').modal('hide');
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
