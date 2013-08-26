$(document).on("ready",inicio);

function inicio (e) {
	// body...
  $("#Formulario_Login").on("submit",enviar);
}
function enviar (e) {
	// body...
	var usuario = $("#xUsuario").val();
	var pass  = $("#xPass").val();

	$.getJSON('php/LoginVerifica.php', {user: usuario, pass: pass}, function(data) {

			/*optional stuff to do after success
		 */

			if(data.estado =="0")
			{
				 var cambios =
							{
								display: "block",
								height: "auto",
								opacity: 1,
								overflow: "hidden",
								padding: "0.5em 0",
								width: "100%"
							};
				$("section #login p").css(cambios);
				
			}
		
			return true;
	});
	return false;

}