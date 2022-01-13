$(document).ready(function(){
  // LOGIN
  $('#loginForm').submit(function(){
  var check = $(this).validationEngine('validate');
  if(check === false){ return false; }
  var lemail = $('#lemail').val();
  var lpassword = $('#lpassword').val();
  if(lemail === ''){  $('#update').html("Il manque un email");$('#update').fadeIn('fast');updatefadeout(); return false; }
  if(lpassword === ''){  $('#update').html("Il manque un mot de passe");$('#update').fadeIn('fast');updatefadeout(); return false; }
  $.ajax({
       type: 'POST',
       url: 'classes/actions.php',
       data: { 'lemail' : lemail , 'lpassword' : lpassword , 'action' : 'login' },
       dataType : 'json',
       beforeSend:function(){
            $('#update').html("Verification des informations.");
            $('#update').fadeIn('fast');
       },
       success:function(data){
         console.log(data);
          if( data.error === false){
             $('#update').html("Vous êtes maintenant connecté");
             updatefadeout();
             window.location.href = "dashboard.php";
          }
          if(data.error === true){
            $('#update').html("Erreur sur l'email ou le mot de passe");
            return false;
          }
       },
       error:function(data){
         console.log(data);
         alert("Il y a une erreur.  Priez reloader la page.");
       }
    });
    return false;
  });
});
