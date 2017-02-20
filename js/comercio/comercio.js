$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

//Variable GLobal para identificar un producto en el carrito
var idCarrito=0;

function agregarACarrito(cod) {
      idCarrito=idCarrito+1;
      var nombre=$("#"+cod+"  #nombre_producto").text();
      var precio=$("#"+cod+"  #precio_producto").text();
      var numProd=$("#ventanaCarrito a #totalProductos").text();
      numProd=parseInt(numProd)+1;
      numProd=String(numProd)
      $("#ventanaCarrito a #totalProductos").text(numProd);

      //Si Existe el carrito de compra, es decir, si ya se ha agregado algun producto
      if ( $("#carritoCompra").length > 0 ) {
        $('ul#carritoCompra').prepend("<li id="+idCarrito+" class='producCarrito'><div class='row'><div class='col-xs-3'><img class='img-producto-carrito' src='../img/comercio/productos/"+cod+".jpg'></div><div class='col-xs-4'><p class='text-carrito'>"+nombre+"</p></div><div class='col-xs-3'><p id='precio_"+idCarrito+"' class='text-carrito'>"+precio+"</p></div><div class='col-xs-1'><p class='text-carrito' onclick='eliminarDeCarrito("+idCarrito+")'><i class='fa fa-times fa-fw'></i></p></div></div></li>")
        precio=precio.replace(" Bs.","");
        var monto=$("#totalPagar").text();
        monto=parseInt(monto)+parseInt(precio);
        monto=String(monto)
        $("#totalPagar").text(monto);
      }
      //Si NO existe el carrito de compra, es decir, si el carro esta vacio
      else{
        $('li#ventanaCarrito').append("<ul id='carritoCompra' class='dropdown-menu dropdown-carrito'><li id="+idCarrito+" class='producCarrito'><div class='row'><div class='col-xs-3'><img class='img-producto-carrito' src='../img/comercio/productos/"+cod+".jpg'></div><div class='col-xs-4'><p class='text-carrito'>"+nombre+"</p></div><div class='col-xs-3'><p id='precio_"+idCarrito+"' class='text-carrito'>"+precio+"</p></div><div class='col-xs-1'><p class='text-carrito' onclick='eliminarDeCarrito("+idCarrito+")'><i class='fa fa-times fa-fw'></i></p></div></div></li></ul>");
        precio=precio.replace(" Bs.","");
        $('ul#carritoCompra').append("<li class='opcionesCarrito'><div class='row'><div class='col-xs-4'><input type='button'  value='Ver Carrito' name='btn_ver_carrito' onclick='verCarrito()'' class='btn btn-carrito btn-success btn-lg col-lg-10 col-lg-offset-1'/></div><div class='col-xs-4'><input type='button'  value='Comprar' name='btn_comprar' onclick='comprarCarrito()' class='btn btn-carrito btn-success btn-lg col-lg-10 col-lg-offset-1'/></div><div class='col-xs-4'><p class='text-carrito-2'>TOTAL: Bs.<b id='totalPagar'>"+precio+"</b></p></div></div></li>");
      }

};

function eliminarDeCarrito(idProd){
      var numProd=$("#ventanaCarrito a #totalProductos").text();
      numProd=parseInt(numProd)-1;
      numProd=String(numProd)
      $("#ventanaCarrito a #totalProductos").text(numProd);

      //Para actualizar el monto total a pagar del carrito
      var precio=$("#precio_"+idProd+"").text();
      precio=precio.replace(" Bs.","");
      var monto=$("#totalPagar").text();
      monto=parseInt(monto)-parseInt(precio);
      monto=String(monto)
      $("#totalPagar").text(monto);

      //Elimino producto del carrito
      $("#"+idProd+"").remove();

      //Para saber cuantos productos quedan en el carrito
      var cantProd=$("#carritoCompra li").size();
      
      //Si el carrito queda vacio lo elimino
      if(cantProd-1==0){
         $("#carritoCompra").remove();
      }
}

function comprarCarrito(){
      var monto_total=$("#totalPagar").text();
      var form = $("#form_boton_pago"); 
      var monto_form = $("[name='monto_total']", form).val(monto_total);
      document.form_boton_pago.submit();
}