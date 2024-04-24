 <?php
    class Edukasi_model extends CI_Model
    {

        //tabel akses materi
        var $order_column = array(null, 'name', null, 'status', 'created_at', null);
        public function make_query_blog()
        {
            // $id_pasien = $_POST['idpasien'];
            $this->db->select('*');
            // $this->db->where('jenis_layanan', 2);
            $this->db->from('blogs');
            if (($_POST["search"]["value"])) {
                $this->db->like('no_registrasi', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('id', 'ASC');
            }
        }


        public function make_datatables_blog()
        {
            $this->make_query_blog();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_blog()
        {
            $this->make_query_blog();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_blog()
        {
            $this->db->select("*");
            $this->db->from('blogs');
            return $this->db->count_all_results();
        }
        //end blog

        public function simpan_akses_materi($data)
        {
            $this->db->insert('akses_materi', $data);
        }
        public function simpan_image_blog($data)
        {
            $this->db->insert('image_blogs', $data);
        }
        public function ubah_status_blog($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('blogs', $data);
        }
        public function hapus_image_blog($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('image_blogs');
        }

        public function fetch_all_materis()
        {
            $query = $this->db->get('konten_edukasi');
            return $query->result();
        }

        //tabel konten edukasi
        var $order_columnKE = array(null, 'judul', null, 'status', 'created_at', null);
        public function make_query_akses_materi()
        {
            $this->db->select('
            akses_materi.id,
            akses_materi.status,
            akses_materi.created_at,
            akses_materi.updated_at,
            konten_edukasi.judul
            ');
            $this->db->where('id_user', $_POST['id_user']);
            $this->db->from('akses_materi');
            $this->db->join('konten_edukasi', 'konten_edukasi.id = akses_materi.id_konten_edukasi', 'LEFT');
            if (($_POST["search"]["value"])) {
                $this->db->like('id_konten_edukasi', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_columnKE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('akses_materi.id', 'ASC');
            }
        }


        public function make_datatables_akses_materi()
        {
            $this->make_query_akses_materi();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_akses_materi()
        {
            $this->make_query_akses_materi();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_akses_materi()
        {
            $this->db->select("*");
            $this->db->from('akses_materi');
            return $this->db->count_all_results();
        }
        //end edukasi

        public function simpan_pilih_jawaban($data)
        {
            $this->db->insert('pilih_jawaban_edukasi', $data);
        }

        public function update_pilih_jawaban($data, $id_akses_materi, $id_pertanyaan)
        {
            $this->db->where('id_akses_materi', $id_akses_materi);
            $this->db->where('id_pertanyaan', $id_pertanyaan);
            $this->db->update('pilih_jawaban_edukasi', $data);
        }

        //tabel kontak
        var $order_columnKEP = array(null, 'nama', null,);
        public function make_query_kontak_petugas()
        {
            $this->db->select('
            pegawai.nama_pegawai,
            pegawai.hp_pegawai,
            pegawai.gelar_depan,
            pegawai.gelar_belakang
            ');
            // $this->db->where('id_list_edukasi', $_POST['id_konten_edukasi']);
            $this->db->from('pegawai');
            if (($_POST["search"]["value"])) {
                $this->db->like('nama_pegawai', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_columnKEP[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('id_pegawai', 'ASC');
            }
        }


        public function make_datatables_kontak_petugas()
        {
            $this->make_query_kontak_petugas();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_kontak_petugas()
        {
            $this->make_query_kontak_petugas();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_kontak_petugas()
        {
            $this->db->select("*");
            $this->db->from('pegawai');
            return $this->db->count_all_results();
        }
        //end edukasi pertanyaan

        public function simpan_selesai_akses_materi($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('akses_materi', $data);
        }

        public function fetch_single_konten($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get('konten_edukasi');
            return $query->result();
        }
    }
    ?>