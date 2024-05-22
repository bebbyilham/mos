 <?php
    class Kuesioner_model extends CI_Model
    {
        public function simpan_akses_kuesioner($data)
        {
            $this->db->insert('akses_kuesioner', $data);
        }

        public function fetch_all_kuesioner()
        {
            $query = $this->db->get('kuesioner');
            return $query->result();
        }

        public function fetch_kuesioner()
        {
            $this->db->where('metode', $_POST['metode']);
            $query = $this->db->get('kuesioner');
            return $query->result();
        }

        public function fetch_kuesioner_pretest()
        {
            $tipe = array('0', '3');
            // $this->db->where('tipe', 0);
            $this->db->where_in('tipe',  $tipe);
            $query = $this->db->get('kuesioner');
            return $query->result();
        }

        public function fetch_kuesioner_posttest()
        {
            $tipe = array('1', '3');
            // $this->db->where('tipe', 1);
            $this->db->where_in('tipe',  $tipe);
            $query = $this->db->get('kuesioner');
            return $query->result();
        }

        public function fetch_examination_relaxation()
        {
            $this->db->where('metode', 'Self-examination Relaxation');
            $query = $this->db->get('kuesioner');
            return $query->result();
        }

        //tabel akses kuesioner
        var $order_columnKE = array(null, 'metode', null, 'status', 'created_at', null);
        public function make_query_akses_kuesioner()
        {
            $tipe = array($_POST['tipe'], '3');
            // $this->db->where('tipe', 0);
            $this->db->select('
            akses_kuesioner.id,
            akses_kuesioner.status,
            akses_kuesioner.created_at,
            akses_kuesioner.updated_at,
            kuesioner.keterangan,
            kuesioner.tipe
            ');
            $this->db->where('id_user', $_POST['id_user']);
            $this->db->where_in('kuesioner.tipe',  $tipe);
            // $this->db->where('kuesioner.tipe', $_POST['tipe']);
            $this->db->from('akses_kuesioner');
            $this->db->join('kuesioner', 'kuesioner.id = akses_kuesioner.id_kuesioner', 'LEFT');
            if (($_POST["search"]["value"])) {
                $this->db->like('target', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_columnKE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('akses_kuesioner.id', 'ASC');
            }
        }


        public function make_datatables_akses_kuesioner()
        {
            $this->make_query_akses_kuesioner();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_akses_kuesioner()
        {
            $this->make_query_akses_kuesioner();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_akses_kuesioner()
        {
            $this->db->select("*");
            $this->db->from('akses_kuesioner');
            return $this->db->count_all_results();
        }
        //end target

        public function ubah_status_akses_kuesioner($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('akses_kuesioner', $data);
        }

        public function simpan_pilih_jawaban($data)
        {
            $this->db->insert('pilih_jawaban_kuesioner', $data);
        }

        public function update_pilih_jawaban($data, $id_akses_kuesioner, $id_pertanyaan)
        {
            $this->db->where('id_akses_kuesioner', $id_akses_kuesioner);
            $this->db->where('id_pertanyaan', $id_pertanyaan);
            $this->db->update('pilih_jawaban_kuesioner', $data);
        }
    }
    ?>