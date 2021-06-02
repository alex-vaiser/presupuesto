var Cotizacion = {
	
	objForm   : {
					"input_folio"           : "",
					"input_nombres"  		: "",
					"input_apellidos" 		: "",
					"input_email"           : [],
					"checkbox_email"        : [],
					"input_fono"            : [],
					"input_lugar"     		: "",
					"input_nro_personas"    : "",
					"input_fecha_evento"    : "",
					"input_hora_evento"     : "",
					"select_origen"         : "",
					"select_tipo_servicio"  : "",
					"checkbox_servicios"    : [],
					"input_monto_servicios" : [],
					"input_monto_total"     : ""
				},

	precargado_editar : false,
	
	init : function(){		
		$("#input_fecha_evento").datepicker({
			changeMonth: true,
        	changeYear: true,
        	minDate : new Date()
		});

		$("#input_hora_evento").timepicker({
			interval   : 30,
			timeFormat : "h:mm p",			
			startTime  : "18:00",
			minTime    : "18:00",
			maxTime    : "21:00",
			dynamic    : false,
			zindex     : 10000,
			change     : function(){				
				Cotizacion.objForm[$("#input_hora_evento").prop("id")] = $("#input_hora_evento").val();
			}
		});

		$("#form_cotizacion_manual input,#form_cotizacion_manual select").on("change",function(){
			switch(this.id){
				case "input_email":
					Cotizacion.agregarEmail();
					break;
				case "input_fono":
					Cotizacion.agregarFono();
					break;			   								
				default:				
					Cotizacion.objForm[this.id] = this.value;
			}
			Base.desplegarMensajeTemporal("Datos temporalmente guardados",2);
		});		
	},
	solicitud : function(obj){
		
		var nro_folio = $(obj).data("folio");

		VentanaModal.openViews(
			Base.getBaseUri() + "Cotizacion/solicitud",
			"Detalle Cotizaci&oacute;n N&deg; " + nro_folio,
			80
		);
	},
	agregar : function(){
		
		if(this.precargado_editar){

			this.limpiarObjForm();
			this.precargado_editar = false;

		}

		VentanaModal.openViews(
			Base.getBaseUri()+'Cotizacion/agregarManual',
			"Cotizaci&oacute;n manual",
			50,
			function(){
				setTimeout(function(){								
								Cotizacion.cargarFormulario();
							},500);
				
			}
		);
	},
	editar : function(obj){
		
		var folio_nro = $(obj).data("folio");

		this.precargado_editar = true;

		VentanaModal.openViews(
			Base.getBaseUri()+'Cotizacion/editarManual/?_folio_nro='+folio_nro,
			"Cotizaci&oacute;n manual",
			50,
			function(){
				setTimeout(function(){								
								Cotizacion.cargarFormulario();
							},500);
				
			}
		);
	},
	agregarEmail : function(){
		let email  = $("#input_email");		 
		let arr    = email.val().split(',').filter(element => element != "" && Base.validarEmail(element));		
		
		if(email.val() == ''){
			VentanaModal.info("El campo Email est&aacute; vac&iacute;o");
			return false;
		}

		$.each(arr,function(idx,valor){
			if(Cotizacion.objForm["input_email"].indexOf(valor) === -1){
				Cotizacion.objForm["checkbox_email"].push(1);
				Cotizacion.objForm["input_email"].push(valor);
			}
		});

		this.cargarEmails();
		email.val('');	

	},
	agregarFono : function(){
		let fono  = $("#input_fono");		 
		let arr    = fono.val().split(',').filter(element => element != "");		
		
		if(fono.val() == ''){
			VentanaModal.info("El campo Tel&eacute;fono est&aacute; vac&iacute;o");
			return false;
		}

		$.each(arr,function(idx,valor){
			if(Cotizacion.objForm["input_fono"].indexOf(valor) === -1){
				Cotizacion.objForm["input_fono"].push(valor);
			}
		});

		this.cargarFonos();
		fono.val('');	

	},
	eliminarEmail : function(elemento){
		let ele = $(elemento).data("elemento").toString();
		let idx = this.objForm["input_email"].indexOf(ele);

		if(idx !== -1){
			delete(this.objForm["input_email"][idx]);
			delete(this.objForm["checkbox_email"][idx]);
		}

		this.cargarEmails();
	},
	eliminarFono : function(elemento){
		let ele = $(elemento).data("elemento").toString();
		let idx = this.objForm["input_fono"].indexOf(ele);		
		
		if(idx !== -1){
			delete(this.objForm["input_fono"][idx]);
		}

		this.cargarFonos();
	},
	cargarEmails : function(){
		if((this.objForm["input_email"]).length > 0){			
			$("#ul_emails").html('');
			(this.objForm["input_email"]).forEach(function(valor,index){
				valor = "<input type='checkbox' id='checkbox_email_envio_"+index+"'>&nbsp;<label for='checkbox_email_envio_"+index+"'>" + valor + "</label>&nbsp;<span style='color:#F00;cursor:pointer' onclick='Cotizacion.eliminarEmail(this)' data-elemento='"+valor+"'><i class='fa fa-times-circle'></i></span>";
				$("#ul_emails").append($("<li/>",{'html':valor}));

				if(Cotizacion.objForm["checkbox_email"][index]){
					$("#checkbox_email_envio_"+index).prop("checked",true);
				}else{
					$("#checkbox_email_envio_"+index).prop("checked",false);
				}

				$("#checkbox_email_envio_"+index).off("click");				
				$("#checkbox_email_envio_"+index).on("click",function(){
					
					if(Cotizacion.objForm["checkbox_email"][index]){
						Cotizacion.objForm["checkbox_email"][index] = 0;
					}else{
						Cotizacion.objForm["checkbox_email"][index] = 1;
					}
					
					Cotizacion.cargarEmails();

				});				
			});					
		}
		if(Object.keys(this.objForm["input_email"]).length == 0 && Object.keys(this.objForm["input_fono"]).length == 0){
			if($("#div_contactos").is(":visible")){
				$("#div_contactos").slideUp("medium");
			}
		}else{
			if(!$("#div_contactos").is(":visible")){
				$("#div_contactos").slideDown("medium");
			}

			if(Object.keys(this.objForm["input_email"]).length > 0){
				$("#div_emails").slideDown("medium");
			}else{
				$("#div_emails").slideUp("medium");
			}
		}
	},
	cargarFonos : function(){
		if((this.objForm["input_fono"]).length > 0){			
			$("#ul_fonos").html('');
			(this.objForm["input_fono"]).forEach(function(valor,index){
				valor = valor + "&nbsp;<span style='color:#F00;cursor:pointer' onclick='Cotizacion.eliminarFono(this)' data-elemento='"+valor+"'><i class='fa fa-times-circle'></i></span>";
				$("#ul_fonos").append($("<li/>",{'html':valor}));
			});					
		}		
		if(Object.keys(this.objForm["input_email"]).length == 0 && Object.keys(this.objForm["input_fono"]).length == 0){
			if($("#div_contactos").is(":visible")){
				$("#div_contactos").slideUp("medium");
			}
		}else{
			if(!$("#div_contactos").is(":visible")){
				$("#div_contactos").slideDown("medium");
			}

			if(Object.keys(this.objForm["input_fono"]).length > 0){
				$("#div_telefonos").slideDown("medium");
			}else{
				$("#div_telefonos").slideUp("medium");
			}
		}
	},
	cargarFormulario : function(){
		if(Object.keys(this.objForm).length > 0){
			$.each(this.objForm,function(key,value){
				let campo = $('#' + key);
				switch(campo.prop("type")){
					case "text":
					case "select-one":
					    switch(campo.prop("id")){
					    	case "input_email":
					    		Cotizacion.cargarEmails();
					    		break;
					    	case "input_fono":
					    		Cotizacion.cargarFonos();
					    		break;					    					    		
					    	case "select_tipo_servicio":
					    		if(value != ""){
									campo.val(value).trigger("change");
								}
								break;
							case "input_folio":
								Cotizacion.objForm["input_folio"] = $("#input_folio").val();
								break;							
					    	default:
					    		if(value != ""){
									campo.val(value);
								}
					    }						
						break;
				}
			});
		}
	},
	cargarServiciosPorTipo : function(obj){	

		if($(obj).val() !== ""){	
			$.ajax({
				type     : "post",
				url      : Base.getBaseUri() + "Cotizacion/cargarServiciosPorTipo",
				dataType : "json",
				data     : {
								"servicio_tipo_id" : $(obj).val()
				           },
				success  : function(response){
					
					objServicioTipo = response.objServicioTipo;

					$("#ul_servicios").html('');								
					
					$.each(objServicioTipo,function(idx,servicioTipo){
						html  = "<div class='row mt-1'>";
						html += "<div class='col-lg-12 col-md-12 col-sm-12 col-12'>";
						html += "<div class='row'>";
						html += "<div class='col-lg-1 col-md-1 col-sm-1 col-1'>";
						html += "<input type='checkbox' id='input_check_servicio_"+servicioTipo.servicio_id+"' name='input_check_servicio' value='"+servicioTipo.servicio_id+"' onclick='Cotizacion.mostrarOcultarMonto(this);if($(this).is(\":checked\")){Cotizacion.guardarTmpCamposDinamicos(this);}else{Cotizacion.eliminarTmpCamposDinamicos(this);}'>";
						html += "</div>";
						html += "<div class='col-lg-7 col-md-7 col-sm-7 col-5'>";
						html += "<label for='input_check_servicio_"+servicioTipo.servicio_id+"'>"+servicioTipo.servicio_nombre+"</label>";
						html += "</div>";
						html += "<div class='col-lg-4 col-md-4 col-sm-4 col-6'>";
						html += "<div id='div_monto_servicio_"+servicioTipo.servicio_id+"' class='input-group' style='display:none'>";
						html += "<div class='input-group-prepend'>";
	          			html += "<span class='input-group-text'>";
	          			html += "<i class='fa fa-dollar-sign'></i>";
	          			html +=	"</span>";
						html += "<input type='text' id='input_monto_servicio_"+servicioTipo.servicio_id+"' name='input_monto_servicio' class='form-control form-control-sm text-right' onchange='if($(this).val()!==\"\"){Cotizacion.guardarTmpCamposDinamicos(this);}else{Cotizacion.eliminarTmpCamposDinamicos(this);} Cotizacion.calcularMonto(this);'>";
	          			html +=	"</div>";
						html += "</div>";
						html += "</div>"; 								
						html += "</div>"; 								
						html += "</div>"; 								
						html += "</div>"; 								
						$("<li/>",{"html":html}).appendTo("#ul_servicios");

						if(Cotizacion.objForm["checkbox_servicios"].indexOf(servicioTipo.servicio_id) !== -1){
							$("#input_check_servicio_"+servicioTipo.servicio_id).trigger('click');
							idx = Cotizacion.objForm["checkbox_servicios"].indexOf(obj.value);							
							$("#input_monto_servicio_"+servicioTipo.servicio_id).val(Cotizacion.objForm["input_monto_servicios"][servicioTipo.servicio_id]);
						}
					});
					Cotizacion.objForm["checkbox_servicios"] = (Cotizacion.objForm["checkbox_servicios"]).filter((item,index)=>{
				      	return (Cotizacion.objForm["checkbox_servicios"]).indexOf(item) === index;
				    });	
					//console.log(Cotizacion.objForm["checkbox_servicios"]);
					Cotizacion.calcularMonto($("#input_monto_total"));
					$("#div_servicios").slideDown("medium"); 
				},
				error    : function(){
					VentanaModal.error(Base.ERROR_GENERAL);
				} 
			});
		}else{
			$("#ul_servicios").html('');
			$("#input_monto_total").val(0);
			Cotizacion.objForm["checkbox_servicios"]    = [];
			Cotizacion.objForm["input_monto_servicios"] = [];
		}
		
	},
	mostrarOcultarMonto : function(obj){
		if($(obj).is(":checked")){
			$("#div_monto_servicio_" + obj.value).show("fast");			
		}else{
			$("#div_monto_servicio_" + obj.value).hide("fast");			
		}
	},
	calcularMonto : function(obj){

		let monto = 0;
		
		$.each(Cotizacion.objForm["input_monto_servicios"],function(idx,value){			
			if(typeof value != "undefined"){				
				monto += parseInt(value);			
			}
			if(value == 0){
				obj.value = '';
			}
		});	
		
		$("#input_monto_total").val(monto);

	},
	guardarTmpCamposDinamicos(obj){

		id    = (obj.id).split('_').pop();		

		switch(obj.id){
			case "input_check_servicio_"+id:
				this.objForm["checkbox_servicios"].push(obj.value);
				break;
			case "input_monto_servicio_"+id:
				this.objForm["input_monto_servicios"][id] = obj.value;
				break;
		}
		this.objForm["input_monto_total"] = $("#input_monto_total").val();
	},
	eliminarTmpCamposDinamicos(obj){
		id    = (obj.id).split('_').pop();	

		switch(obj.id){
			case "input_check_servicio_"+id:				
				idx = Cotizacion.objForm["checkbox_servicios"].indexOf(obj.value);
				if(idx !== -1){						
					delete(Cotizacion.objForm["checkbox_servicios"][idx]);
					Cotizacion.objForm["checkbox_servicios"] = Cotizacion.objForm["checkbox_servicios"].filter((el, index) => Cotizacion.objForm["checkbox_servicios"].indexOf(el) === index && el !== "empty");
					id = (obj.id).split('_').pop();
					$("#input_monto_servicio_"+id).val(0).trigger("change");					
					delete(Cotizacion.objForm["input_monto_servicios"][id]);
					$("#input_monto_total").trigger("change");				
				}
				break;
			case "input_monto_servicio_"+id:
				Cotizacion.objForm["input_monto_servicios"][id] = '';
				break;
		}
	},
	guardarParcial : function(){
		this.enviarInformacion();
	},
	finalizar : function(){
		
		this.validar();

		if(Validacion.hasMensajeError()){
			Validacion.printMensajeError();
		}else{
			this.enviarInformacion(false);		
		}
	},
	enviarInformacion : function(isParcial=true){

		funcionEnvio = !isParcial?"Cotizacion/finalizar":"Cotizacion/guardarParcial";

		$.ajax({
			type : "post",
			url  : Base.getBaseUri() + funcionEnvio,
			data : this.objForm,
			dataType: "json",
			success: function(response){
				if(response.correcto){
					VentanaModal.success(response.mensaje,function(){
						Cotizacion.limpiarObjForm();
						VentanaModal.closeAll();
						$("#div_cotizacion").html(response.html);						
						Base.cargarDataTable();
					});
				}else{
					VentanaModal.error(response.mensaje);
				}
			},
			error: function(){
				VentanaModal.error(Base.ERROR_GENERAL);
			}
		});
	},	
	limpiarObjForm: function(){
		this.objForm   = {
							"input_folio"           : "",
							"input_nombres"  		: "",
							"input_apellidos" 		: "",
							"input_email"           : [],
							"checkbox_email"        : [],
							"input_fono"            : [],
							"input_lugar"     		: "",
							"input_nro_personas"    : "",
							"input_fecha_evento"    : "",
							"input_hora_evento"     : "",
							"select_origen"         : "",
							"select_tipo_servicio"  : "",
							"checkbox_servicios"    : [],
							"input_monto_servicios" : [],
							"input_monto_total"     : ""
						};
	},

	validar : function(){
		
		Validacion.limpiarTodoMensajeError();

		Validacion.setTituloMensajeError(1,"INFORMACION PERSONAL");
		Validacion.setTituloMensajeError(2,"CONTACTOS");
		Validacion.setTituloMensajeError(3,"INFORMACION DEL EVENTO");
		Validacion.setTituloMensajeError(4,"SERVICIOS COTIZADOS");
		
		if($("#select_origen").val() == ""){
			Validacion.setMensajeError(0,Mensaje._SELECT_ + "<strong>Or&iacute;gen</strong>");
		}

		if($("#input_nombres").val() == ""){
			Validacion.setMensajeError(1,Mensaje._TEXT_ + "<strong>Nombres</strong>");			
		}
		if($("#input_apellidos").val() == ""){
			Validacion.setMensajeError(1,Mensaje._TEXT_ + "<strong>Apellidos</strong>");			
		}

		if(this.objForm["checkbox_email"].indexOf(1) === -1){
			Validacion.setMensajeError(2,"Debe agregar o seleccionar a lo menos un " + "<strong>Email</strong>");
		}

		if($("#input_lugar").val() == ""){
			Validacion.setMensajeError(3,Mensaje._TEXT_ + "<strong>Lugar</strong>");			
		}

		if($("#input_nro_personas").val() == "" || $("#input_nro_personas").val() == 0){
			Validacion.setMensajeError(3,"<strong>N&deg; de personas</strong> Debe completar el campo o este debe ser superior a 0");			
		}

		if($("#input_fecha_evento").val() == ""){
			Validacion.setMensajeError(3,Mensaje._TEXT_ + "<strong>Fecha</strong>");			
		}

		if($("#input_hora_evento").val() == ""){
			Validacion.setMensajeError(3,Mensaje._TEXT_ + "<strong>Hora</strong>");			
		}
		console.log(this.objForm["input_monto_servicios"].filter(x=>x!="").length);
		if($("#select_tipo_servicio").val() == ""){
			Validacion.setMensajeError(4,Mensaje._SELECT_ + "<strong>Tipo de servicio</strong>");			
		}else if(this.objForm["checkbox_servicios"].length == 0){			
			Validacion.setMensajeError(4,"Debe seleccionar a lo menos un <strong>Servicio</strong>");
		}else if(this.objForm["input_monto_servicios"].filter(x=>x!="").length == 0){
			Validacion.setMensajeError(4,"Debe completar los montos de los servicios seleccionados");			
		}


	}


};


