const Mensaje = {
	_SELECT_ : "Debe seleccionar una opci&oacute;n en ",
	_TEXT_   : "Debe completar el campo "
};

var Validacion = {
	
	arrMensajeByTitulo : {},
	mensajeError       : "",

	setTituloMensajeError : function(ID,titulo){		
		if(this.arrMensajeByTitulo[ID] === undefined){
			this.arrMensajeByTitulo[ID] = 	{
												titulo       : "",
												arr_mensajes : []
											};
		}

		if(titulo != ""){
			this.arrMensajeByTitulo[ID]["titulo"] = titulo;			
		}
	},

	setMensajeError : function(ID,mensaje){

		if(this.arrMensajeByTitulo[ID] === undefined){
			this.arrMensajeByTitulo[ID] = 	{
												titulo       : "",
												arr_mensajes : []
											};
		}
		if(mensaje != ""){
			this.arrMensajeByTitulo[ID]["arr_mensajes"].push(mensaje);
		}
	},

	resetMensajeError : function(ID){
		if(this.arrMensajeByTitulo[ID] !== undefined){
			this.arrMensajeByTitulo[ID]["arr_mensajes"] = [];
		}
	},

	prepareMensajesError : function(){
		console.log(this.arrMensajeByTitulo);
		this.mensajeError = "";
		if(Object.keys(this.arrMensajeByTitulo).length > 0){
			$.each(this.arrMensajeByTitulo,function(ID,obj){
				if(obj["arr_mensajes"].length > 0){
					if(obj["titulo"] != ""){
						console.log("aqui");
						Validacion.mensajeError += "<h6><u>" + obj["titulo"] + "</u></h6>";	
					} 
					Validacion.mensajeError += "<ul>";
					$.each(obj["arr_mensajes"],function(idx,mensaje){
						Validacion.mensajeError += "<li>"+mensaje+"</li>";
					});
					Validacion.mensajeError += "</ul>";
				}
			});			
		}
	},

	limpiarTodoMensajeError : function(){
		this.arrMensajeByTitulo = {};
	},

	printMensajeError : function(){

		this.prepareMensajesError();		
		VentanaModal.info(this.mensajeError);

	},

	hasMensajeError : function(){
		if(Object.keys(this.arrMensajeByTitulo).length > 0){
			return true;
		}

		return false;
	}
};