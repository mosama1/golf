

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
  setTimeout(function(){
    $('.preload').fadeOut();
  },500);

});


// function preload() {
//   var preload = setInterval(function(){ cargando(); }, 150);
//
//   var i = 0;
//   function cargando() {
//     i++;
//     $('.preload ul li:nth-child('+i+')').addClass('active');
//
//     if (i > $('.preload ul li').length + 3) {
//       i=0;
//       $('.preload ul li').removeClass('active');
//     }
//     console.log(i);
//     // clearInterval(preload);
//   }
// }
// preload();
//






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
