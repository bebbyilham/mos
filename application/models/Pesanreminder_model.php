 <?php
    class Pesanreminder_model extends CI_Model
    {
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
            $this->db->where('profesi', 2);
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
        //end
    }
    ?>