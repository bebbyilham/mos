  <?php
    // $role_id = $this->session->userdata('role_id');
    $queryEdukasi = "SELECT kuesioner.id AS id_kuesioner,
                            kuesioner.keterangan
                            -- list_kuesioner.link,
                            -- list_kuesioner.id AS id_kuesioner
                FROM kuesioner 
                -- JOIN list_kuesioner 
                -- ON kuesioner.id = list_kuesioner.id_kuesioner
               WHERE kuesioner.id = $idk
            --   ORDER BY list_kuesioner.id ASC
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
                      <button type="button" id="cetak" class="btn btn-sm btn-neutral">Cetak</button>
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
      <div id="hasil" class="row">
          <div class="col">
              <div class="card shadow-sm">
                  <div class="card-header">
                      <h3 class="card-title"><?php echo $namapasien; ?></h3>
                      <h3 class="card-title">Hasil kuesioner Pasien</h3>
                  </div>
                  <div class="card-body">
                      <?php foreach ($edk as $e) : ?>
                          <h3><?php echo $e['keterangan']; ?></h3>
                          <hr>

                          <?php
                            $queryListEdukasi = "SELECT  
                            list_kuesioner.id AS id_list_kuesioner,
                            list_kuesioner.id_kuesioner,
                            list_kuesioner.link,
                            list_kuesioner.jenis,
                            list_kuesioner.keterangan,
                            list_kuesioner.urutan,
                            list_kuesioner.status
                            
                            FROM list_kuesioner 

                            WHERE list_kuesioner.id_kuesioner = $idk
                            ORDER BY list_kuesioner.id ASC
                            ";
                            $qLe = $this->db->query($queryListEdukasi)->result_array();
                            ?>
                          <?php foreach ($qLe as $l) : ?>


                              <p><b> <?php echo $l['keterangan']; ?></b></p>
                              <?php
                                $konten_id = $l['id_list_kuesioner'];
                                $queryPertanyaan = "SELECT  
                                pertanyaan_kuesioner.id AS id_pertanyaan,
                                pertanyaan_kuesioner.id_list_kuesioner,
                                pertanyaan_kuesioner.jenis,
                                pertanyaan_kuesioner.pertanyaan,
                                pertanyaan_kuesioner.keterangan,
                                pertanyaan_kuesioner.urutan,
                                pertanyaan_kuesioner.status
                                FROM pertanyaan_kuesioner 

                                WHERE pertanyaan_kuesioner.id_list_kuesioner = $konten_id
                                ORDER BY pertanyaan_kuesioner.id ASC
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
                                jawaban_kuesioner.id AS id_jawaban,
                                jawaban_kuesioner.id_pertanyaan,
                                jawaban_kuesioner.jawaban,
                                jawaban_kuesioner.status
                                -- pilih_jawaban_edukasi.id_akses_kuesioner,
                                -- pilih_jawaban_edukasi.id_jawaban AS jawaban_pilih
                                FROM jawaban_kuesioner

                                -- LEFT JOIN pilih_jawaban_edukasi 
                                -- ON jawaban_kuesioner.id = pilih_jawaban_edukasi.id_jawaban
                                WHERE jawaban_kuesioner.id_pertanyaan = $pertanyaan_id 
                                -- AND pilih_jawaban_edukasi.id_akses_kuesioner = $id_akses_materi 
                                -- AND pilih_jawaban_edukasi.id_kuesioner = $idk 
                                ORDER BY jawaban_kuesioner.id ASC
                              ";
                                    $jaw = $this->db->query($queryJawaban)->result_array();
                                    $str = 65;
                                    ?>

                                  <?php foreach ($jaw as $j) :
                                        $alphabet_letter = chr($str);
                                    ?>

                                      <div class="custom-control custom-radio custom-control-inline">

                                          <input type="radio" <?= check_jawaban_kuesioner($pertanyaan_id, $id_akses_materi, $j['id_jawaban']); ?> id="customRadio<?php echo $j['id_jawaban']; ?>" id_jawaban="<?php echo $j['id_jawaban']; ?>" id_pertanyaan="<?php echo $j['id_pertanyaan']; ?>" id_akses_kuesioner="<?php echo $id_akses_materi; ?>" id_kuesioner="<?php echo $idk; ?>" id_user="<?php echo $user['id_user']; ?>" id_pasien="<?php echo $user['pasien_id']; ?>" name="customRadio<?php echo $j['id_pertanyaan'] ?>" class="custom-control-input pilih_jawaban">
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
              //   $('#hasil').find('input, textarea, button, select').attr('disabled', 'disabled');

              function printDiv() {

                  var divToPrint = document.getElementById('hasil');

                  var newWin = window.open('', 'Print-Window');

                  newWin.document.open();

                  newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                  newWin.document.close();

                  setTimeout(function() {
                      newWin.close();
                  }, 10);

              }

              $('#loading').hide();


              $(document).on("click", "#cetak", function() {
                  printDiv()
              });

              $(document).on("click", ".pilih_jawaban", function() {
                  var id_akses_kuesioner = $(this).attr('id_akses_kuesioner');
                  var id_kuesioner = $(this).attr('id_kuesioner');
                  var id_pertanyaan = $(this).attr('id_pertanyaan');
                  var id_jawaban = $(this).attr('id_jawaban');
                  var jawaban = $(this).attr('jawaban');

                  var id_user = $(this).attr('id_user');
                  var id_pasien = $(this).attr('id_pasien');

                  $.ajax({
                      url: '<?php echo base_url(); ?>kuesioner/simpanPilihJawabankuesioner',
                      method: 'POST',
                      data: {
                          id_akses_kuesioner: id_akses_kuesioner,
                          id_kuesioner: id_kuesioner,
                          id_pertanyaan: id_pertanyaan,
                          id_jawaban: id_jawaban,
                          id_user: id_user,
                          id_pasien: id_pasien,
                          jawaban: jawaban,
                      },
                      success: function(data) {
                          //   console.log('hj', data);
                          //   Swal.fire({
                          //       icon: 'success',
                          //       title: 'Jawaban dipilih',
                          //       showConfirmButton: false,
                          //       timer: 700
                          //   })
                      }
                  });
              });

              $(document).on("change paste keyup", ".jawaban_input", function() {
                  var id_akses_kuesioner = $(this).attr('id_akses_kuesioner');
                  var id_kuesioner = $(this).attr('id_kuesioner');
                  var id_pertanyaan = $(this).attr('id_pertanyaan');
                  var id_jawaban = $(this).attr('id_jawaban');
                  var jawaban = $(this).val();
                  //   var jawaban_type = $(this).attr('jawaban_type');

                  var id_user = $(this).attr('id_user');
                  var id_pasien = $(this).attr('id_pasien');

                  $.ajax({
                      url: '<?php echo base_url(); ?>kuesioner/simpanPilihJawabankuesioner',
                      method: 'POST',
                      data: {
                          id_akses_kuesioner: id_akses_kuesioner,
                          id_kuesioner: id_kuesioner,
                          id_pertanyaan: id_pertanyaan,
                          id_jawaban: id_jawaban,
                          id_user: id_user,
                          id_pasien: id_pasien,
                          jawaban: jawaban,
                      },
                      success: function(data) {
                          //   console.log('hj', data);
                          //   Swal.fire({
                          //       icon: 'success',
                          //       title: 'Jawaban dipilih',
                          //       showConfirmButton: false,
                          //       timer: 700
                          //   })
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
                              url: '<?php echo base_url(); ?>observasi/selesaiAkseskuesioner',
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