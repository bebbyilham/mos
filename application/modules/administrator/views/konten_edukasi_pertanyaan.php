  <!-- Header -->
  <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="tambah_pertanyaan_konten" class="btn btn-sm btn-neutral">Tambah</button>
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
                      <h3 class="card-title">Daftar pertanyaan</h3>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_konten_edukasi_pertanyaan" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 25%;">Konten</th>
                                      <th style="width: 25%;">Keterangan</th>
                                      <th style="width: 10%;">Status</th>
                                      <th style="width: 10%;">Dibuat</th>
                                      <th style="width: 10%;">#</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal pertanyaan -->
      <div class="modal fade" id="modal_pertanyaan_konten" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_konten_edukasi_pertanyaan">
                      <div class="modal-body">
                          <input type="hidden" name="id_list_edukasi" id="id_list_edukasi" value="<?php echo $id_konten_edukasi ?>">
                          <div class="form-group">
                              <label class="form-control-label" for="input-last-name">Jenis</label>
                              <div class="input-group">
                                  <select class="custom-select rounded-0" id="jenis" name="jenis">
                                      <option value="radio">Pilihan ganda</option>
                                      <option value="text">Esai</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="pertanyaan">Pertanyaan</label>
                              <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3"></textarea>
                          </div>
                          <div class="form-group">
                              <label for="keterangan">Keterangan</label>
                              <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Isi keterangan video/gambar">
                          </div>
                          <div class="form-group">
                              <label for="urutan">Urutan</label>
                              <input type="number" id="urutan" name="urutan" class="form-control" placeholder="Isi urutan">
                          </div>
                          <div class="form-group">
                              <label class="form-control-label" for="input-last-name">Status</label>
                              <div class="input-group">
                                  <select class="custom-select rounded-0" id="status" name="status">
                                      <option value="draft">Draft</option>
                                      <option value="aktif">Aktif</option>
                                      <option value="non aktif">Non aktif</option>
                                  </select>
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

      <!-- Modal jawaban -->
      <div class="modal fade" id="modal_jawaban_konten" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_konten_edukasi_jawaban">
                      <div class="modal-body">
                          <input type="hidden" name="id_pertanyaan" id="id_pertanyaan">
                          <div class="form-group">
                              <label for="jawaban">Jawaban</label>
                              <textarea class="form-control" id="jawaban" name="jawaban" rows="3"></textarea>
                          </div>
                          <div class="form-group">
                              <label class="form-control-label" for="input-last-name">Status</label>
                              <div class="input-group">
                                  <select class="custom-select rounded-0" id="status_jawaban" name="status_jawaban">
                                      <option value="aktif">Aktif</option>
                                      <option value="draft">Draft</option>
                                      <option value="non aktif">Non aktif</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <div class="text-right">
                              <button type="submit" class="btn btn-primary ">Simpan</button>
                          </div>
                      </div>
                  </form>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="tabel_konten_edukasi_jawaban" class="table table-hover table-sm display">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">No.</th>
                                      <th style="width: 25%;">Jawaban</th>
                                      <th style="width: 10%;">Status</th>
                                      <th style="width: 10%;">Dibuat</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="modal_jawaban_betul" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title text-primary"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" id="form_jawaban_betul">
                      <div class="modal-body">
                          <input type="hidden" name="id_pertanyaan_betul" id="id_pertanyaan_betul">
                          <div class="form-group">
                              <label class="form-control-label" for="input-last-name">Pilih Jawaban</label>
                              <div class="input-group">
                                  <div class="input-group">
                                      <select class="form-control rounded-0 selecpicker" id="pilih_jawaban_betul" name="pilih_jawaban_betul" data-live-search="true"></select>
                                  </div>
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
      <script>
          $(document).ready(function() {
              $('#loading').hide();
              // DataTable
              var dataTable = $('#tabel_konten_edukasi_pertanyaan').DataTable({
                  "serverSide": true,
                  "responsive": true,
                  "pageLength": 25,
                  "order": [],
                  "ajax": {
                      "url": "<?php echo base_url(); ?>administrator/tabelkontenedukasiPertanyaan",
                      "type": "POST",
                      "data": function(data) {
                          data.id_konten_edukasi = <?= $id_konten_edukasi; ?>
                      },

                  },
                  columnDefs: [{
                      orderable: false,
                      targets: [0, 1, 2, 3, 4, 5]
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


              // pertanyaan
              $('#tambah_pertanyaan_konten').on('click', function() {

                  $('#modal_pertanyaan_konten').modal('show');
                  $('.modal-title').text('Tambah Data');
              });

              //submit pertanyaan
              $(document).on('submit', '#form_konten_edukasi_pertanyaan', function(event) {
                  event.preventDefault();
                  var id = $(this).attr('id');
                  var jenis = $('#jenis').val();
                  var pertanyaan = $('#pertanyaan').val();

                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: "Simpan konten",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>administrator/simpankontenedukasiPertanyaan',
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
                                  $('#modal_pertanyaan_konten').modal('hide');
                                  $('#form_konten_edukasi_pertanyaan')[0].reset();
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

              //   $(document).on('click', '.delete', function() {
              //       var id = $(this).attr('id');
              //       var file = $(this).attr('file');
              //       Swal.fire({
              //           title: 'Apakah Kamu Yakin?',
              //           text: "Hapus file ini?",
              //           icon: 'warning',
              //           showCancelButton: true,
              //           confirmButtonColor: '#3085d6',
              //           cancelButtonColor: '#d33',
              //           cancelButtonText: 'Batal',
              //           confirmButtonText: 'Ya, Saya Yakin'
              //       }).then((result) => {
              //           if (result.isConfirmed) {
              //               $.ajax({
              //                   url: '<?php echo base_url(); ?>blog/hapusimageblog',
              //                   method: 'POST',
              //                   data: {
              //                       id: id,
              //                       file: file,
              //                   },
              //                   success: function(data) {
              //                       Swal.fire({
              //                           icon: 'success',
              //                           title: data,
              //                           showConfirmButton: false,
              //                           timer: 2000
              //                       })
              //                       dataTable.ajax.reload();
              //                   }
              //               });
              //           }
              //       })
              //   });

              $(document).on('click', '.jawaban', function() {

                  $('#form_konten_edukasi_jawaban')[0].reset();
                  var id_pertanyaan = $(this).attr('id');
                  //   console.log('j', id_pertanyaan);
                  dataTableJawaban = $('#tabel_konten_edukasi_jawaban').DataTable({
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
                          "url": "<?php echo base_url(); ?>administrator/tabelkontenedukasiJawaban",
                          "type": "POST",
                          "data": function(data) {
                              data.id_pertanyaan = id_pertanyaan;
                          },
                      },
                      columnDefs: [{
                          orderable: !1,
                      }],
                      autoWidth: !1
                  });
                  $('#id_pertanyaan').val(id_pertanyaan);
                  $('#modal_jawaban_konten').modal('show');
                  $('.modal-title').text('Jawaban');
              });

              $(document).on('click', '.jawaban_betul', function() {

                  $('#form_konten_edukasi_jawaban')[0].reset();
                  var id_pertanyaan = $(this).attr('id');

                  $.ajax({
                      url: "<?php echo base_url(); ?>administrator/getAllJawaban",
                      method: "POST",
                      dataType: 'JSON',
                      data: {
                          id_pertanyaan: id_pertanyaan,
                      },
                      success: function(data) {
                          console.log(data);
                          var html = '';
                          var i;
                          //   html += '<option selected value="0">Pilih Jawaban</option>';
                          for (i = 0; i < data.length; i++) {
                              html += '<option value="' + data[i].id + '">' + data[i].jawaban + '</option>';
                          }
                          $('#pilih_jawaban_betul').html(html);
                          $('#pilih_jawaban_betul').selectpicker('refresh');
                      }
                  });

                  $.ajax({
                      url: "<?php echo base_url(); ?>administrator/getPertanyaan",
                      method: "POST",
                      dataType: 'JSON',
                      data: {
                          id_pertanyaan: id_pertanyaan,
                      },
                      success: function(data) {
                          console.log('PJ', data);

                          var code_pertanyaan = data.metadata.code
                          console.log('K', code_pertanyaan);
                          $('#pilih_jawaban_betul').selectpicker('refresh');
                          if (code_pertanyaan == 200) {

                              $('#pilih_jawaban_betul').val(data.metadata.result.datapertanyaan.jawaban_betul);
                              //   $('#pilih_jawaban_betul option:selected').val(data.metadata.result.datapertanyaan.jawaban_betul);
                              $('#pilih_jawaban_betul').selectpicker('refresh');
                          } else {
                              $('#pilih_jawaban_betul').selectpicker('refresh');
                          }


                          //   $('#pilih_jawaban_betul').selectpicker('refresh');
                      }
                  });

                  $('#id_pertanyaan_betul').val(id_pertanyaan);
                  $('#modal_jawaban_betul').modal('show');
                  $('.modal-title').text('Jawaban Betul');
              });

              $(document).on('submit', '#form_konten_edukasi_jawaban', function(event) {
                  event.preventDefault();
                  var jawaban = $('#jawaban').val();
                  var id_pertanyaan = $('#id_pertanyaan').val();
                  var status_jawaban = $('#status_jawaban').val();

                  if (jawaban == '') {
                      //   console.log('data belum lengkap');
                      Swal.fire({
                          icon: 'error',
                          title: 'Data belum lengkap!',
                          text: 'Mohon lengkapi data terlebih dahulu',
                      });
                  } else {
                      $.ajax({
                          url: '<?php echo base_url(); ?>administrator/simpankontenedukasiJawaban',
                          method: 'POST',
                          data: {
                              jawaban: jawaban,
                              id_pertanyaan: id_pertanyaan,
                              status_jawaban: status_jawaban,
                          },
                          success: function(data) {
                              //   console.log(data);
                              $('#jawaban').val('');
                              dataTableJawaban.ajax.reload();
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Data berhasil disimpan',
                                  showConfirmButton: false,
                                  timer: 1500
                              })
                          }
                      });
                  }
              });

              $(document).on('submit', '#form_jawaban_betul', function(event) {
                  event.preventDefault();
                  var jawaban = $('#pilih_jawaban_betul').val();
                  var id_pertanyaan = $('#id_pertanyaan_betul').val();

                  if (jawaban == '') {
                      //   console.log('data belum lengkap');
                      Swal.fire({
                          icon: 'error',
                          title: 'Data belum lengkap!',
                          text: 'Mohon lengkapi data terlebih dahulu',
                      });
                  } else {
                      $.ajax({
                          url: '<?php echo base_url(); ?>administrator/simpanJawabanBetul',
                          method: 'POST',
                          data: {
                              jawaban: jawaban,
                              id_pertanyaan: id_pertanyaan,
                          },
                          success: function(data) {
                              //   console.log(data);
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Data berhasil disimpan',
                                  showConfirmButton: false,
                                  timer: 1000
                              })
                              $('#modal_jawaban_betul').modal('hide');
                          }
                      });
                  }
              });

              $(document).on("click", ".statuspertanyaan", function() {
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
                              url: '<?php echo base_url(); ?>administrator/ubahstatuspertanyaan',
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