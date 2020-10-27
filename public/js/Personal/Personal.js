$(function () {
    var personalTabla = $('#personal-table').DataTable({
        processing: true,
        order: [[0, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexPersonal
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'Persona', name: 'p.Persona', title: 'Nombre Completo' },
            
            { data: 'CI', name: 'p.CI', title: 'CI' },
            { data: 'DepDocId', name: 'p.DepDocId', title: 'Extension' },
            
            { data: 'TipoPersona', name: 'p.TipoPersona', title: 'Procedencia', render: function(data, type, row) {
                if ( row.TipoPersona === 'I' ) {
                    return 'INTERNO';
                } else if (row.TipoPersona === 'E') {
                    return 'EXTERNO';
                } else {
                    return 'OTRO';
                }
            }},
           
            { data: 'Activo', name: 'p.Activo', title: 'Estado', render: function(data, type, row) {
                if ( !row.Activo ) {
                    return '<i class="fa fa-ban text-danger"></i>';
                } else {
                    return '<i class="fa fa-check text-success"></i>';
                }
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: { "url": "/lang/datatables.es.json" },
        dom: 'lftip',
    });

    $('#personal-table tbody').on('click', 'tr', function () {
        var data = personalTabla.row(this).data();
        vm.$options.methods.showPersonal(data.id);
    });
});

var vm = new Vue({
    el: '#personal-app',
    data: {
        moment: moment,
        auth: auth,
        errorBag: {},
        isLoading: false,
        isLoadingFile: false,
        personal: {},
        municipios: {},
        estadoCivils: {},
       
        depDocIds: {}
    },
    methods: {
        loadFile(input, op) {
            vm.isLoadingFile = true;
            var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(input.files[0]);
                    var data = new FormData();
                    data.append('File', input.files[0]);
                    data.append('op', op);
                    axios.post(urlUploadFile, data)
                        .then( result => {
                            if (result.data.success) {
                                toastr.info(result.data.msg, 'Correcto!');
                                if (op === 'perfil') {
                                    vm.personal.FotoMin = result.data.data;
                                } else {
                                    vm.personal.FirmaDigitalizada = result.data.data;
                                }
                            } else {
                                toastr.error(result.data.msg, 'Oops!');
                            }
                            vm.isLoadingFile = false;
                        })
                        .catch( error => {
                            toastr.error('Error subiendo archivo', 'Oops!');
                            vm.isLoadingFile = false;
                        });
                }
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
        getEstadoCivils () {
            axios.get( urlListEstadoCivil )
                .then( result => {
                    response = result.data;
                    vm.estadoCivils = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
       /*  getEspecialidades () {
            axios.get( urlListEspecialidad )
                .then( result => {
                    response = result.data;
                    vm.especialidades = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        }, */
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
        newPersonal() {
            vm.personal = {};
            vm.personal.Activo = true;
            vm.errorBag = {};
            $('#frm-personal').modal('show');
        },
        showPersonal(id) {
            axios.get(urlShowPersonal, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.personal = response.data;
                    $('#view-personal').modal('show');
                })
                .catch(error => {
                    console.log(error);
                });
        },
      /*   cambiopassword(id) {
            $('#view-personal').modal('hide');
            $('#view-password').modal('show');
        },
        changePassword() {
            vm.password.Persona = vm.personal.id;
            axios.post( urlChangePasswordPersona, vm.password)
                .then( result => {
                    response = result.data;
                    if ( response.success ) {
                        toastr.success(response.msg, 'Correcto!');
                        $('#view-password').modal('hide');
                        $('#view-personal').modal('show');
                    } else {
                        toastr.error(response.msg, 'Oops!');
                    }
                })
                .catch( error => {
                    console.log( error );
                    toastr.error('Error al guardar el registro', 'Oops!');
                    vm.errorBag = error.data.errors;
                })
        }, */
        editPersonal() {
            $('#view-personal').modal('hide');
            $('#frm-personal').modal('show');
        },
        savePersonal() {
            axios.post(urlSavePersonal, vm.personal)
                .then(result => {
                    response = result.data;
                    vm.personal = response.data;
                    toastr.success(response.msg, 'Correcto!');
                    $('#frm-personal').modal('hide');
                    this.showPersonal(vm.personal.id);
                    //$('#view-personal').modal('show');
                    var personalTabla = $('#personal-table').DataTable();
                    personalTabla.draw();
                })
                .catch(error => {
                    console.log(error);
                    toastr.error('Error al guardar el registro', 'Oops!');
                    vm.errorBag = error.data.errors;
                });
        },
        deletePersonal() {
            swal({
                title: "Estas seguro que deseas eliminar el registro?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.post(urlDestroyPersonal, { id: vm.personal.id })
                        .then(result => {
                            response = result.data;
                            if ( response.success ) {
                                toastr.success(response.msg, 'Correcto!');
                                var personalTabla = $('#personal-table').DataTable();
                                personalTabla.draw();
                                $('#view-personal').modal('hide');
                            } else {
                                toastr.error(response.msg, 'Oops!');
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        })
                } else {
                }
            });
        },
    },
    mounted () {
        this.getMunicipios();
        this.getEstadoCivils();
        /* this.getEspecialidades(); */
        this.getDepDocIds();
    } 
});