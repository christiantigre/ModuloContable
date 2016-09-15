/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var
  is_asked = false;

window.onbeforeunload = 
  function (ev) {
    var e = ev || window.event;
    window.focus();
    if (!is_asked){
      is_asked = true;
      var showstr = "CUSTOM_MESSAGE";
      if (e) {  //for ie and firefox
        e.returnValue = showstr; 
      }
      return showstr; //for safari and chrome
    }
  };

window.onfocus =
  function (ev){
    if (is_asked){
//      window.location.href = "login.php";
      window.location.href = "../../templates/logeo/desconectar_usuario.php";
    }
  }

//]]>