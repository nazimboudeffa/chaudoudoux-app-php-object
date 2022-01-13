$(document).ready(function(){
  // FORGOTTEN EMAIL
  $('#forgottenbutton').click(function(){
  $('#forgottencontent').fadeIn('fast');
  return false;
  });

  $('#forgotten').click(function(){
  var email = $('#femail').val();
  if(email === ''){  $('#update').html("Il manque un email");$('#update').fadeIn('fast');
  updatefadeout(); return false; }
  if( $("#femail").validationEngine('validateField', "#femail") === true ){ return false; };
  $.ajax({
     type: 'POST',
     url: 'classes/actions.php',
     data: { 'action' : 'login_forgotten', 'email' : email },
     dataType : 'json',
     beforeSend:function(){
       $('#update').html("Verification de votre email...");
       $('#update').fadeIn('fast');
     },
     success:function(data){
        if( data.error === false){
             $('#update').html("Un email avec votre nouveau mot de passe vous a été envoyé, vous le recevrez sous peu.");
             updatefadeout();
        }
        if(data.error === true){
             $('#update').html("Votre email n\'est pas dans notre base de données.");
             updatefadeout();
        }
     },
     error:function(data){
      //alert("Il y a une erreur.  Priez reloader la page.");
     }
  });
  return false;
  });
});
