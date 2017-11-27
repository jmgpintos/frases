<?php

class RegistroModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param string $usuario
     * @return boolean
     */
    public function verificarUsuario(string $usuario = "") {
        $sql = "SELECT id FROM usuario WHERE usuario = '$usuario'";
        $id = $this->getSQL($sql);

        if ($id) {
            return true;
        }

        return false;
    }

    /**
     * 
     * @param string $email
     * @return boolean
     */
    public function verificarEmail(string $email = "") {
        $sql = "SELECT id FROM usuario WHERE email= '$email'";
        $id = $this->getSQL($sql);

        if ($id) {
            return true;
        }

        return false;
    }

    /**
     * campos oligatorios: usuario, password, email, rol_id
     * fecha_alta -> Default: CURRENT_TIMESTAMP
     * @param array $data
     */
        public function registrarUsuario(array $data) {
            debug_fn(__METHOD__, [$data]);
        //poner rol_id(2) si no viene
        if (!key_exists('rol_id', $data)) {
            $data['rol_id'] = 2;
        }

        //convertir password con Hash::getHash()
        $data['password'] = Hash::getHash('sha1', $data['password'], HASH_KEY);

        $this->insertarRegistro("usuario", $data);
    }

}
