$(Document).ready(function(){

    $input_reserva_tipo = $("#reserva-tipo")
    $input_data_fim = $("#data-fim") 

    $reserva.change(function () {
        if ($input_reserva_tipo.val() == 'unica') {
            $input_data_fim.removeAttr('disabled');
        } else {
                $input_data_fim.attr('disabled', 'disabled').val('');
            }
        }).trigger('change');
        
//         $("#reserva-tipo").on("change", function() {
            
//             $("#reserva-tipo option:selected" ).each(function() {
//                 // $("#data-fim").attr('disabled', 'disabled')
//                 $("#data-fim").removeAttr('disabled');
//     } );

//   } ).trigger( "change" );

})






