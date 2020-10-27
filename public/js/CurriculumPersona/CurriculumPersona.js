$(function() {
    var curriculumPersonaTable = $('#curriculumPersona-table').DataTable({
        processing: true,
        order: [[1, 'desc']],
        serverSide: true,
        ajax: {
            url: urlIndexCurriculumPersona
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
           /*  { data: 'id', name: 'e.id', title: 'N°' }, */
            { data: 'Persona', name: 'p.Persona', title: 'Persona' },
            { data: 'NivelAcademico', name: 'na.NivelAcademico', title: 'Nivel Academico' },
            { data: 'TipoCurriculum', name: 'tc.TipoCurriculum', title: 'Tipo Curriculum' },
            { data: 'NumeroDocumento', name: 'e.NumeroDocumento', title: 'Numero Documento' },
            { data: 'Tenor', name: 'e.Tenor', title: 'Tenor' },
            { data: 'EntidadEmisora', name: 'e.EntidadEmisora', title: 'EntidadEmisora' },
            { data: 'Fecha', name: 'e.Fecha', title: 'Fecha' },
           
            { data: 'Activo', name: 'e.Activo', title: 'Activo', render: function(data, type, row) {
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

    $('#curriculumPersona-table tbody').on('click', 'tr', function () {
        var data = curriculumPersonaTable.row( this ).data();
        vm.$options.methods.showCurriculumPersona(data.id);
    });
});

var vm = new Vue({
    el: '#curriculumPersona-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        curriculumPersona: {},
        nivelAcademicos: {},
        tipoCurriculums: {},
        personas: {},
       
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
                                    vm.curriculumPersona.Foto = result.data.data;
                                } else {
                                    vm.curriculumPersona.FirmaDigitalizada = result.data.data;
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
        ejecutar() {
            alert('Hola' + vm.nombre );
        },
        getNivelAcademicos () {
            axios.get( urlListNivelAcademico )
                .then( result => {
                    response = result.data;
                    vm.nivelAcademicos = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
        },
        getTipoCurriculums () {
            axios.get( urlListTipoCurriculum )
                .then( result => {
                    response = result.data;
                    vm.tipoCurriculums = response.data; 
                })
                .catch( error => {
                    console.log( error );
                })
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


        newCurriculumPersona () {
            vm.curriculumPersona = {};
            $('#frm-curriculumPersona').modal('show');
        },
        
      /*   showCurriculumPersona (id) {
            axios.post( urlShowCurriculumPersona, { id: id, curriculumPersona: 6 })
                .then ( result => {
                        response = result.data;
                    vm.curriculumPersona = response.data;
                    $('#view-curriculumPersona').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        }, */
        showCurriculumPersona(id) {
            axios.get(urlShowCurriculumPersona, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.curriculumPersona = response.data;
                    $('#view-curriculumPersona').modal('show'); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editCurriculumPersona () {
            $('#frm-curriculumPersona').modal('show');  
            $('#view-curriculumPersona').modal('hide');
        },
        saveCurriculumPersona () {
            axios.post( urlSaveCurriculumPersona, vm.curriculumPersona)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-curriculumPersona').modal('hide');
                    var curriculumPersonaTabla = $('#curriculumPersona-table').DataTable();
                    curriculumPersonaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteCurriculumPersona () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyCurriculumPersona, {id : vm.curriculumPersona.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var curriculumPersonaTabla = $('#curriculumPersona-table').DataTable();
                            curriculumPersonaTabla.draw();
                            $('#view-curriculumPersona').modal('hide');
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
        this.getNivelAcademicos();
        this.getTipoCurriculums();
        this.getPersonas();
       
    } 
});