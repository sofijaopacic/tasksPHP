<?php

include 'header.php';

?>
<div class="container mt-3">

  <div class="row">
    <div class="col-6">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Obrisi</th>
          </tr>
        </thead>
        <tbody id='podaci'></tbody>
      </table>
    </div>
    <div class="col-6">
      <h3 class="text-center">Kreiraj usera</h3>
      <form id='forma'>
        <div class="form-group">
          <label for="first_name">Ime</label>
          <input required class="form-control" id="first_name">
        </div>
        <div class="form-group">
          <label for="last_name">Prezime</label>
          <input required class="form-control" id="last_name">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input required class="form-control" type="email" id="email">
        </div>
        <div class="form-group">
          <label for="phone">Telefon</label>
          <input required class="form-control" id="phone">
        </div>
        <button type="submit" class="form-control btn btn-primary mt-2">Kreiraj</button>
      </form>
    </div>
  </div>

</div>

<script>


  $(function () {
    ucitajUsere();
    $('#forma').submit(async e => {
      e.preventDefault();
      const res = await $.post('./api/user.php', {
        akcija: 'create',
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        phone: $('#phone').val()
      });
      alert(res ? 'Doslo je do greske' : 'uspesno kreiran user');
      ucitajUsere();

      e.target.reset();
    })
  })

  async function ucitajUsere() {
    let res = await $.post('./api/user.php', { akcija: 'get' });
    res = JSON.parse(res);
    $('#podaci').html(res.map(user => {
      return `
        <tr>
          <td>${user.id}</td>
          <td>${user.first_name}</td>
          <td>${user.last_name}</td>
          <td>${user.email}</td>
          <td>${user.phone}</td>
          <td>
          <button onClick='obrisi(${user.id})' class='btn btn-danger'>Obrisi</button>
          </td>
        </tr>
      `;
    }))
  }

  async function obrisi(id) {
    const res = await $.post('./api/user.php', { akcija: 'delete', id });
    alert(res ? 'Doslo je do greske' : 'uspesno obrisan user');
    ucitajUsere();
  }
</script>

</body>