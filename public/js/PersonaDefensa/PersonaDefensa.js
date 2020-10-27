$(function() {
    var personaDefensaTable = $('#personaDefensa-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexPersonaDefensa
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'pd.id', orderable: false, searchable: false , visible: false},
            { data: 'Estudiante', name: 'e.Persona', title: 'Estudiante' },
            { data: 'Miembro', name: 'p.Persona', title: 'Miembro' },
            { data: 'Titulo', name: 'd.Titulo', title: 'Trabajo de Grado' },
            { data: 'TipoMiembro', name: 'tm.TipoMiembro', title: 'Tipo Miembro' },
            { data: 'action', name: 'action', title: 'Opciones', orderable: false, searchable: false },
        ],
        language: { "url": "/lang/datatables.es.json" },
        dom: 'lftip',
    });

    $('#personaDefensa-table tbody').on('click', 'tr', function () {
        var data = personaDefensaTable.row( this ).data();
        vm.$options.methods.showPersonaDefensa(data.id);
    });
});

var vm = new Vue({
    el: '#personaDefensa-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        personaDefensa: {},
        puntajes:{}
    },
    methods: {
        showPersonaDefensa (id) {
            axios.get( urlShowPersonaDefensa, { params: {id: id}})
                .then ( result => {
                    response = result.data;
                    vm.personaDefensa = response.data;
                    $('#view-puntaje').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        },
        savePersonaDefensa () {
            axios.post( urlSaveDefensa, vm.defensa)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-defensa').modal('hide');
                    var defensaTabla = $('#defensa-table').DataTable();
                    defensaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        closePersonaDefensa(){
            axios.get( urlCosePersonaDefensa, { params: { id: vm.personaDefensa.id }})
                .then( result => {
                    response = result.data;
                })
                .catch ( error => {
                    console.log( error );
                })
        },
        savePuntaje (puntaje) {
            axios.post( urlSavePuntaje, puntaje )
                .then( result => {
                    response = result.data;
                    //toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#view-puntaje').modal('hide');
                    var puntajeTabla = $('#puntaje-table').DataTable();
                    puntajeTabla.draw();
                })
                .catch( error => console.log( error ));
        }
        
    },
    mounted(){

    }
});