  <!-- Header -->
  <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <!-- <a href="<?php echo base_url(); ?>pasien/registrasi" class="tambah_blog btn btn-sm btn-neutral">Tambah</a> -->
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
                      <h3 class="card-title">Daftar Pasien Rawatan</h3>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_rawatan" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th class="text-center" style="width: 10%;">#</th>
                                      <!-- <th style="width: 5%;">No.</th> -->
                                      <th style="width: 25%;">Data Pasien</th>
                                      <th style="width: 20%;">Diagnosa</th>
                                      <!-- <th style="width: 40%;">Jenis Kelamin</th> -->
                                      <!-- <th style="width: 10%;">BI Score</th>
                                      <th style="width: 10%;">Alergi</th> -->
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="resumemedisModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <div class="form-group">
                              <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" name="tanggal_print" id="tanggal_print" data-target="#datetimepicker1" placeholder="Tanggal Resume Medis" autocomplete="off">
                                  <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                              </div>
                              <small><span class="text-danger" id="error_tanggal3"></span></small>
                          </div>
                          <!-- <div class="form-group">
							<input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan">
						</div>
						<div class="form-group">
							<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Pegawai">
						</div> -->
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <input type="hidden" name="idrawatan" id="idrawatan">
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
      <script>
          $(document).ready(function() {
              $('#loading').hide();
              $('#tanggal_print').datetimepicker({
                  timepicker: false,
                  datepicker: true,
                  scrollInput: false,
                  theme: 'success',
                  format: 'd-m-Y',
                  maxDate: '+2y',
              });
              // DataTable
              var dataTable = $('#tabel_rawatan').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>pasien/tabelrawatan",
                      "type": "POST",
                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2]
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

              // rawatan baru
              $(document).on('click', '.rawatan_baru', function() {
                  var id = $(this).attr('id');
                  window.open('<?= base_url(); ?>pasien/rawatanbaru/' + id);
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

              // kontak pasien
              $(document).on('click', '.detail_notelp1', function() {
                  var noHp = $('.detail_notelp1').text();

                  window.open('https://wa.me/' + noHp);
              });

              $(document).on('click', '.detail_notelp3', function() {
                  var noHp = $('.detail_notelp3').text();

                  window.open('https://wa.me/' + noHp);
              });

              // Print resume medis
              $(document).on('click', '.cetakresume', function() {
                  var id = $(this).attr('id');
                  var idpasien = $(this).attr('idpasien');
                  var namapasien = $(this).attr('namapasien');
                  $('#resumemedisModal').modal('show');
                  $('.modal-title').text(namapasien);
                  $('#idrawatan').val(id);
                  $('#idpasien').val(idpasien);
              });

              $(document).on('click', '#btn_print', function() {
                  var id = $('#idrawatan').val();
                  var idpasien = $('#idpasien').val();
                  var tgl = $('#tanggal_print').val();
                  var err = $('#error_tanggal').val();

                  if ($('#tanggal_print').val() == '') {
                      err = 'Tanggal tidak boleh kosong';
                      $('#error_tanggal').text(err);
                      tgl = '';
                  } else {
                      err = '';
                      $('#error_tanggal').text(err);
                      tgl = $('#tanggal_print').val();
                  }

                  if (err != '') {
                      Swal.fire({
                          icon: 'error',
                          title: 'Data belum lengkap!',
                          text: 'Mohon lengkapi data terlebih dahulu',
                      });
                  } else {
                      $('#resumemedisModal').modal('hide');
                      window.open('<?php echo base_url('pasien/cetakresume/'); ?>' + id + '/' + idpasien + '/' + tgl);
                  }
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