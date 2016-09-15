/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


window.onload=function() {
  var un = document.getElementById("userName");
	var pwd = document.getElementById("userPwd");
	un.value= "Usuario";
	pwd.value= "Clave";
	un.onfocus = function() {
	  un.value = '';
	};
	un.onblur = function() {
	  un.value = '';
	};
	pwd.onfocus = function() {
	  pwd.value = '';
	};
	pwd.onblur = function() {
	  pwd.value = 'Password';
	};
};