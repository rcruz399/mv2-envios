function GetLastAvailTag() {
    var ofi = document.getElementById("aoficina").value;
    var aw = document.getElementById("airwatch");
    var tag = document.getElementById("taggenerado");
    var cph= "CPH";
    var cel= "CEL";
    if(aw.checked){
        ofi= cel + ofi;
        //document.getElementById("deviceimei").disabled = true;
        document.getElementById("deviceimei").value = "PORASIGNAR";
        document.getElementById("deviceserie").disabled = true;
        document.getElementById("devicebrand").disabled = true;
        document.getElementById("devicemodel").disabled = true;

    }else {
        // El checkbox está desmarcado
    
        ofi= cph + ofi;
        document.getElementById("deviceimei").disabled = false;
        document.getElementById("deviceserie").disabled = false;
        document.getElementById("devicebrand").disabled = false;
      }
    $.ajax({
        type: "POST",
        url: 'includes/functions/calculatelasttag.php',
        data: { ofi: ofi },
        dataType: "json",
        success: function(data) {
            if (data[0].success == "YES") {
                var responseData = data[0].data;
                tag.value= responseData;
            } else { // Cambia "YES" a "NO"
                // Acceder a los datos o el JSON que regresa calculatelasttag.php
                var responseData = data[0].data;
                alert(responseData);
                console.log("no");
            }
        }
        
    });
}


function validarUsuario() {
    var usuario = document.getElementById("devuser").value;
    var botonAgregar = document.getElementById("btn-agregar");
    var newuser =document.getElementById("contenedor-modal");
    $.ajax({
        type: "POST",
        url: 'includes/functions/verificaDevuser.php',
        data: { devuser: usuario },
        dataType: "json",
        success: function (data) {
            if (data.usuario_existe === false) {

                alert("El usuario no existe");
               
                newuser.style.display = "block";
            } else {
                if (data.tag_asignado === true) {
                    alert("El usuario " + usuario + " ya tiene un teléfono mi rey");
                    botonAgregar.disabled = true;
                }else{
                    botonAgregar.disabled = false;
                }
                    // No hacer nada si el usuario existe pero no tiene tag asignado
                
            }
        },
        error: function () {
            alert("Hubo un error al realizar la solicitud AJAX");
        }
    });
}