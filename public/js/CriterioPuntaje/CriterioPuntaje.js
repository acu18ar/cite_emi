$(function() {
    var criteriopuntajeTable = $('#criteriopuntaje-table').DataTable({
        processing: true,
        order: [[0, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexCriterioPuntaje
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'CriterioPuntaje', name: 'CriterioPuntaje', title: 'Criterio de Puntaje' },
            { data: 'Descripcion', name: 'Descripcion', title: 'Descripción' },
            { data: 'Activo', name: 'Activo', title: 'Activo', render:function(data, type, row){
                if (!row.Activo){
                    return '<i class="fa fa-ban text-danger"></i>'; 
                }
                else{
                    return '<i class="fa fa-check text-success"></i>'; 
                }
            } },

            { data: 'action', name: 'action', title: 'Opciones', orderable: false, searchable: false },
        ],
        language: { "url": "/lang/datatables.es.json" },
        dom: 'lftip',
    });

    $('#criteriopuntaje-table tbody').on('click', 'tr', function () {
        var data = criteriopuntajeTable.row( this ).data();
        vm.$options.methods.showCriterioPuntaje(data.id);
    });
});


var vm = new Vue({
    el: '#criteriopuntaje-app',
    data: {
        errorBag: {},
        criteriopuntaje: {}
    },
    methods: {
        newCriterioPuntaje() {
            vm.criteriopuntaje = {};
            $('#frm-criteriopuntaje').modal('show');
        },
        saveCriterioPuntaje() {
            axios.post( urlStoreCriterioPuntaje, vm.criteriopuntaje )
                .then( result => {
                    response = result.data;
                    if( response.success ) {
                        toastr.success(response.msg, 'Correcto!');
                        $('#frm-criteriopuntaje').modal('hide');
                        var criteriopuntajeTabla = $('#criteriopuntaje-table').DataTable();
                        criteriopuntajeTabla.draw();
                    } else {
                        toastr.danger(response.msg, 'Oops!');
                    }
                    
                })
                .catch( error => {
                    console.error( error );
                });
        },
        showCriterioPuntaje(id) {
            axios.post( urlShowCriterioPuntaje, { id: id } )
                .then( result => {
                    vm.criteriopuntaje = result.data.data;
                    $('#view-criteriopuntaje').modal('show');
                })
                .catch( error => {
                    console.log( error );
                });
        },
        editCriterioPuntaje() {
            $('#view-criteriopuntaje').modal('hide');
            $('#frm-criteriopuntaje').modal('show');
        },
        destroyCriterioPuntaje(){
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyCriterioPuntaje, vm.criteriopuntaje )
                        .then( result => {
                            response = result.data;
                            if( response.success ) {
                                toastr.success(response.msg, 'Correcto!');
                                $('#view-criteriopuntaje').modal('hide');
                                var criteriopuntajeTabla = $('#criteriopuntaje-table').DataTable();
                                criteriopuntajeTabla.draw();
                            } else {
                                toastr.danger(response.msg, 'Oops!');
                            }
                        })
                        .catch( error => {
                            console.log ( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!"); 
                }
              });
        }
    }
});