$(function() {
    var vistaEmpleadoTable = $('#vistaEmpleado-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexVistaEmpleado
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Persona', name: 'p.Persona', title: 'Persona' }, 
            { data: 'Titulado', name: 't.Titulado', title: 'Grado Académico' },
            { data: 'TipoOportunidad', name: 'to.TipoOportunidad', title: 'Oportunidad' },
            { data: 'Sector', name: 's.Sector', title: 'Sector' },
           /*  { data: 'TipoMiembro', name: 'tm.TipoMiembro', title: 'Miembro' },
            { data: 'DepDocId', name: 'd.DepDocId', title: 'Ciudad' }, 
            { data: 'Municipio', name: 'm.Municipio', title: 'Municipio' },
           */  { data: 'ExperienciaLaboral', name: 'ex.ExperienciaLaboral', title: 'Experiencia Laboral' },
            { data: 'Descripcion', name: 'e.Descripcion', title: 'Descripcion' },
            { data: 'PalabrasClaves', name: 'e.PalabrasClaves', title: 'Palabras Claves' },
            { data: 'HojaVida', name: 'e.HojaVida', title: 'Hoja Vida' },
            
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

    $('#vistaEmpleado-table tbody').on('click', 'tr', function () {
        var data = vistaEmpleadoTable.row( this ).data();
        vm.$options.methods.showVistaEmpleado(data.id);
    });
});

var vm = new Vue({
    el: '#vistaEmpleado-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        vistaEmpleado: {},
        
        personas: {},
        titulados: {},
        tipoOportunidads: {},
        sectors: {},
        tipoMiembros: {},
        depDocIds: {},
        municipios: {},
        experienciaLaborals: {},
               
    },
    methods: {
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        getPersonas () {
            axios.get( urlListPersona )
                .then( result => {
                    response = result.data;
                    vm.personas = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
        getTitulados () {
            axios.get( urlListTitulado )
                .then( result => {
                    response = result.data;
                    vm.titulados = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
        getTipoOportunidads () {
            axios.get( urlListTipoOportunidad )
                .then( result => {
                    response = result.data;
                    vm.tipoOportunidads = response.data; 
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

        getTipoMiembros () {
            axios.get( urlListTipoMiembro )
                .then( result => {
                    response = result.data;
                    vm.tipoMiembros = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
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

        getExperienciaLaborals () {
            axios.get( urlListExperienciaLaboral )
                .then( result => {
                    response = result.data;
                    vm.experienciaLaborals = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },

       
        newVistaEmpleado () {
            vm.vistaEmpleado = {};
            $('#frm-vistaEmpleado').modal('show');
        },
        
      /*   showVistaEmpleado (id) {
            axios.post( urlShowVistaEmpleado, { id: id, vistaEmpleado: 6 })
                .then ( result => {
                        response = result.data;
                    vm.vistaEmpleado = response.data;
                    $('#view-vistaEmpleado').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        }, */
        showVistaEmpleado(id) {
            axios.get(urlShowVistaEmpleado, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.vistaEmpleado = response.data;
                    $('#view-vistaEmpleado').modal('show'); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editVistaEmpleado () {
            $('#frm-vistaEmpleado').modal('show');  
            $('#view-vistaEmpleado').modal('hide');
        },
        saveVistaEmpleado () {
            axios.post( urlSaveVistaEmpleado, vm.vistaEmpleado)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-vistaEmpleado').modal('hide');
                    var vistaEmpleadoTabla = $('#vistaEmpleado-table').DataTable();
                    vistaEmpleadoTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteVistaEmpleado () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyVistaEmpleado, {id : vm.vistaEmpleado.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var vistaEmpleadoTabla = $('#vistaEmpleado-table').DataTable();
                            vistaEmpleadoTabla.draw();
                            $('#view-vistaEmpleado').modal('hide');
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
       
        this.getPersonas();
        this.getTitulados();
        this.getTipoOportunidads();
        this.getSectors();
        this.getTipoMiembros();
        this.getDepDocIds();
        this.getMunicipios();
        this.getExperienciaLaborals();
        
    } 
});