<?php

    class AcessoSalas {

        private $id;
        private $data_check;
        private $checado;
        private $id_reserva;

        public function __construct($id, $data_check, $checado, $id_reserva) 
        {
            $this->id = $id;
            $this->data_check = $data_check;
            $this->checado = $checado;
            $this->id_reserva = $id_reserva;
        }


        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getData_check() {
            return $this->data_check;
        }

        public function setData_check($data) {
            $this->data_check = $data;
        }

        public function getChecado() {
            return $this->checado;
        }

        public function setChecado($check) {
            $this->checado = $check;
        }

        public function getId_reserva() {
            return $this->id_reserva;
        }

        public function setId_reserva($id_reserva) {
            $this->id_reserva = $id_reserva;
        }
    }

?>