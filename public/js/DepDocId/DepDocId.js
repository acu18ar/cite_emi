$(function() {
    var depdocidTable = $('#depdocid-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexDepDocId
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'Num', title: 'No.' },
            { data: 'DepDocId', name: 'DepDocId', title: 'Sigla' },
            { data: 'DepDocIdDescripcion', name: 'DepDocIdDescripcion', title: 'Descripción' },
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

    $('#depdocid-table tbody').on('click', 'tr', function () {
        var data = depdocidTable.row( this ).data();
        vm.$options.methods.showDepDocId(data.id);
    });
});

var vm = new Vue({
    el: '#depdocid-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        depdocid: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        newDepDocId () {
            vm.depdocid = {};
            $('#frm-depdocid').modal('show');
        },
        showDepDocId (id) {
            axios.post( urlShowDepDocId, { id: id, depdocid: 6 })
                .then ( result => {
                        response = result.data;
                    vm.depdocid = response.data;
                    $('#view-depdocid').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editDepDocId () {
            $('#frm-depdocid').modal('show');  
            $('#view-depdocid').modal('hide');
        },
        saveDepDocId () {
            axios.post( urlSaveDepDocId, vm.depdocid)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-depdocid').modal('hide');
                    var depdocidTabla = $('#depdocid-table').DataTable();
                    depdocidTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteDepDocId () {
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
                    axios.post( urlDestroyDepDocId, {id : vm.depdocid.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var depdocidTabla = $('#depdocid-table').DataTable();
                            depdocidTabla.draw();
                            $('#view-depdocid').modal('hide');
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