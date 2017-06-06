/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $(this).on("change", "#selCompanies", function(){
        var form_data = new FormData();
        form_data.append("opc", "10");
        form_data.append("codigo", $(this).val());
        $.ajax({
            url: "scripts/generalcode.php",
            //dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: "POST"
        });
    });
});

