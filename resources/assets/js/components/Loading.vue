<template>
     <div class="login-box-body dimension">
         <br><br><br><br><br><br><br><br><br><br><br>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-4 col-xs-4 col-lg-4">
                    <img src="http://inscripcion.servicios.emi.edu.bo/images/emi_logo.png" alt="EMI" class="logo">
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3 col-xs-3 col-lg-3">
                    <moon-loader :color="color" :size="size"></moon-loader>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['isLoading'],
        data: function() {
            return {
                color: '#52B87F',
                size: '48px'
            }
        }
    }
</script>
<style scopped>
    .dimension{ 
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height:2305px !important; /*change to YOUR page height*/
        background-color: #000;
        filter:alpha(opacity=50);
        -moz-opacity:0.8;
        -khtml-opacity: 0.8;
        opacity: 0.8;
        z-index: 998;
    }

    .logo {
        width: 55%;
    }
</style>

