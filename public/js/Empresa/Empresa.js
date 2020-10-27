$(function() {
    var empresaTable = $('#empresa-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexEmpresa
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Empresa', name: 'e.Empresa', title: 'Empresa' },
            { data: 'Descripcion', name: 'e.Descripcion', title: 'Descripcion' },
            { data: 'DepDocId', name: 'na.DepDocId', title: 'Departamento' },
            { data: 'TipoEmpresa', name: 'te.TipoEmpresa', title: 'TipoEmpresa' },
            { data: 'FormaJuridica', name: 'fj.FormaJuridica', title: 'FormaJuridica' },
            { data: 'Sector', name: 's.Sector', title: 'Sector' },
            { data: 'Municipio', name: 'm.Municipio', title: 'Municipio' },
            { data: 'Direccion', name: 'e.Direccion', title: 'Direccion' },
            { data: 'Telefono', name: 'e.Telefono', title: 'Telefono' },
            { data: 'Correo', name: 'e.Correo', title: 'Correo' },

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

    $('#empresa-table tbody').on('click', 'tr', function () {
        var data = empresaTable.row( this ).data();
        vm.$options.methods.showEmpresa(data.id);
    });
});

var vm = new Vue({
    el: '#empresa-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        empresa: {},
        depDocIds: {},
        tipoEmpresas: {},
        formaJuridicas: {},
        sectors: {},
        municipios: {},
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        getDepDocIds () {
            axios.get( urlListDepDocId )
                .then( result => {
                    response = result.data;
                    vm.depDocIds = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

        getTipoEmpresas () {
            axios.get( urlListTipoEmpresa )
                .then( result => {
                    response = result.data;
                    vm.tipoEmpresas = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

        getFormaJuridicas () {
            axios.get( urlListFormaJuridica )
                .then( result => {
                    response = result.data;
                    vm.formaJuridicas = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

        getSectors () {
            axios.get( urlListSector )
                .then( result => {
                    response = result.data;
                    vm.sectors = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

        getMunicipios () {
            axios.get( urlListMunicipio )
                .then( result => {
                    response = result.data;
                    vm.municipios = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

        newEmpresa () {
            vm.empresa = {};
            $('#frm-empresa').modal('show');
        },
        
      /*   showEmpresa (id) {
            axios.post( urlShowEmpresa, { id: id, empresa: 6 })
                .then ( result => {
                        response = result.data;
                    vm.empresa = response.data;
                    $('#view-empresa').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        }, */
        showEmpresa(id) {
            axios.get(urlShowEmpresa, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.empresa = response.data;
                    $('#view-empresa').modal('show'); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editEmpresa () {
            $('#frm-empresa').modal('show');  
            $('#view-empresa').modal('hide');
        },
        saveEmpresa () {
            axios.post( urlSaveEmpresa, vm.empresa)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-empresa').modal('hide');
                    var empresaTabla = $('#empresa-table').DataTable();
                    empresaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteEmpresa () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyEmpresa, {id : vm.empresa.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var empresaTabla = $('#empresa-table').DataTable();
                            empresaTabla.draw();
                            $('#view-empresa').modal('hide');
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
        this.getDepDocIds();
        this.getTipoEmpresas();
        this.getFormaJuridicas();
        this.getSectors();
        this.getMunicipios();
    } 
});