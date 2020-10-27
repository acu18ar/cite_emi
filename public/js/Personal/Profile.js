var vm = new Vue({
    el: '#profile-app',
    data: {
        //accounting: accounting,
        moment: moment,
        auth: auth,
        errorBag: {},
        isLoading: false,
        isLoadingFile: false,
        personal: {},
    },
    methods: {
        loadFile(input) {
            vm.isLoadingFile = true;
            var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(input.files[0]);
                    var data = new FormData();
                    data.append('File', input.files[0]);
                    axios.post(urlUploadFile, data)
                        .then( result => {
                            if (result.data.success) {
                                toastr.info(result.data.msg, 'Correcto!');
                                vm.personal.Fotografia = result.data.data;
                                vm.savePersonal();
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
        getPersonal() {
            axios.get(urlShowPersonal, { params: { id: this.auth.id }})
                .then(result => {
                    response = result.data;
                    this.personal = response.data;
                    //$('#view-persona').modal('show');
                })
                .catch(error => {
                    console.log(error);
                });
        },
        cambiopassword(id) {
            $('#view-personal').modal('hide');
            /* $('#view-password').modal('show'); */
        },
    /*     changePassword() {
            vm.password.Persona = vm.persona.id;
            axios.post( urlChangePasswordPersona, vm.password)
                .then( result => {
                    response = result.data;
                    if ( response.success ) {
                        toastr.success(response.msg, 'Correcto!');
                        $('#view-password').modal('hide');
                        $('#view-persona').modal('show');
                    } else {
                        toastr.error(response.msg, 'Oops!');
                    }
                })
                .catch( error => {
                    console.log( error );
                    toastr.error('Error al guardar el registro', 'Oops!');
                    vm.errorBag = error.data.errors;
                })
        },
        */
        savePersonal() {
            axios.post(urlSavePersonal, vm.personal)
                .then(result => {
                    response = result.data;
                    vm.personal = response.data;
                    toastr.success(response.msg, 'Correcto!');
                })
                .catch(error => {
                    console.log(error);
                    toastr.error('Error al guardar el registro', 'Oops!');
                    vm.errorBag = error.data.errors;
                });
        },
     
    },

    mounted () {
        this.getPersonal();
    } 
});