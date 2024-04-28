 <?php
    class Selfcontrol_model extends CI_Model
    {
        public function simpan_akses_selfcontrol($data)
        {
            $this->db->insert('akses_selfcontrol', $data);
        }

        public function fetch_all_selfcontrol()
        {
            $query = $this->db->get('self_control');
            return $query->result();
        }

        //tabel akses selfcontrol
        var $order_columnKE = array(null, 'metode', null, 'status', 'created_at', null);
        public function make_query_akses_selfcontrol()
        {
            $this->db->select('
            akses_selfcontrol.id,
            akses_selfcontrol.status,
            akses_selfcontrol.created_at,
            akses_selfcontrol.updated_at,
            self_control.metode
            ');
            $this->db->where('id_user', $_POST['id_user']);
            $this->db->from('akses_selfcontrol');
            $this->db->join('self_control', 'self_control.id = akses_selfcontrol.id_selfcontrol', 'LEFT');
            if (($_POST["search"]["value"])) {
                $this->db->like('target', $_POST["search"]["value"]);
            }

            if (isset($_POST["order"])) {
                $this->db->order_by($this->order_columnKE[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('akses_selfcontrol.id', 'ASC');
            }
        }


        public function make_datatables_akses_selfcontrol()
        {
            $this->make_query_akses_selfcontrol();

            if ($_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function get_filtered_data_akses_selfcontrol()
        {
            $this->make_query_akses_selfcontrol();
            $query = $this->db->get();

            return $query->num_rows();
        }

        public function get_all_data_akses_selfcontrol()
        {
            $this->db->select("*");
            $this->db->from('akses_selfcontrol');
            return $this->db->count_all_results();
        }
        //end target

        public function ubah_status_akses_selfcontrol($data, $id)
        {
            $this->db->where('id', $id);
            $this->db->update('akses_selfcontrol', $data);
        }

        public function simpan_pilih_jawaban($data)
        {
            $this->db->insert('pilih_jawaban_selfcontrol', $data);
        }

        public function update_pilih_jawaban($data, $id_akses_selfcontrol, $id_pertanyaan)
        {
            $this->db->where('id_akses_selfcontrol', $id_akses_selfcontrol);
            $this->db->where('id_pertanyaan', $id_pertanyaan);
            $this->db->update('pilih_jawaban_selfcontrol', $data);
        }
    }
    ?>