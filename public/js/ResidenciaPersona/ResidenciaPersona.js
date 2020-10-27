
$(function() {
   var residenciaPersonaTable = $('#residenciaPersona-table').DataTable({
        processing: true,
        order: [[1, 'asc']],
        serverSide: true,
        ajax: {
            url: urlIndexResidenciaPersona
        },
        deferRender: true,
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false , visible: false},
            { data: 'Persona', name: 'p.Persona', title: 'Persona' },
            { data: 'DepDocId', name: 'na.DepDocId', title: 'Ciudad' },
            { data: 'Municipio', name: 'm.Municipio', title: 'Municipio' },
            { data: 'Zona', name: 'e.Zona', title: 'Zona' },
            { data: 'ResidenciaPersona', name: 'e.ResidenciaPersona', title: 'Dirección ' },
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

    $('#residenciaPersona-table tbody').on('click', 'tr', function () {
        var data = residenciaPersonaTable.row( this ).data();
        vm.$options.methods.showResidenciaPersona(data.id);
    });

});
//********tablas dinamicas para la seleccion segun el valor*******//
$(function() {
$('#DepDocId').on('change', onSelectProjectChange);
//alert('Script muestra');
});

function onSelectProjectChange() {
    var project_id = $(this).val();
    //alert (proyect_id);
    //ajax
    if(! project_id){
    $('#Municipio').html('<option value="">Selecione</option>');
    return;
    }
            $.get('/api/DepDocId/'+project_id+'/Municipio', function (data){
            var html_select = '<option value="">Selecione</option>';
            for (var i=0; i<data.length; ++i)
            //console.log(data[i]);
            html_select += '<option value="'+data[i].id+'" >'+data[i].Municipio+'</option>';
            //console.log(html_select);
            $('#Municipio').html(html_select);
            });
};
//********tablas dinamicas para la seleccion segun el valor*******//
var vm = new Vue({
    el: '#residenciaPersona-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        //consultas: {},
        residenciaPersona: {},
        depDocIds: {},
        personas: {},
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

        newResidenciaPersona () {
            vm.residenciaPersona = {};
            $('#frm-residenciaPersona').modal('show');
        },
        
      /*   showResidenciaPersona (id) {
            axios.post( urlShowResidenciaPersona, { id: id, residenciaPersona: 6 })
                .then ( result => {
                        response = result.data;
                    vm.residenciaPersona = response.data;
                    $('#view-residenciaPersona').modal('show');
                })
                .catch ( error => {
                    console.log( error );
                });
        }, */
        showResidenciaPersona(id) {
            axios.get(urlShowResidenciaPersona, { params: { id: id }})
                .then(result => {
                    response = result.data;
                    vm.residenciaPersona = response.data;
                    $('#view-residenciaPersona').modal('show'); 
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editResidenciaPersona () {
            $('#frm-residenciaPersona').modal('show');  
            $('#view-residenciaPersona').modal('hide');
        },
        saveResidenciaPersona () {
            axios.post( urlSaveResidenciaPersona, vm.residenciaPersona)
                .then ( result => {
                    response = result.data;
                    toastr.success(response.msg, 'Correcto!');
                    //$('#view-consulta').modal('show');
                    $('#frm-residenciaPersona').modal('hide');
                    var residenciaPersonaTabla = $('#residenciaPersona-table').DataTable();
                    residenciaPersonaTabla.draw();
                })
                .catch( error => {
                    vm.errorBag = error.data.errors;
                });
        },
        deleteResidenciaPersona () {
            
            swal({
                title: "Estas seguro que deseas eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    axios.post( urlDestroyResidenciaPersona, {id : vm.residenciaPersona.id} )
                        .then( result => {
                            response = result.data;
                            toastr.success(response.msg, 'Correcto!');
                            var residenciaPersonaTabla = $('#residenciaPersona-table').DataTable();
                            residenciaPersonaTabla.draw();
                            $('#view-residenciaPersona').modal('hide');
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
        this.getPersonas();
        this.getMunicipios();
    } 

 
});
