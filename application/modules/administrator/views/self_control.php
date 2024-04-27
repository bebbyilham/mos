  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <a href="<?php echo base_url(); ?>administrator/tambahselfControl" class="tambah_edukasi btn btn-sm btn-neutral">Tambah</a>
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
                          <table id="tabel_self_control" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 25%;">Edukasi</th>
                                      <th style="width: 40%;">Deskripsi</th>
                                      <th style="width: 10%;">Status</th>
                                      <th style="width: 10%;">Tanggal</th>
                                      <th class="text-center" style="width: 10%;">#</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="modal_info_pernyataan_target" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
              var dataTable = $('#tabel_self_control').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>administrator/tabelselfcontrol",
                      "type": "POST",
                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 2, 5]
                  }],
                  autoWidth: !1,
                  language: {
                      search: "Cari"
                  },
              });

              //metode
              $(document).on('click', '.metode', function() {
                  var id = $(this).attr('id');
                  window.open('<?= base_url(); ?>administrator/kontenmetode/' + id);
              });

              // info konten
              $(document).on('click', '.info', function() {
                  var id = $(this).attr('id');
                  $('#modal_info_pernyataan_target').modal('show');
                  $(".data_info").html("");


                  $.ajax({
                      url: '<?php echo base_url(); ?>administrator/infopernyataantarget',
                      method: 'POST',
                      data: {
                          id: id
                      },
                      dataType: 'JSON',
                      success: function(data) {
                          $('.modal-title').text(data.target);
                          $('.data_info').append(`
                               <div>` + data.description + `</div>
                            `);
                      }
                  });
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
                              url: '<?php echo base_url(); ?>administrator/ubahstatusedukasi',
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