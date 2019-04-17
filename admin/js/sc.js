function show() {
    document.getElementById('myd').style.visibility = "visible";
  
}

function hide() {
  document.getElementById('myd').style.visibility = "hidden";
}

function master() {
  var sele = document.getElementById('sl');
  if (sele.value == "") {
    hide();
  }
  else {
    show();
  }
}
