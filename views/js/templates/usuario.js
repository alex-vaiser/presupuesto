var Usuario = {
	init: function(){

	},
	autenticar : function(){
		datos = $("#form_autenticacion").serializeArray();

		$.ajax({
			type     : "post",
			url      : Base.getBaseUri() + "Publico/autenticar",
			data     : datos,
			dataType : "json",
			success  : function(response){				
				if(response.error){
					VentanaModal.info(response.mensaje);
				}else{
					location.href=response.url;
				}
			}
		})
	}
}