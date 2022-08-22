<?php

include 'header.php';

?>

<div class="container mt-3">
  <h1 class="m-2 text-center">Kreiraj task</h1>
  <form id='forma'>
    <div class="form-group">
      <label for="title">Naslov</label>
      <input class="form-control" id="title">
    </div>
    <div class="form-group">
      <label for="due_date">Rok</label>
      <input class="form-control" type="datetime-local" id="due_date">
    </div>
    <div class="form-group">
      <label for="user_id">Korisnik</label>
      <select class="form-control" type="datetime-local" id="user_id">
      </select>
    </div>
    <div class="form-group">
      <label for="description">Opis</label>
      <textarea class="form-control" id="description"></textarea>
    </div>
    <button type="submit" class="form-control btn btn-primary mt-2">Kreiraj</button>
  </form>
</div>

<script>
  $(function () {
    ucitajUsere();
    $('#forma').submit(async e => {
      e.preventDefault();

      const res = await $.post('./api/task.php', {
        akcija: 'create',
        title: $('#title').val(),
        due_date: $('#due_date').val(),
        user_id: $('#user_id').val(),
        description: $('#description').val(),
      });
      alert(res || 'Uspesno kreiran task')
      e.target.reset();
    })
  })

  async function ucitajUsere() {
    let res = await $.post('./api/user.php', { akcija: 'get' });
    res = JSON.parse(res);
    $("#user_id").html(
      res.map(user => {
        return `
          <option value="${user.id}">
            ${user.email}
            </option>
        `
      })
    )
  }
</script>

</body>