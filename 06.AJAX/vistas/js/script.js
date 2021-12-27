// COMPROBAR SI EL EMAIL CON EL QUE SE REGISTRA EL USUARIO NO EXISTE, PARA QUE NO ESTÉ REPETIDO
$("#email").change(function(){

	$(".alert").remove();

	var email = $(this).val();
	
	var datos = new FormData();
	datos.append("validarEmail", email);

	$.ajax({
		// a donde se envia la variable php
		url: "ajax/formularios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		// indicar el tipo de datos que se van a recibir es json,de esta forma le da formarto a los datos que devuelve
		dataType: "json",
		// la respuesta que se recibe
		success:function(respuesta){
			
			if(respuesta){

				$("#email").val("");

				$("#email").parent().after(`
					
					<div class="alert alert-warning">

							<b>ERROR:</b>

							El correo electrónico ya existe en la base de datos,  por favor ingrese otro diferente
					</div>


				`);

			}

		}

	});


})