$(function() {
    var defensaTable = $('#defensa-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexDefensa
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'd.id', orderable: false, searchable: false , visible: false},
            { data: 'Persona', name: 'p.Persona', title: 'Persona' },
            { data: 'Titulo', name: 'd.Titulo', title: 'Titulo' },
            { data: 'Especialidad', name: 'e.Especialidad', title: 'Especialidad' },
            { data: 'UnidadAcademica', name: 'ua.UnidadAcademica', title: 'Unidad Académica' },
            { data: 'Gestion', name: 'd.Gestion', title: 'Gestion' },
            { data: 'PeriodoGestion', name: 'd.PeriodoGestion', title: 'Periodo' },
            //{ data: 'FechaHora', name: 'd.FechaHora', title: 'Fecha y Hora' },
            { data: 'FechaHora', name: 'd.FechaHora', title: 'Fecha y Hora', orderable: true, searchable: true,
                render: function (data, type, row) {
                    return moment(row.FechaHora).format('DD-MM-YYYY HH:mm') ;
                }
            },
            //{ data: 'PromedioDefensa', name: 'd.PromedioDefensa', title: 'Promedio Defensa' },
            { data: 'PromedioDefensa', name: 'd.PromedioDefensa', title: 'Promedio Defensa', orderable: true, searchable: true,
                render: function (data, type, row) {
                    return accounting.formatMoney(row.PromedioDefensa, "", 2, ".", ",") ;
                }
            },
            //{ data: 'TG1', name: 'd.TG1', title: 'TG1' },
            { data: 'TG1', name: 'd.TG1', title: 'TG1', orderable: true, searchable: true,
                render: function (data, type, row) {
                    return accounting.formatMoney(row.TG1, "", 2, ".", ",") ;
                }
            },
            //{ data: 'TG2', name: 'd.TG2', title: 'TG2' },
            { data: 'TG2', name: 'd.TG2', title: 'TG2', orderable: true, searchable: true,
                render: function (data, type, row) {
                    return accounting.formatMoney(row.TG2, "", 2, ".", ",") ;
                }
            },
            //{ data: 'PromedioTotal', name: 'd.PromedioTotal', title: 'Promedio Total' },
            { data: 'PromedioTotal', name: 'd.PromedioTotal', title: 'Promedio Total', orderable: true, searchable: true,
                render: function (data, type, row) {
                    return accounting.formatMoney(row.PromedioTotal, "", 2, ".", ",") ;
                }
            },
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

    $('#defensa-table tbody').on('click', 'tr', function () {
        var data = defensaTable.row( this ).data();
        vm.$options.methods.showDefensa(data.id);
    });
});

var vm = new Vue({
    el: '#defensa-app',
    data: {
        accounting: accounting,
        moment: moment,
        auth: auth,
        errorBag: {},
        isLoading: false,
        defensa: {},
        unidadAcademicas: {},
        especialidades: {},
        personas: {},
        personaDefensa: {},
        tipoMiembros: {},
        puntajes:{},
        accedeNotas:false,
        isLoadingFile: false,
        notaManual:false
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
                            console.log(result);
                            if (result.data.success) {
                                toastr.info(result.data.msg, 'Correcto!');
                                if (op === 'perfil') {
                                    vm.defensa.Documento = result.data.data;
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
        initSelect2() {
            $('#Persona').select2({
                placeholder: "Buscar Miembro Tribunal...",
                minimumInputLength: 3,
                language: 'es',
                ajax: {
                    url: urlSelect2Persona,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on(
                "select2:select", (e) => {
                    vm.personaDefensa.Persona = e.params.data.id;
                }
            );
        },
        initSelectEstudiante() {
            $('#Estudiante').select2({
                placeholder: "Buscar Estudiante...",
                minimumInputLength: 3,
                language: 'es',
                ajax: {
                    url: urlSelect2Persona,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on(
                "select2:select", (e) => {
                    vm.defensa.Persona = e.params.data.id;
                }
            );
        },
        getTipoMiembros(){
            axios.get(urlListTipoMiembro)
                .then(result=>{
                    response=result.data;
                    vm.tipoMiembros = response.data;
                })
        },
        getUnidadAcademicas(){
            axios.get(urlListUnidadAcademica)
                .then(result=>{
                    response=result.data;
                    vm.unidadAcademicas=response.data;
                })
        },
        getEspecialidades(){
            axios.get(urlListEspecialidad)
                .then(result=>{
                    response=result.data;
                    vm.especialidades=response.data;
                })
        },
        getPersonas(){
            axios.get(urlListPersona)
                .then(result=>{
                    response=result.data;
                    vm.personas=response.data;
                })
        },
        newDefensa () {
            vm.defensa = {};
            vm.defensa.Gestion=new Date().getFullYear();
            $('#frm-defensa').modal('show');
        },
        showDefensa (id) {
            axios.post( urlShowDefensa, { id: id })
                .then ( result => {
                    response = result.data;
                    vm.defensa = response.data;
                    vm.defensa.FechaHora = vm.defensa.FechaHora.replace(" ", "T");;
                    vm.accedeNotas=false;
                    vm.notaManual=false;
                    vm.defensa.persona_defensa.forEach(jurado => {
                        if(jurado.Persona==vm.auth.id){
                            if(jurado.tipo_miembro.AccedeNotas){
                                vm.accedeNotas=true;
                            }
                        }
                    });
                    $('#view-defensa').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        editDefensa () {
            $('#frm-defensa').modal('show');
            $('#view-defensa').modal('hide');
        },
        saveDefensa () {
            vm.defensa.TG1=vm.defensa.TG1.toString().replace(",", ".");
            vm.defensa.TG2=vm.defensa.TG2.toString().replace(",", ".");
            if(vm.defensa.TG1<5.1||vm.defensa.TG1> 10||vm.defensa.TG2<5.1||vm.defensa.TG2>10){
                toastr.error('Error, verifique que la nota de TG I y TG II este entre 5.1 y 10', 'Oops!');
            }else{
                if(vm.isLoadingFile){
                    toastr.error('Error, el documento se esta cargando, espere a que termine de cargar.', 'Oops!');
                }else{
                    axios.post( urlSaveDefensa, vm.defensa)
                    .then ( result => {
                        response = result.data;
                        toastr.success(response.msg, 'Correcto!');
                        //$('#view-consulta').modal('show');
                        $('#frm-defensa').modal('hide');
                        var defensaTabla = $('#defensa-table').DataTable();
                        defensaTabla.draw();
                    })
                    .catch(error => {
                        console.log(error);
                        toastr.error('Error al guardar el registro', 'Oops!');
                        vm.errorBag = error.data.errors;
                    });
                }
            }
        },
        deleteDefensa () {

            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyDefensa, {id : vm.defensa.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var defensaTabla = $('#defensa-table').DataTable();
                            defensaTabla.draw();
                            $('#view-defensa').modal('hide');
                        })
                        .catch( error => {
                            console.log ( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
        },
        closeDefensa(){
            swal({
                title: "Estas seguro que deseas finalizar?",
                text: "No podrá cambiar realizar más modificaciones a las notas, si desea revisar sus calificaciones cierre este mensaje!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.get( urlCloseDefensa, { params: { id: vm.defensa.id }})
                        .then( result => {
                            response = result.data;
                            if(response.success){
                                toastr.success(response.msg, 'Correcto!');
                            }else{
                                toastr.error(response.msg, 'Error!');
                            }
                            axios.post( urlShowDefensa, { id: vm.defensa.id })
                                .then ( result => {
                                    response = result.data;
                                    vm.defensa = response.data;
                                })
                                .catch ( error => {
                                    console.log( error );
                                });
                        })
                        .catch ( error => {
                            console.log( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
        },
        printDefensa(option){
            if (!vm.defensa.Finalizado&&(option!=6)){
                toastr.error('Por favor Finaliza la calificacion de la Defensa para imprimir las actas.', 'Oops!');
            }else{
                vm.isLoading = true;
                axios.get( urlPrintDefensa, { params: { id: vm.defensa.id , Tipo: option }})
                    .then( result => {
                        response = result.data;
                        var urlFile = response.data.url;
                        var x=new XMLHttpRequest();
                        x.open("GET", urlFile, true);
                        x.responseType = 'blob';
                        x.onload = e => {
                            download(x.response, vm.defensa.persona.Persona + '.pdf', "application/pdf" );
                            vm.isLoading = false;
                        }
                        x.send();
                        vm.isLoading = false;
                    })
                    .catch( error => {
                        console.log( error );
                    });
            }
        },
        newPersonaDefensa() {
            vm.personaDefensa = { Defensa: vm.defensa.id };
            $('#view-defensa').modal('hide');
            $('#frm-personaDefensa').modal('show');
            vm.initSelect2();
        },
        savePersonaDefensa () {
            axios.post( urlSavePersonaDefensa, vm.personaDefensa )
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    $('#frm-personaDefensa').modal('hide');
                    $('#view-defensa').modal('show');
                    axios.post( urlShowDefensa, { id: vm.defensa.id })
                    .then ( result => {
                        response = result.data;
                        vm.defensa = response.data;
                    })
                    .catch ( error => {
                        console.log( error );
                    });
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deletePersonaDefensa (id) {
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyPersonaDefensa, {id : id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            axios.post( urlShowDefensa, { id: vm.defensa.id })
                                .then ( result => {
                                    response = result.data;
                                    vm.defensa = response.data;
                                })
                                .catch ( error => {
                                    console.log( error );
                                });
                        })
                        .catch( error => {
                            console.log ( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
        },
        printPersonaDefensa(personaDefensa){
            vm.isLoading = true;
            axios.get( urlPrintPersonaDefensa, { params: { id: personaDefensa.id }})
                .then( result => {
                    response = result.data;
                    var urlFile = response.data.url;
                    var x=new XMLHttpRequest();
                    x.open("GET", urlFile, true);
                    x.responseType = 'blob';
                    x.onload = e => {
                        download(x.response, 'ACTA INDIVIDUAL ' + personaDefensa.persona.Persona + '.pdf', "application/pdf" );
                        vm.isLoading = false;
                    }
                    x.send();
                    vm.isLoading = false;
                })
                .catch( error => {
                    console.log( error );
                });
        },
        calificaPersonaDefensa(personaDefensa) {
            axios.get( urlListPuntaje , {params: { PersonaDefensa : personaDefensa}})
                .then( result => {
                    vm.puntajes = result.data.data;
                    $('#view-defensa').modal('hide');
                    $('#view-puntaje').modal('show');
                })
                .catch( error => console.log( error ));
        },
        closePersonaDefensa(personaDefensa){
            swal({
                title: "Estas seguro que deseas finalizar?",
                text: "No podrá cambiar las calificaciones!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.get( urlClosePersonaDefensa, { params: { id: personaDefensa }})
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            axios.post( urlShowDefensa, { id: vm.defensa.id })
                                .then ( result => {
                                    response = result.data;
                                    vm.defensa = response.data;
                                })
                                .catch ( error => {
                                    console.log( error );
                                });
                        })
                        .catch ( error => {
                            console.log( error );
                        })
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
        },
        savePuntaje (puntaje) {
            puntaje.Puntaje=puntaje.Puntaje.replace(",", ".");
            if(puntaje.Puntaje>10||puntaje.Puntaje<7.1){
                toastr.error('Error, verifique que su puntaje este entre 7.1 y 10', 'Oops!');
            }else{
                axios.post( urlSavePuntaje, puntaje )
                .then( result => {
                    response = result.data;
                })
                .catch( error => console.log( error ));
            }
        },
        closePuntaje() {
            axios.post( urlShowDefensa, { id: vm.defensa.id })
                .then ( result => {
                    response = result.data;
                    vm.defensa = response.data;
                    $('#view-defensa').modal('show');
                    $('#view-puntaje').modal('hide');
                })
                .catch ( error => {
                    console.log( error );
                });

        },
        notasSagaPorId(){
            requestNotas={
                id:vm.defensa.Persona,
                gestion: vm.defensa.Gestion,
                periodo: vm.defensa.PeriodoGestion
            };
            console.log(requestNotas);
            axios.get(urlNotasSagaPorId,{ params:requestNotas})
                .then(result =>{
                    //console.log(result.data);
                    vm.defensa.TG1=result.data.data.tg1;
                    vm.defensa.TG2=result.data.data.tg2;
                    if(vm.defensa.TG1<5.1||vm.defensa.TG1<5.1){
                        vm.notaManual=true;
                        toastr.error('Estudiante reincorporado. Favor Introducir las notas manualmente');
                    }else{
                        vm.notaManual=false;
                    }
                })
                .catch ( error => {
                    console.log( error );
                    vm.notaManual=true;
                    toastr.error('Error Saga. Favor Introducir las notas manualmente');
                });
        }
    },
    mounted(){
        this.getUnidadAcademicas();
        this.getEspecialidades();
        this.getPersonas();
        this.getTipoMiembros();
        this.initSelectEstudiante();
    }
});
