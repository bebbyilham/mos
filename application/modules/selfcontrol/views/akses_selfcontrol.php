  <?php
    // $role_id = $this->session->userdata('role_id');
    $queryEdukasi = "SELECT self_control.id AS id_self_control,
                            self_control.metode
                            -- list_self_control.link,
                            -- list_self_control.id AS id_selfcontrol
                FROM self_control 
                -- JOIN list_self_control 
                -- ON self_control.id = list_self_control.id_selfcontrol
               WHERE self_control.id = $idk
            --   ORDER BY list_self_control.id ASC
                ";
    $edk = $this->db->query($queryEdukasi)->result_array();
    ?>
  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <button type="button" id="selesai_akses_materi" class="btn btn-sm btn-neutral">Selesai</button>
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
                      <h3 class="card-title">Akses Selfcontrol</h3>
                  </div>
                  <div class="card-body">
                      <?php foreach ($edk as $e) : ?>
                          <h3><?php echo $e['metode']; ?></h3>
                          <hr>

                          <?php
                            $queryListEdukasi = "SELECT  
                            list_selfcontrol.id AS id_list_selfcontrol,
                            list_selfcontrol.id_selfcontrol,
                            list_selfcontrol.link,
                            list_selfcontrol.jenis,
                            list_selfcontrol.keterangan,
                            list_selfcontrol.urutan,
                            list_selfcontrol.status
                            
                            FROM list_selfcontrol 

                            WHERE list_selfcontrol.id_selfcontrol = $idk
                            ORDER BY list_selfcontrol.id ASC
                            ";
                            $qLe = $this->db->query($queryListEdukasi)->result_array();
                            ?>
                          <?php foreach ($qLe as $l) : ?>

                              <?php echo $l['keterangan'] ?>

                              <?php
                                $konten_id = $l['id_list_selfcontrol'];
                                $queryPertanyaan = "SELECT  
                                pertanyaan_selfcontrol.id AS id_pertanyaan,
                                pertanyaan_selfcontrol.id_list_selfcontrol,
                                pertanyaan_selfcontrol.jenis,
                                pertanyaan_selfcontrol.pertanyaan,
                                pertanyaan_selfcontrol.keterangan,
                                pertanyaan_selfcontrol.urutan,
                                pertanyaan_selfcontrol.status
                                FROM pertanyaan_selfcontrol 

                                WHERE pertanyaan_selfcontrol.id_list_selfcontrol = $konten_id
                                ORDER BY pertanyaan_selfcontrol.id ASC
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
                                jawaban_self_control.id AS id_jawaban,
                                jawaban_self_control.id_pertanyaan,
                                jawaban_self_control.jawaban,
                                jawaban_self_control.status
                                -- pilih_jawaban_edukasi.id_akses_selfcontrol,
                                -- pilih_jawaban_edukasi.id_jawaban AS jawaban_pilih
                                FROM jawaban_self_control

                                -- LEFT JOIN pilih_jawaban_edukasi 
                                -- ON jawaban_self_control.id = pilih_jawaban_edukasi.id_jawaban
                                WHERE jawaban_self_control.id_pertanyaan = $pertanyaan_id 
                                -- AND pilih_jawaban_edukasi.id_akses_selfcontrol = $id_akses_selfcontrol 
                                -- AND pilih_jawaban_edukasi.id_selfcontrol = $idk 
                                ORDER BY jawaban_self_control.id ASC
                              ";
                                    $jaw = $this->db->query($queryJawaban)->result_array();
                                    $str = 65;
                                    ?>

                                  <?php foreach ($jaw as $j) :
                                        $alphabet_letter = chr($str);
                                    ?>

                                      <div class="custom-control custom-radio custom-control-inline">

                                          <input type="radio" <?= check_jawaban_selfcontrol($pertanyaan_id, $id_akses_selfcontrol, $j['id_jawaban']); ?> id="customRadio<?php echo $j['id_jawaban']; ?>" id_jawaban="<?php echo $j['id_jawaban']; ?>" id_pertanyaan="<?php echo $j['id_pertanyaan']; ?>" id_akses_selfcontrol="<?php echo $id_akses_selfcontrol; ?>" id_selfcontrol="<?php echo $idk; ?>" id_user="<?php echo $user['id_user']; ?>" id_pasien="<?php echo $user['pasien_id']; ?>" name="customRadio<?php echo $j['id_pertanyaan'] ?>" class="custom-control-input pilih_jawaban">
                                          <label class="custom-control-label" for="customRadio<?php echo $j['id_jawaban']; ?>"><?php echo  $j['jawaban']; ?></label>


                                      </div>




                                  <?php endforeach; ?>
                                  <hr>


                              <?php endforeach; ?>
                          <?php endforeach; ?>

                      <?php endforeach; ?>


                  </div>
              </div>
          </div>
      </div>

      <script>
          $(document).ready(function() {

              $('#loading').hide();
              // DataTable
              var dataTable = $('#tabel_selfcontrol').DataTable({
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

              $(document).on("click", ".pilih_jawaban", function() {
                  var id_akses_selfcontrol = $(this).attr('id_akses_selfcontrol');
                  var id_selfcontrol = $(this).attr('id_selfcontrol');
                  var id_pertanyaan = $(this).attr('id_pertanyaan');
                  var id_jawaban = $(this).attr('id_jawaban');

                  var id_user = $(this).attr('id_user');
                  var id_pasien = $(this).attr('id_pasien');

                  $.ajax({
                      url: '<?php echo base_url(); ?>selfcontrol/simpanPilihJawaban',
                      method: 'POST',
                      data: {
                          id_akses_selfcontrol: id_akses_selfcontrol,
                          id_selfcontrol: id_selfcontrol,
                          id_pertanyaan: id_pertanyaan,
                          id_jawaban: id_jawaban,
                          id_user: id_user,
                          id_pasien: id_pasien,
                      },
                      success: function(data) {
                          //   console.log('hj', data);
                          Swal.fire({
                              icon: 'success',
                              title: 'Jawaban dipilih',
                              showConfirmButton: false,
                              timer: 700
                          })
                      }
                  });
              });

              $('#selesai_akses_materi').on('click', function() {

                  Swal.fire({
                      title: 'Apakah Kamu Yakin?',
                      text: "Selesaikan materi",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Batal',
                      confirmButtonText: 'Ya, Saya Yakin'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              url: '<?php echo base_url(); ?>selfcontrol/selesaiAksesSelfcontrol',
                              method: 'POST',
                              data: {
                                  id: <?= $idakses; ?>,
                              },
                              success: function(data) {
                                  // console.log(data);
                                  Swal.fire({
                                      icon: 'success',
                                      title: 'Status akses berhasi diubah',
                                      showConfirmButton: false,
                                      timer: 1500
                                  })
                                  window.close();
                              }
                          });
                      }
                  })


              });

          });
      </script>