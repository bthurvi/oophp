/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showLogin()
{
    //alert("kolla");
    document.getElementById('login').classList.toggle('closed');
    document.getElementById('logininfo').classList.toggle('rotated');
    //document.getElementById('logininfo').innerHTML = "<i class='fa fa-angle-down'></i> &nbsp; Inloggad som: <b>Bo Bratt</b> ";
}

$('tr').click( function() { 
    window.location  = $(this).find('a').attr('href'); 
});

$(".chtoggle").mousedown(function() 
{
    btn = $(this);
    
    btn.toggleClass("checkedbox");  
    
    
    if(btn.hasClass("nocat"))
    {
       $(".hascat").removeClass("checkedbox");
       $(".hascat input").prop('checked', false);
    }
    if(btn.hasClass("hascat"))
    {
       $(".nocat").removeClass("checkedbox");
       $(".nocat input").prop('checked', false);
    }
});

//display upload button only after user has selected a file
 $("#fileToUpload").change(function() 
 {
     var path = $(this).val();
     var fileExtensionStart = path.lastIndexOf(".") + 1;
     var fileExtension = path.substr(fileExtensionStart);
     
     
     if(fileExtension=='jpg' || fileExtension=='jpeg' || fileExtension=='png')
     { 
        $('#fileUpploadButton').click();
    }
    else
        sweetAlert("Ursäkta men...", "endast jpg- och png-filer är tillåtna att ladda upp.");
 });
 
 $('ul.gallery li').mousedown(function(){$(this).toggleClass('markAsSelected');});
 
 






       


