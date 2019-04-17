function promoteStudent(name, id, cl, session) {
  var reply = confirm('Are you sure you want to promote '+name+' to the next class?');
  if (reply) {
    window.location.href = 'promote-student2.php?regno='+id+'&class='+cl+'&session='+session;
  }
}

function repeatStudent(name, id, cl, session) {
  var reply = confirm('Are you sure you want to repeat '+name+'?');
  if (reply) {
    window.location.href = 'repeat-student2.php?regno='+id+'&class='+cl+'&session='+session;
  }
}
