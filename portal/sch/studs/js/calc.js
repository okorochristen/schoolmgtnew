function calcTotal() {
  if (document.getElementById('as1').value == "") {
    var as1 = 0;
  }
  else {
    var as1 = Number(document.getElementById('as1').value);
  }

  if (document.getElementById('as2').value == "") {
    var as2 = 0;
  }
  else {
    var as2 = Number(document.getElementById('as2').value);
  }

  if (document.getElementById('ts1').value == "") {
    var ts1 = 0;
  }
  else {
    var ts1 = Number(document.getElementById('ts1').value);
  }

  if (document.getElementById('ts2').value == "") {
    var ts2 = 0;
  }
  else {
    var ts2 = Number(document.getElementById('ts2').value);
  }

  if (document.getElementById('exam').value == "") {
    var exam = 0;
  }
  else {
    var exam = Number(document.getElementById('exam').value);
  }

  var total = as1 + as2 + ts1 + ts2 + exam;
  document.getElementById('total').value = total;

  if (total > 100) {
    document.getElementById('msg').innerHTML = "Total cannot be greater than 100";
  }
}
