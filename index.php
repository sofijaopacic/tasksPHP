<?php

include 'header.php';

?>

<div class="container mt-3">
  <input type="search" class="form-control" placeholder="Pretrazi taskove..." id="pretraga">
  <div class="mt-3 row d-flex justify-content-center" id="taskovi">

  </div>
</div>

<script>
  $(function () {
    ucitajTaskove();
    $('#pretraga').change(ucitajTaskove);
  });

  async function ucitajTaskove() {
    let pretraga = $('#pretraga').val() || undefined;
    let res = await $.post('./api/task.php', { akcija: 'get', pretraga });
    res = JSON.parse(res);
    const htmlVal = res.map(task => {
      return `
        <div class='col-3 ml-2 mt-3 rounded border border-primary '>
          <h2 class='text-center'>
          <a href='./task.php?id=${task.id}'>${task.title}</a>
          </h2>
          <h3>User: ${task.email}<h3>
          <h3>Due date:${task.due_date}</h3>
          <p>
          ${task.description}  
          </p>
        </div>
      `;
    });
    $('#taskovi').html(htmlVal);
  }

</script>

</body>