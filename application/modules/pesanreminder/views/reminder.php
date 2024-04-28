  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="tambah_konten_metode" class="btn btn-sm btn-neutral">Tambah</button>
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
                      <h3 class="card-title">Data</h3>
                  </div>
                  <div class="card-body">
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
          </div>
      </div>
      <!-- Modal Create User -->
      <div class="modal fade" id="modal_reminder" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_reminder">
                      <div class="modal-body">
                          <div class="form-group">
                              <label class="form-control-label" for="input-last-name">Waktu</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" id="waktu" name="waktu" placeholder="Waktu" autocomplete="off">
                                  <div class="input-group-append">
                                      <span class="input-group-text">
                                          <span class="fa fa-calendar-alt"></span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="keterangan">Keterangan</label>
                              <input type="hidden" name="id_user" id="id_user" value="<?php echo $user['id_user'] ?>">
                              <input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $user['pasien_id'] ?>">
                              <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Isi keterangan">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <div class="text-right">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <script>
          $(document).ready(function() {
              $('#loading').hide();

              $('#waktu').datetimepicker({
                  timepicker: true,
                  datepicker: true,
                  scrollInput: false,
                  theme: 'success',
                  format: 'Y-m-d h:i:s',
                  // maxDate: '+2y',
              });
              // DataTable
              var dataTable = $('#tabel_reminder').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>pesanreminder/tabelreminder",
                      "type": "POST",
                      "data": function(data) {
                          data.id_user = <?= $user['id_user']; ?>
                      },
                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2, 4]
                  }],
                  autoWidth: !1,
                  language: {
                      search: "Cari"
                  },
              });


              $('#tambah_konten_metode').on('click', function() {

                  $('#modal_reminder').modal('show');
                  $('.modal-title').text('Tambah');
              });

              //submit konten
              $(document).on('submit', '#form_reminder', function(event) {
                  event.preventDefault();
                  var waktu = $('#waktu').val()
                  var keterangan = $('#keterangan').val()

                  if (waktu == '' || keterangan == '') {
                      Swal.fire({
                          icon: 'error',
                          title: 'Data belum lengkap!',
                          text: 'Mohon lengkapi data terlebih dahulu',
                      });
                  } else {
                      Swal.fire({
                          title: 'Apakah Kamu Yakin?',
                          text: "",
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          cancelButtonText: 'Batal',
                          confirmButtonText: 'Ya, Saya Yakin'
                      }).then((result) => {
                          if (result.isConfirmed) {
                              $.ajax({
                                  url: '<?php echo base_url(); ?>pesanreminder/simpanReminder',
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
                                      $('#modal_reminder').modal('hide');
                                      $('#form_reminder')[0].reset();
                                  }
                              });
                          }
                      })
                  }


              });

              // konten edukasi
              //   $(document).on('click', '.pertanyaan', function() {
              //       var id = $(this).attr('id');
              //       window.open('<?= base_url(); ?>administrator/listselfcontrolpertanyaan/' + id);
              //   });

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
                              url: '<?php echo base_url(); ?>pesanreminder/ubahstatusreminder',
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