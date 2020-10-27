var vm = new Vue({
    el: '#dashboard-app',
    data: {
        //accounting: accounting,
        //auth: auth,
        errorBag: {},
        isLoading: false,
        inscritos: {},
        unidadAcademicas: {},
        unidadAcademica: null,
        backgrounds: ['rgba(255, 99, 132, 0.2)','rgba(54, 162, 235, 0.2)','rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)' ],
        borders: ['rgba(255, 99, 132, 1)','rgba(54, 162, 235, 1)','rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)' ],
    },
    computed: {
        totalInscritos () {
            var suma = 0;
            if(this.inscritos.length > 0) {
                this.inscritos.forEach(e => {
                    suma += e.Cantidad;
                });
            } 
            return suma;    
        }
    },
    methods: {
        getUnidadAcademica () {
            axios.get( urlListUnidadAcademica )
                .then( result => { vm.unidadAcademicas = result.data.data;})
                .catch( error => console.log( error ));
        },
        initDrawUnidadAcademica () {
            var data = {};
            $('#canvasUA').remove();
            $('#uaContainer').append('<canvas id="canvasUA" height="200"></canvas>');
            axios.get( urlInscritos , { params: { UnidadAcademica: this.unidadAcademica , Dimension: 'UnidadAcademica'}})
            .then( result => {
                data = result.data.data;
                vm.inscritos = data;
                var ctx = document.getElementById('canvasUA').getContext('2d');
                myBar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.values(data).map(e => e.UnidadAcademica),
                        datasets: [{
                            label: 'Cantidad de Inscritos',
                            data: Object.values(data).map((e, index) => e.Cantidad),
                            backgroundColor: vm.backgrounds[4],
                            borderColor: vm.borders[4],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Inscritos por UnidadA Académica'
                        }
                    }
                });
            })
            .catch( error => {
                console.log( error );
            });
        },
        initDrawEspecialidad () {
            var data = {};
            $('#canvasEspecialidad').remove();
            $('#especialidadContainer').append('<canvas id="canvasEspecialidad" height="100"></canvas>');
            axios.get( urlInscritos , { params: { UnidadAcademica: this.unidadAcademica , Dimension: 'Especialidad'}})
            .then( result => {
                data = result.data.data;
                var ctx = document.getElementById('canvasEspecialidad').getContext('2d');
                //ctx.clear();
                //var myBar = null;
                myBar = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: Object.values(data).map(e => e.Especialidad),
                        datasets: [{
                            label: 'Por Especialidad',
                            data: Object.values(data).map((e, index) => e.Cantidad),
                            backgroundColor: vm.backgrounds[1],
                            borderColor: vm.borders[1],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Inscritos por Especialidad'
                        }
                    }
                });
                myBar.update();

            })
            .catch( error => {
                console.log( error );
            });
        },
        initDrawEstado () {
            var data = {};
            $('#canvasEstado').remove();
            $('#estadoContainer').append('<canvas id="canvasEstado" height="200"></canvas>');
            axios.get( urlInscritos , { params: { UnidadAcademica: this.unidadAcademica , Dimension: 'Estado'}})
            .then( result => {
                data = result.data.data;
                var ctx = document.getElementById('canvasEstado').getContext('2d');
                myBar = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.values(data).map(e => e.Estado),
                        datasets: [{
                            label: 'Por Estado',
                            data: Object.values(data).map((e, index) => e.Cantidad),
                            backgroundColor: Object.values(data).map((e, index) => vm.backgrounds[index]),
                            borderColor: Object.values(data).map((e, index) => vm.borders[index]),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Inscritos por Estado'
                        }
                    }
                });
                myBar.update();
            })
            .catch( error => {
                console.log( error );
            });
        },
        initDrawFecha () {
            var data = {};
            $('#canvasFecha').remove();
            $('#fechaContainer').append('<canvas id="canvasFecha" height="50"></canvas>');
            axios.get( urlInscritos , { params: { UnidadAcademica: this.unidadAcademica , Dimension: 'Fecha'}})
            .then( result => {
                data = result.data.data;
                var ctx = document.getElementById('canvasFecha').getContext('2d');
                myBar = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Object.values(data).map(e => e.Fecha),
                        datasets: [{
                            label: 'Por Fecha',
                            data: Object.values(data).map((e, index) => e.Cantidad),
                            backgroundColor: vm.backgrounds[4],
                            borderColor:  vm.backgrounds[4],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Inscritos por Fecha'
                        }
                    }
                });
            })
            .catch( error => {
                console.log( error );
            });
        },
        initDraw() {
            this.getUnidadAcademica();
            this.initDrawUnidadAcademica();
            this.initDrawEspecialidad();
            this.initDrawEstado();
            this.initDrawFecha();
        }
    },
    mounted () {
        this.getUnidadAcademica();
        this.initDraw();
    }
});
