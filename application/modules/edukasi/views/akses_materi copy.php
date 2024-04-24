  <?php
    // $role_id = $this->session->userdata('role_id');
    $queryEdukasi = "SELECT konten_edukasi.id AS id_konten_edukasi,
                            konten_edukasi.judul,
                            list_konten_edukasi.link,
                            list_konten_edukasi.id AS id_list_edukasi
                FROM konten_edukasi 
                JOIN list_konten_edukasi 
                ON konten_edukasi.id = list_konten_edukasi.id_edukasi
                WHERE list_konten_edukasi.id_edukasi = $idk
              ORDER BY list_konten_edukasi.id ASC
                ";
    $edk = $this->db->query($queryEdukasi)->result_array();
    ?>
  <!-- Header -->
  <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="tambah_akses_materi" class="btn btn-sm btn-neutral">Tambah</button>
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
                      <?php foreach ($edk as $e) : ?>
                          <h3><?php echo $e['judul']; ?></h3>

                          <?php
                            $konten_id = $e['id_list_edukasi'];
                            $queryPertanyaan = "SELECT  
                            pertanyaan_konten_edukasi.id AS id_pertanyaan,
                            pertanyaan_konten_edukasi.id_list_edukasi,
                            pertanyaan_konten_edukasi.jenis,
                            pertanyaan_konten_edukasi.pertanyaan,
                            pertanyaan_konten_edukasi.keterangan,
                            pertanyaan_konten_edukasi.urutan,
                            pertanyaan_konten_edukasi.status
                            FROM pertanyaan_konten_edukasi 

                            WHERE pertanyaan_konten_edukasi.id_list_edukasi = $konten_id
                            ORDER BY pertanyaan_konten_edukasi.id ASC
                            ";
                            $pert = $this->db->query($queryPertanyaan)->result_array();
                            $no_pertanyaan = 0;
                            ?>

                          <?php foreach ($pert as $p) :
                                $no_pertanyaan++;
                            ?>

                              <h4><?php echo $no_pertanyaan . '. ' . $p['pertanyaan']; ?></h4>

                              <?php
                                $pertanyaan_id = $p['id_pertanyaan'];
                                $queryJawaban = "SELECT
                              jawaban_konten_edukasi.id AS id_jawaban,
                              jawaban_konten_edukasi.id_pertanyaan,
                              jawaban_konten_edukasi.jawaban,
                              jawaban_konten_edukasi.status
                              FROM jawaban_konten_edukasi

                              WHERE jawaban_konten_edukasi.id_pertanyaan = $pertanyaan_id
                              ORDER BY jawaban_konten_edukasi.id ASC
                              ";
                                $jaw = $this->db->query($queryJawaban)->result_array();
                                $str = 65;
                                ?>

                              <?php foreach ($jaw as $j) :
                                    $alphabet_letter = chr($str);
                                ?>

                                  <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" id="customRadio<?php echo $j['id_jawaban']; ?>" name="customRadio<?php $j['id_jawaban'] ?>" class="custom-control-input">
                                      <label class="custom-control-label" for="customRadio<?php echo $j['id_jawaban']; ?>"><?php echo  $alphabet_letter . '. ' . $j['jawaban']; ?></label>
                                  </div>




                              <?php endforeach; ?>



                          <?php endforeach; ?>

                      <?php endforeach; ?>
                      <div class="data_materi">
                          <h1>======</h1>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                          <label class="custom-control-label" for="customRadioInline1">Toggle this custom radio</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                          <label class="custom-control-label" for="customRadioInline2">Or toggle this other custom radio</label>
                      </div>
                      <hr>
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
                      "url": "<?php echo base_url(); ?>edukasi/tabelkontenedukasi",
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

              function materi_edukasi() {
                  $.ajax({
                      url: "<?php echo base_url(); ?>edukasi/data_materi_edukasi",
                      method: "POST",
                      dataType: 'JSON',
                      data: {
                          id_materi_edukasi: <?= $idk; ?>,
                      },
                      success: function(data) {
                          console.log('T', data);
                          var data_materi = data.metadata.result.datamateri

                          $.each(data_materi, function(i, result) {
                              $('.data_materi').append(`
                               <p>` + data_materi[i]['judul'] + `</p>
                               <p>` + data_materi[i]['link'] + `</p>
                               <div class="materi-` + data_materi[i]['id_konten_edukasi'] + `">` + data_materi[i]['id_konten_edukasi'] + `
                               <div class="data_pertanyaan">
                               </div>
                               </div>
                                <hr>
                                `);
                              $.ajax({
                                  url: "<?php echo base_url(); ?>edukasi/datapertanyaan",
                                  method: "POST",
                                  dataType: 'JSON',
                                  data: {
                                      id_list_edukasi: data_materi[i]['id_list_edukasi'],
                                  },
                                  success: function(data) {
                                      console.log('P', data);
                                      var data_pertanyaan = data.metadata.result.datapertanyaan

                                      $.each(data_pertanyaan, function(i, result) {
                                          $('.data_pertanyaan').append(`
                                            
                                            <div class="pertanyaan-` + data_pertanyaan[i]['id'] + `">` + data_pertanyaan[i]['pertanyaan'] + `
                                            <div class="datapertanyaan"></div>
                                            </div>
                                            <hr>
                                            `);


                                      });




                                  }
                              });
                          });

                      }
                  });
              }

              function pertanyaan() {
                  $.ajax({
                      url: "<?php echo base_url(); ?>edukasi/data_pertanyaan",
                      method: "POST",
                      dataType: 'JSON',
                      data: {
                          id_materi_edukasi: <?= $idk; ?>,
                      },
                      success: function(data) {
                          console.log('T', data);
                          var data_materi = data.metadata.result.datamateri

                          $.each(data_materi, function(i, data_materi) {
                              $('.data_materi').append(`
                               <p>` + data_materi['judul'] + `</p>
                               <p>` + data_materi['link'] + `</p>
                               <div class=materi-` + data_materi['id_konten_edukasi'] + `>` + data_materi['id_konten_edukasi'] + `</div>
                                <hr>
                            `);


                          });

                      }
                  });
              }

              materi_edukasi()

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