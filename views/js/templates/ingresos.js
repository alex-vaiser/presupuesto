var Ingreso = {
	
	init:function(){
		Base.cargarDataTable("table_ingresos",1,"desc");
	},

	guardar: function(){
		var datos = $("#form_ingresos").serializeArray();

		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Ingreso/guardar",
			data     : datos,
			dataType : "json",
			success  : function(response){				
				if(response.correcto){
					VentanaModal.success(response.mensaje,function(){
						$("#nr_total_ingresos").val(response.datos.resumen.total);
						$("#tb_ingresos").html(response.cargarGrilla);						
					});
				}else{
					VentanaModal.info(response.mensaje);
				}
			}
		});
	},
	
};
$(document).ready(Ingreso.init);