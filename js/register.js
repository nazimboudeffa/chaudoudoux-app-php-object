$(document).ready(function(){
  // REGISTER
  $('#facebook').click(function(){
    alert("Facebook n'est pas encore pris en charge");
  })
  $('#google').click(function(){
    alert("Google n'est pas encore pris en charge");
  })

  $('#registerForm').submit(function(){
    console.log("click");

  var check = $(this).validationEngine('validate');
  if(check === false){ return false; }
  values = new Array();
  values['remail'] = $('#remail').val();
  values['rusername'] = $('#rusername').val();
  values['rpassword'] = $('#rpassword').val();
  values['rcpassword'] = $('#rcpassword').val();
  values['agree'] = $('#agree').attr('checked');
  if(values['rusername'] == ''){  $('#update').html("Il manque un pseudo");$('#update').fadeIn('fast');updatefadeout(); return false; }
  if(values['remail'] == ''){  $('#update').html("Il manque un email");$('#update').fadeIn('fast');updatefadeout(); return false; }
  if(values['rpassword'] == ''){  $('#update').html("Il manque un mot de passe");$('#update').fadeIn('fast');updatefadeout(); return false; }
  if(values['rpassword'] != values['rcpassword']){  $('#update').html("Les deux mots de passe doivent être identiques");$('#update').fadeIn('fast');updatefadeout(); return false; }
  if(values['agree'] == false){  $('#update').html("Merci d'accepter les conditions d'utilisation pour créer votre compte");$('#update').fadeIn('fast');updatefadeout(); return false; }
  // Check the pseudo and email are not already existant
  $.ajax({
    type: 'POST',
    url: 'classes/actions.php',
    data: { 'action' : 'check' , 'email' : values['remail'] , 'username' : values['rusername'], 'password' : values['rpassword'] },
    dataType : 'json',
    beforeSend:function(){
      $('#update').html("Vérification de la disponibilité de votre Pseudo et email.");
      $('#update').fadeIn('fast');
    },
    success:function(data){
      console.log(data);
      if( data.error === false){
        //var is_it_ok = true;
        $('#update').html("Pseudo et email ok");
        updatefadeout();
        ///////////////////////////////////////
        $.ajax({
          type: 'POST',
          url: 'classes/actions.php',
          data: { 'action' : 'register' , 'remail' : values['remail'] , 'rusername' : values['rusername'], 'rpassword' : values['rpassword']   },
          dataType : 'json',
          beforeSend:function(){
            $('#update').html("Enregistrement de vos information");
            $('#update').fadeIn('fast');
          },
          success:function(data){
            if( data.error === false){
              $('#update').html("Vous êtes maintenant connecté");
              updatefadeout();
              if ($("#word").length > 0){
                return AddWord();
              } else {
                window.location.href = "profile.php";
              }
            }
            if(data.error === true){
              $('#update').html("Il y a une erreur dans les informations, priez vérifier");
              updatefadeout();
              return false;
            }
          },
          error:function(data){
            console.log(data);
            alert("Il y a une erreur.  Priez reloader la page.");
          }
        });
        ///////////////////////////////////////
      }
      if(data.error === true){
        $('#femail').val(values['remail']);
        $('#forgottencontent').fadeIn('fast');
        if(data.src === 'email'){
          $('#update').html("Votre email est enregistré sous un autre pseudo, vous avez oublié votre mot de passe?");
        }
        if(data.src === 'username'){
          $('#update').html("Votre pseudo est déjà pris, merci d'en trouver un autre");
        }
        updatefadeout();
        return false;
      }
    },
    error:function(data){
      alert("Il y a une erreur.  Priez reloader la page.");
    }
  });
  return false
  });
});
