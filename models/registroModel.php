<?php

class RegistroModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param string $usuario
     * @return array $usuario[id,codigo]
     */
    public function verificarUsuario(string $usuario = "") {
        $sql = "SELECT id, codigo FROM usuario WHERE usuario = '$usuario'";
        $usuario = $this->getSQL($sql);
        return $usuario[0];
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
        debug($data['apellidos'],'$data["apellidos"]');
        //poner rol_id(2) si no viene
        if (!key_exists('rol_id', $data)) {
            $data['rol_id'] = 2;
        }


        //convertir password con Hash::getHash()
        $data['password'] = Hash::getHash('sha1', $data['password'], HASH_KEY);

        //codigo para email
        $random = rand(111111111, 999999999);
        $data['codigo'] = $random;

        $data['estado'] = USUARIO_ESTADO_NO_ACTIVADO;

        $this->insertarRegistro("usuario", $data);
    }

    public function getUsuario($id, $codigo) {
        $sql = "SELECT * FROM usuario WHERE id = $id AND codigo='$codigo'";
        $usuario = $this->getSQL($sql);

        return $usuario[0];
    }

    public function activarUsuario($id) {
        $campos = [
            'estado  ' => USUARIO_ESTADO_ACTIVADO
        ];

        $this->editarRegistro("usuario", $id, $campos);
    }

}
