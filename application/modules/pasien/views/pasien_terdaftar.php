  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <a href="<?php echo base_url(); ?>pasien/registrasi" class="tambah_blog btn btn-sm btn-neutral">Tambah</a>
                  </div>
              </div>
              <!-- Card stats -->
              <div class="row">




              </div>
          </div>
      </div>
  </div>
  <div class="container-fluid mt--6 shadow-sm">
      <div class="row">
          <div class="col-lg-12">
              <?= $this->session->flashdata('message'); ?>
          </div>
      </div>
      <div class="row">
          <div class="col">
              <div class="card shadow-sm">
                  <div class="card-header">
                      <h3 class="card-title">Daftar Pasien</h3>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_pasien" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th class="text-center" style="width: 10%;">#</th>
                                      <!-- <th style="width: 5%;">No.</th> -->
                                      <th style="width: 25%;">Nama</th>
                                      <th style="width: 20%;">Alamat</th>
                                      <!-- <th style="width: 40%;">Jenis Kelamin</th> -->
                                      <th style="width: 10%;">No. Telp</th>
                                      <th style="width: 10%;">Penanggung Jawab</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="riwayatrawatanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tanggal Resume Medis</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_rawatan" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th class="text-center" style="width: 10%;">#</th>
                                          <!-- <th style="width: 5%;">No.</th> -->
                                          <th style="width: 25%;">Data Pasien</th>
                                          <th style="width: 20%;">Diagnosa</th>
                                          <!-- <th style="width: 40%;">Jenis Kelamin</th> -->
                                          <th style="width: 10%;">BI Score</th>
                                          <th style="width: 10%;">Alergi</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <input type="hidden" name="idpasien" id="idpasien">
                          <button type="button" class="btn btn-primary" id="btn_print">Print</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <div class="modal fade" id="detailpasienModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tanggal Resume Medis</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_rawatan" class="table table-hover table-sm display">
                                  <tbody>
                                      <tr>
                                          <td>Nama</td>
                                          <td>:</td>
                                          <td class="detail_nama">Nama</td>
                                      </tr>
                                      <tr>
                                          <td>NIK</td>
                                          <td>:</td>
                                          <td class="detail_nik"></td>
                                      </tr>
                                      <tr>
                                          <td>No. Rekam Medis</td>
                                          <td>:</td>
                                          <td class="detail_no_mr"></td>
                                      </tr>
                                      <tr>
                                          <td>Jenis Kelamin</td>
                                          <td>:</td>
                                          <td class="detail_jenis_kelamin"></td>
                                      </tr>
                                      <tr>
                                          <td>Tanggal Lahir</td>
                                          <td>:</td>
                                          <td class="detail_tanggal_lahir"></td>
                                      </tr>
                                      <tr>
                                          <td>Alamat</td>
                                          <td>:</td>
                                          <td class="detail_alamat"></td>
                                      </tr>
                                      <tr>
                                          <td>No. Telp</td>
                                          <td>:</td>
                                          <td class="badge badge-primary detail_notelp1"></td>
                                      </tr>
                                      <tr>
                                          <td>Nama Keluarga</td>
                                          <td>:</td>
                                          <td class="detail_nama_pj"></td>
                                      </tr>
                                      <tr>
                                          <td>No. Telp Keluarga</td>
                                          <td>:</td>
                                          <td class="badge badge-primary detail_notelp3"></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <input type="hidden" name="idpasien" id="idpasien">
                          <button type="button" class="btn btn-primary" id="btn_print">Print</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tanggal Resume Medis</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_chat" class="table table-hover table-sm display">
                                  <tbody>
                                      <tr>
                                          <td>Nama</td>
                                          <td>:</td>
                                          <td class="detail_nama">Nama</td>
                                      </tr>
                                      <tr>
                                          <td>No. Telp</td>
                                          <td>:</td>
                                          <td class="badge badge-primary detail_notelp1"></td>
                                      </tr>
                                      <tr>
                                          <td>Nama Keluarga</td>
                                          <td>:</td>
                                          <td class="detail_nama_pj"></td>
                                      </tr>
                                      <tr>
                                          <td>No. Telp Keluarga</td>
                                          <td>:</td>
                                          <td class="badge badge-primary detail_notelp3"></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>

                  </div>
              </form>
          </div>
      </div>
      <!-- Modal Create User -->
      <div class="modal fade" id="modal_create_user" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="tambah_user">
                      <div class="modal-body">
                          <input type="hidden" name="pasien_id" id="pasien_id">
                          <input type="hidden" id="id_user" name="id_user">
                          <input type="hidden" name="action_modal" id="action_modal" value="edit">
                          <input type="hidden" name="nama_akun" id="nama_akun">
                          <div class="form-group">
                              <label for="username">Username</label>
                              <input type="text" class="form-control rounded-0" id="username" name="username" placeholder="Username">
                              <small><span class="text-danger" id="error_username"></span></small>
                          </div>
                          <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Password">
                              <small><span class="text-danger" id="error_password"></span></small>
                          </div>
                          <div class="form-group">
                              <label for="password2">Ulangi Password</label>
                              <input type="password" class="form-control rounded-0" id="password2" name="password2" placeholder="Ulangi Password">
                              <small><span class="text-danger" id="error_password2"></span></small>
                          </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <div class="modal fade" id="hasilobservasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tanggal Resume Medis</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_hasil_observasi" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th class="text-center" style="width: 10%;">#</th>
                                          <!-- <th style="width: 5%;">No.</th> -->
                                          <th style="width: 20%;">Materi</th>
                                          <th style="width: 25%;">Waktu Akses</th>
                                          <!-- <th style="width: 40%;">Jenis Kelamin</th> -->
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <div class="modal fade" id="edukasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Riwayat Edukasi</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_edukasi" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%;">No.</th>
                                          <!-- <th style="width: 5%;"></th> -->
                                          <th style="width: 25%;">Materi</th>
                                          <th style="width: 25%;">Waktu Akses</th>
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <div class="modal fade" id="pernyataanTargetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Riwayat Target</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_pernyatan_target" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%;">No.</th>
                                          <!-- <th style="width: 5%;"></th> -->
                                          <th style="width: 25%;">Target</th>
                                          <th style="width: 25%;">Waktu Akses</th>
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <div class="modal fade" id="selfcontrolModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Selfcontrol</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_selfcontrol" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%;">No.</th>
                                          <!-- <th style="width: 5%;"></th> -->
                                          <th style="width: 25%;">Selfcontrol</th>
                                          <th style="width: 25%;">Waktu Akses</th>
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <div class="modal fade" id="terapiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Riwayat Terapi</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_terapi" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%;">No.</th>
                                          <!-- <th style="width: 5%;"></th> -->
                                          <th style="width: 25%;">Selfcontrol</th>
                                          <th style="width: 25%;">Waktu Akses</th>
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form method="post" id="form_print">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Riwayat Reminder</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="table-responsive">
                              <table id="tabel_reminder" class="table table-hover table-sm display">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%;">No.</th>
                                          <th style="width: 25%;">Waktu</th>
                                          <th style="width: 25%;">Keterangan</th>
                                          <th style="width: 10%;">Dibuat</th>
                                          <th style="width: 10%;">Status</th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <script>
          $(document).ready(function() {
              $('#loading').hide();

              // DataTable
              var dataTable = $('#tabel_pasien').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>pasien/tabelpasien",
                      "type": "POST",
                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2, 3, 4]
                  }],
                  autoWidth: !1,
                  language: {
                      search: "Cari",
                      paginate: {
                          "next": "<i class='ni ni-bold-right text-primary'></i>",
                          "previous": "<i class='ni ni-bold-left text-primary'></i>"
                      }
                  },
              });

              var dataTable2 = $('#tabel_rawatan').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>pasien/tabelrawatanpasien",
                      "type": "POST",
                      "data": function(data) {
                          data.id_pasien = $('#idpasien').val()
                      },
                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2, 3, 4]
                  }],
                  autoWidth: !1,
                  language: {
                      search: "Cari",
                      paginate: {
                          "next": "<i class='ni ni-bold-right text-primary'></i>",
                          "previous": "<i class='ni ni-bold-left text-primary'></i>"
                      }
                  },
              });

              // Edit Pasien
              $(document).on('click', '.buat_akun', function() {
                  var id = $(this).attr('id');
                  $('#error_password').text('');
                  $('#error_password2').text('');
                  $('#tambah_user')[0].reset();
                  $.ajax({
                      url: '<?php echo base_url(); ?>pasien/fetchSingleUser',
                      method: 'POST',
                      data: {
                          id: id
                      },
                      dataType: 'JSON',
                      success: function(data) {
                          $('#id_pasien').val(id);
                          $('#modal_create_user').modal('show');
                          $('.modal-title').text(data.nama_akun);
                          $('#pasien_id').val(id);
                          $('#id_user').val(data.id_user);
                          if (data.id_user == null) {
                              $('#action_modal').val('tambah')
                          } else {
                              $('#action_modal').val('edit')
                          }
                          $('#nama_akun').val(data.nama_akun);
                          $('#username').val(data.username);
                      }
                  });
              });

              // Tambah User
              $(document).on('submit', '#tambah_user', function(event) {
                  event.preventDefault();
                  //   var role_id = 41;
                  var username = $('#username').val();
                  var password = $('#password').val();
                  var password2 = $('#password2').val();
                  var error_role_id = $('#error_role_id').val();
                  var error_username = $('#error_username').val();
                  var error_password = $('#error_password').val();
                  var error_password2 = $('#error_password2').val();

                  if ($('#username').val() == '') {
                      error_username = 'Username tidak boleh kosong';
                      $('#error_username').text(error_username);
                      username = '';
                  } else {
                      error_username = '';
                      $('#error_username').text(error_username);
                      username = $('#username').val();
                  }
                  if ($('#password').val() == '') {
                      error_password = 'Password tidak boleh kosong';
                      $('#error_password').text(error_password);
                      password = '';
                  } else {
                      error_password = '';
                      $('#error_password').text(error_password);
                      password = $('#password').val();
                  }
                  if ($('#password2').val() == '') {
                      error_password2 = 'Konfirmasi Password tidak boleh kosong';
                      $('#error_password2').text(error_password2);
                      password2 = '';
                  } else {
                      error_password2 = '';
                      $('#error_password2').text(error_password2);
                      password2 = $('#password2').val();
                  }

                  if (error_username != '' || error_password != '' || error_password2 != '') {
                      toastr["error"]("Data Belum Lengkap!");
                  } else if (password != password2) {
                      toastr["error"]("Konfirmasi Password tidak sama!");
                  } else {
                      $.ajax({
                          url: '<?php echo base_url(); ?>pasien/tambahUser',
                          method: 'POST',
                          data: new FormData(this),
                          contentType: false,
                          processData: false,
                          dataType: 'JSON',
                          success: function(data) {
                              console.log('T', data);
                              $('#tambah_user')[0].reset();
                              $('#modal_create_user').modal('hide');
                              var result = data.metadata.result
                              if (result == 1) {
                                  Swal.fire({
                                      icon: 'error',
                                      title: 'Username sudah ada',
                                      showConfirmButton: false,
                                      timer: 1500
                                  })
                              } else {
                                  Swal.fire({
                                      icon: 'success',
                                      title: 'Status berhasil diubah',
                                      showConfirmButton: false,
                                      timer: 1500
                                  })
                              }

                          }
                      });
                  }
              });

              // rawatan_baru
              $(document).on('click', '.rawatan_baru', function() {
                  var id = $(this).attr('id');
                  window.open('<?= base_url(); ?>pasien/rawatanbaru/' + id);
              });

              // riwayat rawatan
              $(document).on('click', '.riwayat_rawatan', function() {
                  var id = $(this).attr('id');
                  var namapasien = $(this).attr('namapasien');
                  $('.modal-title').text(namapasien);
                  $('#idpasien').val(id);
                  dataTable2.ajax.reload();
                  $('#riwayatrawatanModal').modal('show');
              });

              // hasil observasi
              $(document).on('click', '.hasil_observasi', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTableHasilObservasi = $('#tabel_hasil_observasi').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelHasilObservasi",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#hasilobservasiModal').modal('show');
              });

              // edukasi
              $(document).on('click', '.riwayat_edukasi', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTableEdukasi = $('#tabel_edukasi').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelkontenedukasi",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#edukasiModal').modal('show');
              });

              // target
              $(document).on('click', '.pernyataan_target', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTablePernyataanTarget = $('#tabel_pernyatan_target').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelPernyataanTarget",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#pernyataanTargetModal').modal('show');
              });

              // selfcontrol
              $(document).on('click', '.selfcontrol', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTableSelfcontrol = $('#tabel_selfcontrol').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelSelfcontrol",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#selfcontrolModal').modal('show');
              });


              // terapi
              $(document).on('click', '.terapi', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTableTerapi = $('#tabel_terapi').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelTerapi",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#terapiModal').modal('show');
              });

              // reminder
              $(document).on('click', '.reminder', function() {
                  var id = $(this).attr('id');
                  //   var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');

                  dataTableReminder = $('#tabel_reminder').DataTable({
                      "serverSide": true,
                      "processing": true,
                      "showing": false,
                      "paging": false,
                      "ordering": false,
                      "searching": false,
                      "destroy": true,
                      "info": false,
                      "order": [],
                      "ajax": {
                          "url": "<?php echo base_url(); ?>pasien/tabelreminder",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pasien = id;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('.modal-title').text(namapasien);
                  //   $('#idpasien').val(id);
                  //   dataTable2.ajax.reload();
                  $('#reminderModal').modal('show');
              });




              // detail pasien
              $(document).on('click', '.detail_pasien', function() {
                  var id = $(this).attr('id');
                  var namapasien = $(this).attr('namapasien');
                  $('.modal-title').text(namapasien);
                  $('#idpasien').val(id);
                  $.ajax({
                      url: '<?php echo base_url(); ?>pasien/fetchSinglePasien',
                      method: 'POST',
                      data: {
                          id: id
                      },
                      dataType: 'json',
                      success: function(data) {
                          $('#detailpasienModal').modal('show');
                          console.log(data);
                          $('.detail_nama').text(data.nama);
                          $('.detail_nik').text(data.nik);
                          $('.detail_no_mr').text(data.no_mr);
                          $('.detail_jenis_kelamin').text(data.jenis_kelamin);
                          $('.detail_tanggal_lahir').text(data.tanggal_lahir);
                          $('.detail_alamat').text(data.alamat);
                          $('.detail_notelp1').text(data.notelp1);
                          $('.detail_nama_pj').text(data.nama_pj);
                          $('.detail_notelp3').text(data.notelp3);
                      }
                  });

              });

              // detail pasien
              $(document).on('click', '.chat', function() {
                  var id = $(this).attr('id');
                  var namapasien = $(this).attr('namapasien');
                  $('.modal-title').text(namapasien);
                  $('#idpasien').val(id);
                  $.ajax({
                      url: '<?php echo base_url(); ?>pasien/fetchSinglePasien',
                      method: 'POST',
                      data: {
                          id: id
                      },
                      dataType: 'json',
                      success: function(data) {
                          $('#chatModal').modal('show');
                          console.log(data);
                          $('.detail_nama').text(data.nama);
                          $('.detail_nik').text(data.nik);
                          $('.detail_no_mr').text(data.no_mr);
                          $('.detail_jenis_kelamin').text(data.jenis_kelamin);
                          $('.detail_tanggal_lahir').text(data.tanggal_lahir);
                          $('.detail_alamat').text(data.alamat);
                          $('.detail_notelp1').text(data.notelp1);
                          $('.detail_nama_pj').text(data.nama_pj);
                          $('.detail_notelp3').text(data.notelp3);
                      }
                  });

              });

              // kontak pasien
              $(document).on('click', '.detail_notelp1', function() {
                  var noHp = $('.detail_notelp1').text();

                  window.open('https://wa.me/' + noHp);
              });

              $(document).on('click', '.detail_notelp3', function() {
                  var noHp = $('.detail_notelp3').text();

                  window.open('https://wa.me/' + noHp);
              });

              $(document).on("click", ".ubahstatus", function() {
                  let id = $(this).attr('id')
                  let status = $(this).attr('status')
                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: "Upload file nilai ini?",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>blog/ubahstatusblog',
                              method: 'POST',
                              data: {
                                  id: id,
                                  status: status
                              },
                              success: function(data) {
                                  // console.log(data);
                                  Swal.fire({
                                      icon: 'success',
                                      title: 'Status berhasil diubah',
                                      showConfirmButton: false,
                                      timer: 1500
                                  })
                                  dataTable.ajax.reload();
                              }
                          });
                      }
                  })

              })


          });
      </script>