var implementosRequeridos = [];
var implementosPromesas = [];
var implementosDonacion = [];
var webService = 'http://localhost/cocina/server';

$(document).ready(function(){
    refrescar();
});

function refrescar() {
    obtenerPromesas();
    obtenerRequeridos();
    validarEstados();
    mostrarDonaciones();
}

function validarEstados() {
    implementosRequeridos.forEach(requerido => {
        var existe = false;
        implementosPromesas.forEach(promesa => {
            if(requerido.nombre == promesa.nombre){
                existe = true;
                if(requerido.cantidad - promesa.cantidad <= 0){
                    requerido.estado = "Meta Cumplida";
                }else {
                    requerido.estado = "Pendiente";
                }
            }
        });
        if (!existe) {
            requerido.estado = "Pendiente";
        }
    });
    mostrarPromesas();
    mostrarRequeridos();
}

function confirmar() {
    correoElectronicoDonante = document.getElementById('correoElectronicoDonante').value;
    nombreDonante = document.getElementById('nombreDonante').value;
    correoElectronicoDonante = document.getElementById('correoElectronicoDonante').value;
    if(nombreDonante == '' || correoElectronicoDonante == '' || correoElectronicoDonante.split("@").length == 1 || implementosDonacion.length == 0){
        swal({
            title: "Tenemos un problema",
            text: "Existen errores en los datos ingresados, o no hay elementos en el carrito de donación.",
            icon: "warning",
        })
        .then((r)=>{
            return;   
        });    
    }else {
        implementosDonacion.forEach(implemento => {
            cantidad = document.getElementById('cantidad'+implemento.id).value;
            donacion = {id: 1, 
                        nombreDonante: nombreDonante, 
                        correoElectronicoDonante: correoElectronicoDonante, 
                        idImplemento: implemento.id,
                        cantidad: cantidad
                       }
            urlToRequest = webService + '/donacion/crear';
            $.ajax({
                type: 'post',
                url: urlToRequest,
                data: JSON.stringify(donacion),
                async:false,
                success: function(respuesta){
                    
                }
            });
        });
        swal({
            title: "Donación Registrada",
            text: "Agradecemos tu generosidad.",
            icon: "success",
        })
        .then((r)=>{
            location.reload(true);
        });
    }
}

function cancelar() {
    implementosDonacion = [];
    refrescar();
}

function mostrarPromesas() {
    contenido = '';
    implementosPromesas.forEach(implemento => {
        contenido += "<tr><td>" + implemento.nombre + "</td><td>" + implemento.cantidad + "</td></tr>";
    });
    document.getElementById('promesasTableContenido').innerHTML = contenido;
}

function mostrarRequeridos() {
    contenido = '';
    implementosRequeridos.forEach(implemento => {
        contenido += "<tr><td>" + implemento.nombre + "</td><td>" + implemento.descripcion + "</td><td>" + implemento.cantidad + "</td><td>" + implemento.estado + "</td><td><button type=\"button\" class=\"btn btn-info\" onclick=\"donar(" + implemento.id + ")\">Donar</button>" + "</td></tr>";
    });
    document.getElementById('requerimosTableContenido').innerHTML = contenido;
}

function obtenerPromesas() {
    urlToRequest = webService + '/promesas/leer';
    $.ajax({
        type: 'post',
        url: urlToRequest,
        data: {},
        async:false,
        success: function(respuesta){
            if(respuesta == 0) {
                return;
            }
            implementosPromesas = respuesta;
        }
    });
}

function mostrarDonaciones() {
    contenido = '';
    implementosDonacion.forEach(implemento => {
        contenido += "<tr><td>" + implemento.nombre + "</td><td><input type=\"number\" class=\"form-control\" placeholder=\"Cantidad\" id=\"cantidad" + implemento.id + "\" value=\""+ implemento.cantidad +"\"></td></tr>";
    });
    document.getElementById('donacionesTableContenido').innerHTML = contenido;
}

function donar(numero) {
    implementosRequeridos.forEach(implemento => {
        if (implemento.id == numero){
            implementosDonacion.push(implemento);
            mostrarDonaciones();
            swal({
                title: "Elemento añadido",
                text: "Revisa el carrito de donaciones",
                icon: "success",
            })
            .then((r)=>{
                
            });
        }
    });
}

function obtenerRequeridos() {
    urlToRequest = webService + '/implemento/leer';
    $.ajax({
        type: 'post',
        url: urlToRequest,
        async:false,
        success: function(respuesta){
            if(respuesta == 0) {
                return;
            }
            implementosRequeridos = respuesta;
        }
    });
}