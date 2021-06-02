var VentanaModal = {

	/**
	 * Descripción : Alerta tipo error 
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 11-06-2020
	 * @param      : (String) mensaje
	 * @param      : [Opcional](Function) callback
	 */
	error : function(mensaje,_callback = null){
		
		bootbox.dialog({
			        title   : "Error",
			        message : mensaje,
			        buttons : {
			        	accept : {
			        		label     : "Aceptar",
			        		className : "btn-danger btn-sm",
			        		callback  : function(){
			        			if(typeof _callback === "function"){
									_callback();
								}
			        		}
			        	}
			        }
			    });

		$(".modal-header").last().addClass("bg-danger text-white").css({"color": "#ffffff","background-color": "#d9534f","padding":"10px 15px"});			

		$(".bootbox-close-button").off("click");
		$(".bootbox-close-button").on("click",function(){
			if(typeof _callback === "function"){
				_callback();
			}
		});

	},

	/**
	 * Descripción : Alerta tipo éxito
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 11-06-2020
	 * @param      : (String) mensaje
	 * @param      : [Opcional](Function) callback
	 */
	success : function(mensaje,_callback = null){
		
		bootbox.dialog({
			        title   : "&Eacute;xito",
			        message : mensaje,
			        buttons : {
			        	accept : {
			        		label     : "Aceptar",
			        		className : "btn-success btn-sm",
			        		callback  : function(){
			        			if(typeof _callback === "function"){
									_callback();
								}		        			
			        		}
			        	}
			        }
			    });

		$(".modal-header").last().addClass("bg-success text-white").css({"color": "#ffffff","background-color": "#5cb85c","padding":"10px 15px"});

		$(".bootbox-close-button").off("click");
		$(".bootbox-close-button").on("click",function(){
			if(typeof _callback === "function"){
				_callback();
			}
		});
	},

	/**
	 * Descripción : Alerta tipo información
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 11-06-2020
	 * @param      : (String) mensaje
	 * @param      : [Opcional](Function) callback
	 */
	info : function(mensaje,_callback = null){

		bootbox.dialog({
			        title   : "Informaci&oacute;n",
			        message : mensaje,
			        buttons : {
			        	accept : {
			        		label     : "Aceptar",
			        		className : "btn-primary btn-sm",
			        		callback  : function(){
			        			if(typeof _callback === "function"){
									_callback();
								}	        			
			        		}
			        	}
			        }
			    });

		$(".modal-header").last().addClass("bg-primary text-white").css({"color": "#ffffff","background-color": "#428bca","padding":"10px 15px"});

		$(".bootbox-close-button").off("click");
		$(".bootbox-close-button").on("click",function(){
			if(typeof _callback === "function"){
				_callback();
			}
		});		
	},

	/**
	 * Descripción : Alerta tipo información
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 09-07-2020
	 * @param      : (String) mensaje
	 * @param      : (Function) callback_ok
	 * @param      : (Function) callback_cancel
	 */
	confirm : function(mensaje,_callback_ok,_callback_cancel){

		bootbox.dialog({
			        title   : "Confirmaci&oacute;n",
			        message : mensaje,
			        buttons : {
				        	yes : {
				        		label     : "<i class='glyphicon glyphicon-check'></i>&nbsp;SI",
				        		className : "btn-warning btn-sm",
				        		callback  : function(){
				        			if(typeof _callback_ok === "function"){
										_callback_ok();
									}	        			
				        		}
				        	},
				        	no : {
				        		label     : "<i class='glyphicon glyphicon-remove'></i>&nbsp;NO",
				        		className : "btn-warning btn-sm",
				        		callback  : function(){
				        			if(typeof _callback_cancel === "function"){
										_callback_cancel();
									}	        			
				        		}
				        	}
			        }
			    });

		$(".modal-header").last().addClass("bg-info text-white").css({"color": "#FFFFFF","background-color": "#f0ad4e","padding":"10px 15px"});

		$(".bootbox-close-button").off("click");
		$(".bootbox-close-button").on("click",function(){
			if(typeof _callback === "function"){
				_callback_cancel();
			}
		});
	},

	/**
	 * Descripción : Modal para mostrar contenido de alguna vista 
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 12-06-2020
	 * @param      : (String) url = Dirección desde donde se tendrá la vista
	 * @param      : (String) title = Título que llevará en el encabezado del modal
	 * @param      : [Opcional](int) size = Tamaño en % del modal debe ser solo un numero entero
	 * @param      : [Opcional](Function) _callback_ok = Funcion de retorno que se ejecutará al presionar el botón aceptar
	 * @param      : [Opcional](Function) _callback_cancel = Funcion de retorno que se ejecutará al presionar el botón cancelar o la x para cerrar el modal
	 * @param      : [Opcional](Object) icon = es un objeto compuesto de las keys ok y cancel y cumple la funcion de colocar los iconos en los botones
	 * @param      : [Opcional](Object) btn_text = es un objeto compuesto de las keys ok y cancel y se utiliza para definir el texto de los botones
	 */
	open : function(url = "",title = "",size = 100, _callback_ok = "", _callback_cancel = "", icon = {ok : "fa fa-save",cancel : "fa fa-close"}, btn_text = {ok : "Guardar",cancel: "Cancelar"}){

		if(url === ""){
			console.error("parámetro url no definida");
			return false;
		} 

		if(title === ""){
			console.error("parámetro title no definido");
			return false;
		}

		if(!Number.isInteger(size)){
			console.error("parámetro size no es un número entero");
		}

		if(typeof icon !== "object" || typeof btn_text !== "object"){
			console.error("El parámetro icon o btn_text no es un objeto");
			return false;
		}

		if(icon["ok"] === undefined || icon["cancel"] === undefined){
			console.error("parámetros ok o cancel de icono no definido");
			return false;
		}

		if(btn_text["ok"] === undefined || btn_text["cancel"] === undefined){
			console.error("parámetros ok o cancel de btn_text no definido");
			return false;
		}

		bootbox.dialog({					
			        title   : title,
			        message : $("<div></div>").load(url),
			        buttons : {
			        	accept : {
			        		label     : "<i class=\"" + icon["ok"] + "\"></i>&nbsp;" + btn_text["ok"],
			        		className : "btn-success btn-sm",
			        		callback  : function(){			        				

			        			if(typeof _callback_ok === "function"){
			        				_callback_ok();
			        			}
			        			return false;		        			
			        		}
			        	},			        
			        	cancel : {
			        		label     : "<i class=\"" + icon["cancel"] + "\"></i>&nbsp;" + btn_text["cancel"],
			        		className : "btn-danger btn-sm",
			        		callback  : function(){			        			

			        			if(typeof _callback_cancel === "function"){
			        				_callback_cancel();
			        			}

			        		}
			        	}
			        }
			    });

		$(".modal").css({"padding-left":"15px"});			
		$(".modal-dialog").css({"min-width":size + '%'});
		$(".modal-header").addClass("bg-primary text-white").css({"color": "#ffffff","background-color": "#428bca","padding":"10px 15px"});		
		$(".bootbox-close-button").off("click");
		$(".bootbox-close-button").on("click",function(){
			if(typeof _callback_cancel === "function"){
				_callback_cancel();
			}
		});	

	},

	/**
	 * Descripción : Cierra la ultima o más reciente ventana modal desplegado
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 13-06-2020
	 * @param      : (String) url
	 * @param      : (String) title
	 * @param      : (int) size
	 */
	openIframe : function(url = "",title = "",size = 100){

		if(url === ""){
			console.error("parámetro url no definida");
			return false;
		} 

		if(title === ""){
			console.error("parámetro title no definido");
			return false;
		}

		if(!Number.isInteger(size)){
			console.error("parámetro size no es un número entero");
		}

		bootbox.dialog({					
			        title   : title,
			        message : $("<iframe/>",{"src":url,"frameborder":1,"style":"width:100%;min-height:500px"}),
			        buttons : {			        				        
			        	close : {
			        		label     : "<i class=\"glyphicon glyphicon-remove\"></i>&nbsp;Cerrar",
			        		className : "btn-danger btn-sm",
			        		callback  : bootbox.hideAll
			        	}
			        }
			    });

		$(".modal").css({"padding-left":"15px"});			
		$(".modal-dialog").css({"min-width":size + '%'});
		$(".modal-header").addClass("bg-primary text-white").css({"color": "#ffffff","background-color": "#428bca","padding":"10px 15px"});
	},

	/**
	 * Descripción : Cierra la ultima o más reciente ventana modal desplegado
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 13-06-2020
	 * @param      : (Function) _callback	
	 */
	close : function(_callback = null){

		$(".bootbox.modal").last().modal("hide");	
		
		if(typeof _callback === "function"){
			_callback();
		}

	},

	/**
	 * Descripción : Cierra todas las ventanas modal
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 13-06-2020
	 * @param      : (Function) _callback	
	 */
	closeAll : function(_callback = null){
		bootbox.hideAll();

		if(typeof _callback === "function"){
			_callback();
		}

	},

	/**
	 * Descripción : Cierra todas las ventanas modal
	 * @author     : Alexis Visser <alexis.visser@cosof.cl> 30-10-2020
	 * @param      : (String) url
	 * @param      : (String|int) size	  	
	 */
	openSimpleIframe : function(url = "",size = 100){

		if(url === ""){
			console.error("parámetro url no definida");
			return false;
		} 				
		
		bootbox.dialog({		        
			        		message : $("<iframe/>",{"src":url,"frameborder":0,"style":"width:100%;height:"+(screen.height * 0.67)+"px"})			        
			    	  });

		$(".modal").css({"padding-left":"15px"});			
		$(".modal-dialog").css({"min-width":size + '%'});
		$(".modal-body").css({"padding":0});
		$(".modal-body button").css({"padding":"5px 10px","opacity":"1","color":"white","background":"red","position":"absolute","top":0,"right":0});

	},

	openViews : function(url,title,size=100,callback = ""){

		bootbox.dialog({					
			        title   : title,
			        message : $("<div></div>").load(url)			        
			    });

		$(".modal").css({"padding-left":"15px","padding-right":"15px"});			
		$(".modal-dialog").css({"min-width":size + '%'});
		$(".modal-header").addClass("bg-secondary text-white").css({"color": "#ffffff","background-color": "#428bca","padding":"10px 15px"});		
		$(".bootbox-close-button").off("click");

		if(callback != "" && typeof callback === "function"){
			callback();
		}

	}
}