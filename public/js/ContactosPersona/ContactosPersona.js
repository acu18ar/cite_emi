$(function() {
    var contactosPersonaTable = $('#contactosPersona-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexContactosPersona
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Persona', name: 'p.Persona', title: 'Persona' },
            { data: 'Telefono', name: 'e.Telefono', title: 'Teléfono' },
            { data: 'Celular', name: 'e.Celular', title: 'Celular' },
            { data: 'Correo', name: 'e.Correo', title: 'Correo Electrónico' },
            { data: 'SitioWeb', name: 'e.SitioWeb', title: 'Sitio Web' },
            { data: 'RedSocial', name: 'e.RedSocial', title: 'Red Social' },
            { data: 'CasillaPostal', name: 'e.CasillaPostal', title: 'Casilla Postal' },
            { data: 'Nick', name: 'e.Nick', title: 'Nick' },
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

    $('#contactosPersona-table tbody').on('click', 'tr', function () {
        var data = contactosPersonaTable.row( this ).data();
        vm.$options.methods.showContactosPersona(data.id);
    });
});

var vm = new Vue({
    el: '#contactosPersona-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        contactosPersona: {},
       
        personas: {},
       
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

          newContactosPersona () {
            vm.contactosPersona = {};
            $('#frm-contactosPersona').modal('show');
        },
        
      /*   showContactosPersona (id) {
            axios.post( urlShowContactosPersona, { id: id, contactosPersona: 6 })
                .then ( result => {
                        response = result.data;
                    vm.contactosPersona = response.data;
                    $('#view-contactosPersona').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        }, */
        showContactosPersona(id) {
            axios.get(urlShowContactosPersona, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.contactosPersona = response.data;
                    $('#view-contactosPersona').modal('show'); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editContactosPersona () {
            $('#frm-contactosPersona').modal('show');  
            $('#view-contactosPersona').modal('hide');
        },
        saveContactosPersona () {
            axios.post( urlSaveContactosPersona, vm.contactosPersona)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-contactosPersona').modal('hide');
                    var contactosPersonaTabla = $('#contactosPersona-table').DataTable();
                    contactosPersonaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteContactosPersona () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyContactosPersona, {id : vm.contactosPersona.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var contactosPersonaTabla = $('#contactosPersona-table').DataTable();
                            contactosPersonaTabla.draw();
                            $('#view-contactosPersona').modal('hide');
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
        
    } 
});