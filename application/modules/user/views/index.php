  <!-- Header -->
  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Profil</h6>
                      <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                              <!-- <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                              <li class="breadcrumb-item"><a href="#">Dashboards</a></li> -->
                              <!-- <li class="breadcrumb-item active" aria-current="page">Profil</li> -->
                          </ol>
                      </nav>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                      <!-- <a href="#" class="btn btn-sm btn-neutral">New</a>
                      <a href="#" class="btn btn-sm btn-neutral">Filters</a> -->
                  </div>
              </div>
              <!-- Card stats -->

          </div>
      </div>
  </div>
  <div class="container-fluid mt--6 shadow-sm">
      <h4 class="font-weight m-1"><?= $title; ?></h4>
      <div class="row">
          <div class="col-lg-12">
              <?= $this->session->flashdata('message'); ?>
          </div>
      </div>
      <div class="row">

      </div>
      <div class="card">
          <div class="mx-auto my-4" style="width: 10rem;">
              <img src="<?= base_url('assets/img/'); ?>default.png" class="card-img mb-4 rounded-circle">
          </div>
          <div class="text-center">
              <div class="col">
                  <div class="card-body ">
                      <p class="card-text"><?= $user['nama_akun']; ?></p>
                      <p class="card-text"><small class="text-muted"></small></p>
                  </div>
              </div>
              <div class="row  p-2">
                  <div class="col-6">
                      <div class="card">
                          <!-- Card image -->
                          <img class="card-img-top" src="<?= base_url('assets/img/'); ?>alur_mos.png" alt="Image placeholder">
                          <!-- Card body -->
                          <div class="card-body">
                              <small class="text-muted">Gambar Alur MOS</small>
                          </div>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="card">
                          <!-- Card image -->
                          <div class="embed-responsive embed-responsive-21by9">
                              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/bJP8FuwkJb8?si=9ZcWOvB6PGbOViy4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                          </div>

                          <!-- Card body -->
                          <div class="card-body">
                              <small class="text-muted">Video Alur Program MOS</small>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>