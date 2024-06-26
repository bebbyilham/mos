  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0"><?= $title; ?></h6>
          </div>
          <div class="col-lg-6 col-5 text-right">
            <a href="<?php echo base_url(); ?>edukasi" class="tambah_edukasi btn btn-sm btn-neutral">Kembali</a>
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
      <div class="col">
        <div class="card shadow-sm">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Tambah Data</h3>
              </div>
              <div class="col-4 text-right">
                <button type="button" id="simpan_edukasi" class="btn btn-sm btn-primary">Simpan</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form>
              <h6 class="heading-small text-muted mb-4">Konten</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label" for="judul">Judul</label>
                      <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul">
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="urutan">Urutan</label>
                      <input type="number" id="urutan" name="urutan" class="form-control" placeholder="Urutan Konten">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">Jenis</label>
                      <div class="input-group">
                        <select class="custom-select rounded-0" id="jenis" name="jenis">
                          <option value="text">Text</option>
                          <option value="video">Video</option>
                          <option value="Gambar">Gambar</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
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
                </div>
              </div>
              <hr class="my-4" />
              <!-- Description -->
              <h6 class="heading-small text-muted mb-4">Deskripsi</h6>
              <div class="pl-lg-4">
                <div class="form-group">
                  <label class="form-control-label" for="description">Isi Konten</label>
                  <textarea class="form-control rounded-0" id="description" name="description" rows="6" placeholder="Catatan Hasil Pemeriksaan Keseluruhan"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Create User -->
    <div class="modal fade" id="modal_tambah_edukasi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-primary"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- <form method="post" id="tambah_user">
                      <div class="modal-body">
                          <input type="hidden" name="pegawai_id" id="pegawai_id">
                          <input type="hidden" id="id_user" name="id_user">
                          <input type="hidden" name="action_modal" id="action_modal" value="edit">
                          <input type="hidden" name="nama_akun" id="nama_akun">
                          <div class="form-group">
                              <label for="judul">Judul</label>
                              <input type="text" class="form-control rounded-0" id="judul" name="judul" placeholder="Judul">
                          </div>
                          <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Password">
                          </div>
                          <div class="form-group">
                              <label for="password2">Ulangi Password</label>
                              <input type="password" class="form-control rounded-0" id="password2" name="password2" placeholder="Ulangi Password">
                          </div>
                          <div class="form-group">
                              <label for="role_id">Role</label>
                              <select class="custom-select rounded-0" id="role_id" name="role_id"></select>
                          </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                  </form> -->
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $('#loading').hide();
        //   $("#deskripsi").summernote('code', '');
        $('#description').summernote({
          toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['table']],
          ],
        });

        $.ajax({
          url: "<?php echo base_url(); ?>administrator/getAllCreators",
          method: "POST",
          dataType: 'JSON',
          success: function(data) {
            console.log(data);
            var html = '';
            var i;
            html += '<option selected value="0">Pilih Kreator</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            }
            $('#creator').html(html);
            $('#creator').selectpicker('refresh');
          }
        });
        // DataTable
        var dataTable = $('#tabel_edukasi').DataTable({
          "serverSide": true,
          "responsive": true,
          "pageLength": 25,
          "order": [],
          "ajax": {
            "url": "<?php echo base_url(); ?>edukasi/tabeledukasi",
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

        // Edit Pegawai
        $('#simpan_edukasi').on('click', function() {
          var judul = $('#judul').val()
          var jenis = $('#jenis').val()
          var urutan = $('#urutan').val()
          var description = $('#description').val()
          var status = $('#status').val();

          if (judul == '' || jenis == '' || urutan == '' || urutan == '0' || description == '' || status == '') {
            console.log('data belum lengkap');
            Swal.fire({
              icon: 'error',
              title: 'Data belum lengkap!',
              text: 'Mohon lengkapi data terlebih dahulu',
            });
          } else {
            $.ajax({
              url: '<?php echo base_url(); ?>administrator/simpanedukasi',
              method: 'POST',
              data: {
                judul: judul,
                jenis: jenis,
                urutan: urutan,
                description: description,
                status: status,
              },
              success: function(data) {
                console.log(data);
                Swal.fire({
                  icon: 'success',
                  title: 'Data berhasil disimpan',
                  showConfirmButton: false,
                  timer: 1500
                })
                window.location.href = "<?php base_url(); ?>edukasi/";
              }
            });
          }

        });
      });
    </script>