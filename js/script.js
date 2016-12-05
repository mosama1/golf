

// function rotate() {
//   var width = $(window).width();
//
//   if (width <= 400) {
//     $('body .rotate').fadeIn();
//   }else {
//     $('body .rotate').fadeOut();
//   }
// }
// $(document).ready(function(){
//   rotate();
// });
// $(window).resize(function(){
//   rotate();
// });

$(".carousel").carousel({
    interval: 5000
});
$(document).ready(function() {
    $("#ir-nosotros,#ir-index,#ir-servicios,#ir-contacto,#ir-reservar").click(function() {
        $("#cortina1").slideDown(400);
        $("#cortina2").slideDown(400);
    });
});
$(window).load(function() {
    $("#preloader1").delay(300).slideUp(400);
    $("#preloader2").delay(300).slideUp(400);
});


$(window, "#contacto,#nosotros,#reservar").scroll(function(a) {
    height = $(a.target).scrollTop();
    if (height > 1 && height < 20000) {
        $("nav").addClass("black").removeClass("normal");
        $("nav img").addClass("img-reducida").removeClass("img-normal");
    } else {
        $("nav").removeClass("black").addClass("normal");
        $("nav img").removeClass("img-reducida").addClass("img-normal");
    }
});



$(document).ready(function() {
    var b = new google.maps.LatLng(10.5052301, -66.9027257);
    var f = {
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: false,
        zoom: 17,
        center: b,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var e = document.getElementById("mapa");
    var d = new google.maps.Map(e, f);
    var a = new google.maps.Marker({
        position: new google.maps.LatLng(10.5040866, -66.9025098),
        map: d
    });
    var c = new google.maps.InfoWindow({
        content: "<h3>Caracas, Venezuela</h3></br> <p><b>Dirección:</b>  Esquina de puente Anauco, Edf. Camara de Industrial, Piso 7, Ofc 7A y 7B, Urb. La Candelaria</p><p><b>Telefono: </b> +58 212 0000000</p>",
        maxWidth: 300
    });
    c.open(d, a);
});


document.getElementById("ir-index").onclick = function() {
    var a = this.href;
    var b = function() {
        window.location.href = a;
    };
    setTimeout(b, 400);
    return false;
};
document.getElementById("ir-nosotros").onclick = function() {
    var a = this.href;
    var b = function() {
        window.location.href = a;
    };
    setTimeout(b, 400);
    return false;
};
document.getElementById("ir-servicios").onclick = function() {
    var a = this.href;
    var b = function() {
        window.location.href = a;
    };
    setTimeout(b, 400);
    return false;
};
document.getElementById("ir-contacto").onclick = function() {
    var a = this.href;
    var b = function() {
        window.location.href = a;
    };
    setTimeout(b, 400);
    return false;
};
document.getElementById("ir-reservar").onclick = function() {
    var a = this.href;
    var b = function() {
        window.location.href = a
    };
    setTimeout(b, 400);
    return false;
};










/*------------------*/

/*CONTRUCTOR XMLHttpRequest*/
function ConstructorXMLHttpRequest()
{
    if(window.XMLHttpRequest) /*Vemos si el objeto window posee el metodo XMLHttpRequest(Navegadores como Mozilla y Safari).*/
    {
        return new XMLHttpRequest(); //Si lo tiene, crearemos el objeto
    }

    else if(window.ActiveXObject) /*Sino tenia el metodo anterior,deberia ser el Internet Exp.*/
    {
        var versionesObj = new Array(
                                    'Msxml2.XMLHTTP.5.0',
                                    'Msxml2.XMLHTTP.4.0',
                                    'Msxml2.XMLHTTP.3.0',
                                    'Msxml2.XMLHTTP',
                                    'Microsoft.XMLHTTP');

        for (var i = 0; i < versionesObj.length; i++)
        {
            try
                {
                    return new ActiveXObject(versionesObj[i]);
                }
                catch (errorControlado)
                {

                }
        }
    }
    throw new Error("No se pudo crear el objeto XMLHttpRequest");
}


function Login() {
   var user = document.getElementById('user').value;
   var pass = document.getElementById('pass').value;


   if (user != '' && pass != '') {
     var cadena = "user=" + user + "&pass=" + pass;


     var peticion = null;
     peticion = ConstructorXMLHttpRequest();

     if (peticion) {
         peticion.open('post', "./login.php", true);
         peticion.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //  peticion.setRequestHeader("Content-Length", cadena.length);
        //  peticion.setRequestHeader("Connection","Close");
         peticion.send(cadena);


         peticion.onreadystatechange = function(){
           console.log(peticion.responseText);
          //  console.log(peticion.responseText);
           if (peticion.readyState == 4 && peticion.status == 200) {
             if (parseInt(peticion.responseText) == 1) {
               result = '<div class="alert alert-dismissible alert-danger">';
               result += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
               result += '<strong>Su Mensaje se ha enviado correctamete</strong>';
               result += '</div>';
               document.getElementById('mensaje-alerta').innerHTML = result;
             }
           }else if (peticion.readyState != 4){
             result = '<div class="alert alert-dismissible alert-danger">';
             result += '    <strong>Procesando...</strong>s';
             result += '  </div>';
             document.getElementById('mensaje-alerta').innerHTML = result;

           }

         }
     }


   }else {
     result = '<div class="alert alert-dismissible alert-danger">';
     result += '    <strong>Error: </strong>Todos los campos deben estar llenos';
     result += '  </div>';
     document.getElementById('mensaje-alerta').innerHTML = result;

   }


}

$("#enviar").click(function(){
  Login();
});
function formatoNumero(numero, decimales, separadorDecimal, separadorMiles) {
    var partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
    }
    if (typeof separadorDecimal==="undefined") {
        separadorDecimal = ",";
    }
    if (typeof separadorMiles==="undefined") {
        separadorMiles = "";
    }

    // Redondeamos
    if ( !isNaN(parseInt(decimales)) ) {
        if (decimales >= 0) {
            numero = numero.toFixed(decimales);
        } else {
            numero = (
                Math.round(numero / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
            ).toFixed();
        }
    } else {
        numero = numero.toString();
    }

    // Damos formato
    partes = numero.split(".", 2);
    array = partes[0].split("");
    for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
        array.splice(i, 0, separadorMiles);
    }
    numero = array.join("");

    if (partes.length>1) {
        numero += separadorDecimal + partes[1];
    }

    return numero;
}

function subTotal() {
  var sub_total = 0;
  $('#muestra .muestra_').each(function(){
    $('table tbody .precio', this).each(function(){
      sub_total = sub_total+parseInt($(this).html());
    });
  });

  return sub_total;
}
