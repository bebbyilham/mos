  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="tambah_akses_kuesioner" class="btn btn-sm btn-neutral">Tambah</button>
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
                          <table id="tabel_kuesioner" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 5%;"></th>
                                      <th style="width: 25%;">Kuesioner</th>
                                      <th style="width: 25%;">Waktu</th>
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
      <div class="modal fade" id="modal_akses_kuesioner" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_akses_kuesioner">
                      <div class="modal-body">
                          <div class="form-group">
                              <input type="hidden" name="id_user" id="id_user" value="<?php echo $user['id_user'] ?>">
                              <input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $user['pasien_id'] ?>">
                              <input type="hidden" name="pilih_kuesioner" id="pilih_kuesioner" value="Self-examination Relaxation">
                              <label class="form-control-label" for="input-last-name">Pilih</label>
                              <div class="input-group">
                                  <select class="form-control rounded-0 selecpicker" id="kuesioner" name="kuesioner" data-live-search="true"></select>
                              </div>
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
              // DataTable
              var dataTable = $('#tabel_kuesioner').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>kuesioner/tabelkuesioner",
                      "type": "POST",
                      "data": function(data) {
                          data.id_user = <?= $user['id_user']; ?>,
                              data.tipe = 0
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
              var getkuesioner = $('#pilih_kuesioner').val();
              $.ajax({
                  url: "<?php echo base_url(); ?>kuesioner/getKuesionerPretest",
                  method: "POST",
                  dataType: 'JSON',
                  data: {
                      kuesioner: getkuesioner,
                  },
                  success: function(data) {
                      console.log(data);
                      var html = '';
                      var i;

                      for (i = 0; i < data.length; i++) {
                          html += '<option value="' + data[i].id + '">' + data[i].keterangan + '</option>';
                      }
                      $('#kuesioner').html(html);
                      $('#kuesioner').selectpicker('refresh');
                  }
              });

              // akses 
              $('#tambah_akses_kuesioner').on('click', function() {

                  $('#modal_akses_kuesioner').modal('show');
                  $('.modal-title').text('Tambah');
              });

              $(document).on('click', '.akses_kuesioner', function() {
                  var id = $(this).attr('id');
                  window.open('<?= base_url(); ?>kuesioner/akseskuesioner/' + id);
              });

              //submit
              $(document).on('submit', '#form_akses_kuesioner', function(event) {
                  event.preventDefault();
                  kuesioner = $('#kuesioner').val();

                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: '',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>kuesioner/simpanAkseskuesioner',
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
                                  $('#modal_akses_kuesioner').modal('hide');
                                  $('#form_akses_kuesioner')[0].reset();
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
                              url: '<?php echo base_url(); ?>kuesioner/ubahStatusAksesSelcontrol',
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