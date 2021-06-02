var Presupuesto = {
	
	init : function(){
		Base.cargarDataTable("table_presupuesto_item",0,"desc");
		Base.cargarDataTable("table_presupuesto",0,"desc");
		Base.cargarDataTable("table_gasto_item");
		Base.cargarDataTable("table_gasto");
		
		Presupuesto.verificarAbierto();

	},	

	nuevo : function(){
		$("#span_panel_reg_presupuesto").click();
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/nuevo",			
			dataType : "json",
			success  : function(response){				
				$("#input_folio").val(response.folio);
				$("#btn_nuevo_presupuesto").prop("disabled",true);
				$("#tb_presupuesto").html(response.cargarGrilla);			
			}
		});
	},

	verificarAbierto : function(){
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/verificarAbierto",			
			dataType : "json",
			success  : function(response){									
				if(response.bo_abierto){
					$("#btn_nuevo_presupuesto").prop("disabled",true);
				}else{
					$("#btn_nuevo_presupuesto").prop("disabled",false);
				}				
			}
		});
	},

	revisar: function(folio){
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/get",
			data     : {folio:folio},
			dataType : "json",
			success  : function(response){	
				$("#input_folio").val(folio);
				$("#tb_presupuesto_item").html(response.cargarGrillaItems);
				$("#span_panel_reg_presupuesto").click();				
				if(response.cantidadItems > 0){
					$("#btn_finalizar").prop("disabled",false);
				}else{
					$("#btn_finalizar").prop("disabled",true);
				}						
			}
		});
	},

	modalEmail : function(folio){		
			VentanaModal.open(
								Base.getBaseUri() + "Presupuesto/modalEmail/?folio="+folio,
								"Enviar presupuesto por email",
								60,
								function(){
									Presupuesto.enviarEmail()
								},
								"",
								{ok:"fa fa-paper-plane",cancel:"fa fa-times"},
								{ok:"Enviar",cancel:"Cancelar"}
							 );	
	},

	enviarEmail : function(){

		var email_destinatario  = $("#input_email").val();
		var nombre_destinatario = $("#input_nombre_dest").val();
		var folio               = $("#input_folio_pre").val();
		var mensajeError        = "";

		if(nombre_destinatario === ""){
			mensajeError += "Debe ingresar el nombre de destinatario<br>";
		}

		if(email_destinatario === ""){
			mensajeError += "Debe ingresar el email de destinatario<br>";
		}

		if(mensajeError != ""){
			VentanaModal.error(mensajeError);
		}else{
			$.ajax({
				type     : "post",
				url      : Base.getBaseUri() + "Presupuesto/enviarEmail",
				data     : {folio:folio,email_destinatario:email_destinatario,nombre_destinatario:nombre_destinatario},
				dataType : "json",
				success  : function(response){	
					VentanaModal.success(response.mensaje,function(){
						VentanaModal.closeAll();
					});						
				}
			});			
		}
	},

	cargarSubCategorias : function(obj,id_subcategoria){
		if(obj.value  > 0){
			$.ajax({
				type     : "post",
				url      : Base.getBaseUri() + "Presupuesto/getListSubCategoriaByCategoria",
				data     : {id_categoria:obj.value},
				dataType : "json",
				success  : function(response){	
					$("#"+id_subcategoria).html("");
					$("<option/>",{"value":0,"html":"Seleccione"}).appendTo("#"+id_subcategoria);			
					if((response.listadoCategorias).length > 0){					
						$.each(response.listadoCategorias,function(){
							$("<option/>",{"value":this.id,"html":this.nombre}).appendTo("#"+id_subcategoria);
						});
					}
				}
			});			
		}else{
			$("#"+id_subcategoria).html("");
			$("<option/>",{"value":0,"html":"Seleccione"}).appendTo("#"+id_subcategoria);
			$("#input_monto_presupuesto_anterior").val(0);
		}
	},

	guardarItem : function(){

		var datos = $("#form_presupuesto_items").serializeArray();
		    datos.push({name:"nr_total_ingresos",value:$("#nr_total_ingresos").val()});

		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/guardarItem",
			data     : datos,
			dataType : "json",
			success  : function(response){	
				if(response.correcto){					
					//$("#nr_total").val(response.datos.resumen.total);
					$("#tb_presupuesto").html(response.cargarGrilla);
					$("#tb_presupuesto_item").html(response.cargarGrillaItems);
					$("#nr_total_ingresos").val(response.resumen.total_ingresos_mes);			
					$("#nr_total_presupuesto").val(response.resumen.total_presupuesto_mes);	
					$("#tb_presupuesto_item tr").each(function(){
					if(response.cantidadItems > 0){
						$("#btn_finalizar").prop("disabled",false);
					}
				});		
				}else{
					VentanaModal.info(response.mensaje);
				}
			}
		});
	},

	eliminarItem : function(id){
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/eliminarItem",
			data     : {folio:$("#input_folio").val(),id_item:id},
			dataType : "json",
			success  : function(response){				
				$("#tb_presupuesto").html(response.cargarGrilla);
				$("#tb_presupuesto_item").html(response.cargarGrillaItems);
				$("#nr_total_ingresos").val(response.resumen.total_ingresos_mes);			
				$("#nr_total_presupuesto").val(response.resumen.total_presupuesto_mes);
				if(response.cantidadItems == 0){
					$("#btn_finalizar").prop("disabled",true);
				}					
			}
		});
	},

	finalizar : function(){
		VentanaModal.confirm("¿Est&aacute; seguro que desea cerrar el presupuesto?",function(){
			$.ajax({
				type     : "post",
				url      : Base.getBaseUri() + "Presupuesto/finalizar",	
				data     : {folio:$("#input_folio").val()},		
				dataType : "json",
				success  : function(response){	
					if(response.correcto){
						$("#span_panel_list_presupuesto").click();	
						$("#form_presupuesto_items")[0].reset();
						$("#btn_nuevo_presupuesto").prop("disabled",false);				
						$("#btn_registrar").prop("disabled",true);				
						$("#btn_finalizar").prop("disabled",true);				
						$("#tb_presupuesto").html(response.cargarGrilla);
						$("#tb_presupuesto_item").html(response.cargarGrillaItems);			
					}
				}
			});
		});
		
	},

	getMontoMesAnteriorBySubCategoria : function(obj){
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/getMontoAnteriorBySubCategoria",	
			data     : {subcategoria:$(obj).val()},		
			dataType : "json",
			success  : function(response){	
				
				$("#input_monto_presupuesto_anterior").val(response.montoAnterior);					
				
			}
		});
	},

	get : function(folio){
		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/get",
			data     : {folio:folio,tipo:2},
			dataType : "json",
			success  : function(response){				
				$("#tb_gastos_item").html(response.cargarGrillaItems);									
				$("#tb_gastos").html(response.cargarGrillaGastos);									
			}
		});
	},

	guardarGastoItem : function(id_item){

		var folio = $("#input_folio_gastos").val();
		var monto = $("#gasto_id_"+id_item).val();
		
		if(monto == ""){
			VentanaModal.info("Debe ingresar un valor en el campo monto");
			return false;
		}

		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Presupuesto/guardarGastoItem",
			data     : {folio:folio,id_presupuesto_item:id_item,monto:monto},
			dataType : "json",
			success  : function(response){				
				$("#tb_gastos_item").html(response.cargarGrillaItems);	
				$("#tb_gastos").html(response.cargarGrillaGastos);
				$("#nr_total_presupuesto").val(response.resumen.total_presupuesto_mes);								
			}
		});
	}

};

$(document).ready(Presupuesto.init);

