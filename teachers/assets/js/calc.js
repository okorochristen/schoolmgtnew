function calcTotal(as1, as2, ts1, total) {
  if (document.getElementById(as1).value == "") {
    var ras1 = 0;
  }
  else {
    var ras1 = Number(document.getElementById(as1).value);
  }

  if (document.getElementById(as2).value == "") {
    var ras2 = 0;
  }
  else {
    var ras2 = Number(document.getElementById(as2).value);
  }

  if (document.getElementById(ts1).value == "") {
    var rts1 = 0;
  }
  else {
    var rts1 = Number(document.getElementById(ts1).value);
  }

  

  var rtotal = ras1 + ras2 + rts1;
  document.getElementById(total).value = rtotal;

  if ((rtotal > 100) || (rtotal < 0)) {
    window.alert("Total cannot be greater than 100 or lesser than 0!");
    document.getElementById(as1).value = 0;
    document.getElementById(as2).value = 0;
    document.getElementById(ts1).value = 0;
    document.getElementById(total).value = 0;
  }
}
