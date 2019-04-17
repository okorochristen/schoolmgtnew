function calcTotal(as1, as2, ts1, ts2, exam, total) {
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

  if (document.getElementById(ts2).value == "") {
    var rts2 = 0;
  }
  else {
    var rts2 = Number(document.getElementById(ts2).value);
  }

  if (document.getElementById(exam).value == "") {
    var rexam = 0;
  }
  else {
    var rexam = Number(document.getElementById(exam).value);
  }

  var rtotal = ras1 + ras2 + rts1 + rts2 + rexam;
  document.getElementById(total).value = rtotal;

  if ((rtotal > 100) || (rtotal < 0)) {
    window.alert("Total cannot be greater than 100 or lesser than 0!");
    document.getElementById(as1).value = 0;
    document.getElementById(as2).value = 0;
    document.getElementById(ts1).value = 0;
    document.getElementById(ts2).value = 0;
    document.getElementById(exam).value = 0;
    document.getElementById(total).value = 0;
  }
}
