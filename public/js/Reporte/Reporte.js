
var vm = new Vue({
    el: '#reporte-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        excelMiembroRequest: {},
        excelMiembroGlobalRequest: {},
    },
    methods: {
        excelMiembro () {
            console.log(vm.excelMiembroRequest);
            if(vm.excelMiembroRequest.gestion&&vm.excelMiembroRequest.periodoGestion&&vm.excelMiembroRequest.personaId){

                axios.post( urlExcelMiembro, vm.excelMiembroRequest)
                .then ( result => {
                    response = result.data;
                    console.log(response);
                    var urlFile = response.data.url;
                    var x=new XMLHttpRequest();
                    x.open("GET", urlFile, true);
                    x.responseType = 'blob';
                    x.onload = e => {
                        download(x.response,"DefensasPorMiembro" + vm.excelMiembroRequest.personaId + '.xlsx', "application/xlsx" );
                        vm.isLoading = false;
                    }
                    x.send();
                    vm.isLoading = false;
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
            }else{

                toastr.error("Por favor verifique todos los campos", 'Error!');
            }
        },
        excelMiembroGlobal () {
            console.log(vm.excelMiembroGlobalRequest);
            if(vm.excelMiembroGlobalRequest.gestion&&vm.excelMiembroGlobalRequest.periodoGestion){
                axios.post( urlExcelMiembroGlobal, vm.excelMiembroGlobalRequest)
                .then ( result => {
                    response = result.data;
                    console.log(response);
                    var urlFile = response.data.url;
                    var x=new XMLHttpRequest();
                    x.open("GET", urlFile, true);
                    x.responseType = 'blob';
                    x.onload = e => {
                        download(x.response,"DefensasPorMiembro" + vm.excelMiembroGlobalRequest.gestion + '.xlsx', "application/xlsx" );
                        vm.isLoading = false;
                    }
                    x.send();
                    vm.isLoading = false;
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
            }else{

                toastr.error("Por favor verifique todos los campos", 'Error!');
            }
        },
        initSelectPersona() {
            $('#Persona').select2({
                placeholder: "Buscar Miembro del Tribunal...",
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
                    vm.excelMiembroRequest.personaId = e.params.data.id;
                }
            );
        },
    },
    mounted(){
        this.initSelectPersona();
    }
});