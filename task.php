<?php

include 'header.php';

?>

<div class="container mt-3  ">
  <h1 class="text-center">Izmeni task</h1>
  <div class="d-flex justify-content-center">
    <form id='forma'>
      <div class="form-group">
        <label for="id">ID</label>
        <input disabled class="form-control" value="<?php echo $_GET['id']; ?>" id="id">
      </div>
      <div class="form-group">
        <label for="title">Naslov</label>
        <input required class="form-control" id="title">
      </div>
      <div class="form-group">
        <label for="due_date">Rok</label>
        <input required class="form-control" type="datetime-local" id="due_date">
      </div>
      <div class="form-group">
        <label for="user_id">Korisnik</label>
        <select required class="form-control" id="user_id">
        </select>
      </div>
      <div class="form-group">
        <label for="description">Opis</label>
        <textarea required class="form-control" id="description"></textarea>
      </div>
      <button type="submit" class="form-control btn btn-primary mt-2">Sacuvaj</button>
      <button type="button" id="obrisi" class="form-control btn btn-danger mt-2">Obrisi</button>
    </form>
  </div>
</div>
<script>

  $(function () {
    ucitajUsere();
    ucitajTask();

    $('#obrisi').click(async (e) => {
      e.stopPropagation();
      const id = $('#id').val();
      const res = await $.post('./api/task.php', { akcija: 'delete', id });
      alert(res ? 'Doslo je do greske' : 'uspesno obrisan task');
      window.location.assign('./index.php');
    })

    $('#forma').submit(async e => {
      e.preventDefault();

      const res = await $.post('./api/task.php', {
        akcija: 'update',
        title: $('#title').val(),
        id: $('#id').val(),
        due_date: $('#due_date').val(),
        user_id: $('#user_id').val(),
        description: $('#description').val(),
      });
      alert(res || 'Uspesno izmenjen task')
    })
  })

  async function ucitajUsere() {
    let res = await $.post('./api/user.php', {
      akcija: 'get'
    });
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

  async function ucitajTask() {
    let res = await $.post('./api/task.php', {
      akcija: 'one',
      id: $('#id').val()
    });
    res = JSON.parse(res);
    if (res?.length !== 1) {
      alert('Doslo je do greske')
      return;
    }
    $('#title').val(res[0].title)
    $('#due_date').val(res[0].due_date)
    $('#user_id').val(res[0].user_id)
    $('#description').val(res[0].description)
  }
</script>
</body>