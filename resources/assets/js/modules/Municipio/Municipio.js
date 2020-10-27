$(function() {
    var municipioTable = $('#municipio-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexMunicipio
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Num', name: 'e.Num', title: 'No.' },
            { data: 'DepDocId', name: 'na.DepDocId', title: 'Departamento' },
            { data: 'Municipio', name: 'e.Municipio', title: 'Municipio' },
            { data: 'Descripcion', name: 'e.Descripcion', title: 'Descripción' },
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

    $('#municipio-table tbody').on('click', 'tr', function () {
        var data = municipioTable.row( this ).data();
        vm.$options.methods.showMunicipio(data.id);
    });
});

var vm = new Vue({
    el: '#municipio-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        municipio: {},
        depDocId: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        getDepDocId () {
            axios.get( urlListDepDocId )
                .then( result => {
                    response = result.data;
                    vm.depDocId = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
        newMunicipio () {
            vm.municipio = {};
            $('#frm-municipio').modal('show');
        },
        showMunicipio (id) {
            axios.post( urlShowMunicipio, { id: id, municipio: 6 })
                .then ( result => {
                        response = result.data;
                    vm.municipio = response.data;
                    $('#view-municipio').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editMunicipio () {
            $('#frm-municipio').modal('show');  
            $('#view-municipio').modal('hide');
        },
        saveMunicipio () {
            axios.post( urlSaveMunicipio, vm.municipio)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-municipio').modal('hide');
                    var municipioTabla = $('#municipio-table').DataTable();
                    municipioTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteMunicipio () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyMunicipio, {id : vm.municipio.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var municipioTabla = $('#municipio-table').DataTable();
                            municipioTabla.draw();
                            $('#view-municipio').modal('hide');
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
        this.getDepDocId();
    } 
});