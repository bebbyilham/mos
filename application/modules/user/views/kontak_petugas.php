  <!-- Header -->
  <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <!-- <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="tambah_pertanyaan_konten" class="btn btn-sm btn-neutral">Tambah</button>
                  </div> -->
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
                      <h3 class="card-title">Daftar Kontak Petugas</h3>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_kontak" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 25%;">Nama</th>
                                      <th style="width: 25%;">No. Hp</th>
                                      <th style="width: 10%;">Aksi</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script>
          $(document).ready(function() {
              $('#loading').hide();
              // DataTable
              var dataTable = $('#tabel_kontak').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>user/tabelkontakPetugas",
                      "type": "POST",

                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2, 3]
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

              // kontak pasien
              $(document).on('click', '.hubungi', function() {
                  var noHp = $(this).attr('kontak');

                  window.open('https://wa.me/' + noHp);
              });



          });
      </script>