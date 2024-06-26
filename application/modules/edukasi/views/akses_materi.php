  <!-- Header -->
  <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <!-- <button type="button" id="tambah_akses_materi" class="btn btn-sm btn-neutral">Tambah</button> -->
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
                      <h3 class="card-title">Akses Materi</h3>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_konten_edukasi" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 5%;"></th>
                                      <th style="width: 25%;">Materi</th>
                                      <!-- <th style="width: 25%;">Waktu Akses</th>
                                      <th style="width: 10%;">Status</th> -->
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal Create User -->
      <div class="modal fade" id="modal_akses_materi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_akses_materi">
                      <div class="modal-body">
                          <div class="form-group">
                              <input type="hidden" name="id_user" id="id_user" value="<?php echo $user['id_user'] ?>">
                              <input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $user['pasien_id'] ?>">
                              <label class="form-control-label" for="input-last-name">Materi</label>
                              <div class="input-group">
                                  <select class="form-control rounded-0 selecpicker" id="materi" name="materi" data-live-search="true"></select>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <div class="text-right">
                              <button type="submit" class="btn btn-primary ">Simpan</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal fade" id="modal_info_edukasi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="data_info">

                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script>
          $(document).ready(function() {
              $('#loading').hide();
              // DataTable
              var dataTable = $('#tabel_konten_edukasi').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>edukasi/tabeledukasi",
                      "type": "POST",
                      "data": function(data) {
                          data.id_user = <?= $user['id_user']; ?>
                      },

                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2]
                  }],
                  autoWidth: !1,
                  language: {
                      search: "Cari"
                  },
              });

              $.ajax({
                  url: "<?php echo base_url(); ?>edukasi/getAllmateris",
                  method: "POST",
                  dataType: 'JSON',
                  success: function(data) {
                      console.log(data);
                      var html = '';
                      var i;
                      html += '<option selected value="0">Pilih Materi</option>';
                      for (i = 0; i < data.length; i++) {
                          html += '<option value="' + data[i].id + '">' + data[i].judul + '</option>';
                      }
                      $('#materi').html(html);
                      $('#materi').selectpicker('refresh');
                  }
              });

              // akses materi
              $('#tambah_akses_materi').on('click', function() {

                  $('#modal_akses_materi').modal('show');
                  $('.modal-title').text('Tambah File');
              });

              $(document).on('click', '.akses_materi', function() {
                  var id_akses_materi = $(this).attr('id');
                  window.open('<?= base_url(); ?>edukasi/aksesmateri/' + id_akses_materi);
              });

              // info konten
              $(document).on('click', '.infoedukasi', function() {
                  var id = $(this).attr('id');
                  $('#modal_info_edukasi').modal('show');
                  $(".data_info").html("");


                  $.ajax({
                      url: '<?php echo base_url(); ?>edukasi/infoedukasi',
                      method: 'POST',
                      data: {
                          id: id
                      },
                      dataType: 'JSON',
                      success: function(data) {
                          $('.modal-title').text(data.judul);
                          $('.data_info').append(`
                            <div class="p-2">
                            <div class="text-center">` + data.link + `</div>
                            <div class="text-center"><h6>` + data.keterangan + `</h6></div>
                               <div>` + data.description + `</div>
                               </div>
                            `);
                      }
                  });
              });


              //submit image
              $(document).on('submit', '#form_akses_materi', function(event) {
                  event.preventDefault();
                  materi = $('#materi').val();

                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: "Akses materi" + materi,
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>edukasi/simpanaksesmateri',
                              method: 'POST',
                              data: new FormData(this),
                              contentType: false,
                              processData: false,
                              success: function(data) {
                                  Swal.fire({
                                      icon: 'success',
                                      title: 'Data berhasil ditambahkan',
                                      showConfirmButton: false,
                                      timer: 2000
                                  })
                                  dataTable.ajax.reload();
                                  $('#modal_akses_materi').modal('hide');
                                  $('#form_akses_materi')[0].reset();
                              }
                          });
                      }
                  })
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
                              url: '<?php echo base_url(); ?>administrator/ubahstatuskontenedukasi',
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

              $(document).on('click', '.delete', function() {
                  var id = $(this).attr('id');
                  var file = $(this).attr('file');
                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: "Hapus file ini?",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>blog/hapusimageblog',
                              method: 'POST',
                              data: {
                                  id: id,
                                  file: file,
                              },
                              success: function(data) {
                                  Swal.fire({
                                      icon: 'success',
                                      title: data,
                                      showConfirmButton: false,
                                      timer: 2000
                                  })
                                  dataTable.ajax.reload();
                              }
                          });
                      }
                  })
              });


          });
      </script>