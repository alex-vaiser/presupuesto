var Base = {
	
	ERROR_GENERAL : "Problemas de comunicaci&oacute;n con el servidor. Por favor comuń&iacute;quese con soporte",

	getBaseUri :function(){
		url = (window.location).toString();
		url = url.split('/');
	    url = url.splice(0,4);		
		url = url.join('/') + '/';

		return (url);
	},
	desplegarMensajeTemporal : function(mensaje, tiempo = 4){
		if(mensaje !== ""){
			$(".div_mensaje_temporal").html(mensaje);
			if($(".div_mensaje_temporal").hasClass("hide")){
				$(".div_mensaje_temporal").fadeIn("fast",function(){					
					t  = tiempo * 1000;
					st = setTimeout(function(){
							$(".div_mensaje_temporal").fadeOut("slow")
							clearTimeout(st);
						},t);
				})
			}
		}
	},
	validarEmail :function(email){
    	var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    	return regex.test(email) ? true : false;
	},
	cargarDataTable : function(id,ordenIndice=0,ordenTipo="asc"){		
		
		$("#"+id).DataTable({
				destroy : true,
				order   : [[ordenIndice,ordenTipo]],
			    language: {
			        "decimal": "",
			        "emptyTable": "No hay información",
			        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			        "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
			        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
			        "infoPostFix": "",
			        "thousands": ",",
			        "lengthMenu": "Mostrar _MENU_ Entradas",
			        "loadingRecords": "Cargando...",
			        "processing": "Procesando...",
			        "search": "Buscar:",
			        "zeroRecords": "Sin resultados encontrados",
			        "paginate": {
			            "first": "Primero",
			            "last": "Ultimo",
			            "next": "Siguiente",
			            "previous": "Anterior"
			        },
			       
			    }
		});
	},
	mostrarOcultarPanel : function(obj,cerrar_otros=0){
		id_panel = $(obj).data("panel");

		if(cerrar_otros){
			$(".panel").each(function(){
				if($(this).prop("id") != id_panel){					
					if($(this).is(":visible")){						
						$(this).parent().children().eq(0).children("span:eq(1)").children("span").html("MOSTRAR");
						$(this).parent().children().eq(0).children("span:eq(1)").children("svg").removeClass("fa-chevron-up").addClass("fa-chevron-down");
						$(this).slideUp("medium");
					}
				}else{
					if($(this).is(":visible")){
						$(obj).children("span").html("MOSTRAR");
						$(obj).children("svg").removeClass("fa-chevron-up").addClass("fa-chevron-down");
						$(this).slideUp("medium");
					}else{
						$(obj).children("span").html("OCULTAR");
						$(obj).children("svg").removeClass("fa-chevron-down").addClass("fa-chevron-up");
						$(this).slideDown("medium");
					}
				}								
			});
		}else{
			if($("#"+id_panel).is(":visible")){			
				$(obj).children("span").html("MOSTRAR");
				$(obj).children("svg").removeClass("fa-chevron-up").addClass("fa-chevron-down");
				$("#"+id_panel).slideUp("medium");
			}else{
				$(obj).children("span").html("OCULTAR");
				$(obj).children("svg").removeClass("fa-chevron-down").addClass("fa-chevron-up");
				$("#"+id_panel).slideDown("medium");
			}
		}
	},

	desbloquearBloquear : function(obj,btnId){
		if(obj.value != ""){
			$("#"+btnId).prop("disabled",false);
		}else{
			$("#"+btnId).prop("disabled",true);
		}
	},

};

$(document).ready(function(){	
	Base.getBaseUri();	

	


	//Control menu en dispositivos moviles

	$("#chk_menu").on("click",function(){
		if($(this).is(":not(:checked)")){
			$(this).prop("checked",false);
		}
	});

	$('.flexslider').flexslider({
	    animation: "slide",
	    rtl: true
	});
})