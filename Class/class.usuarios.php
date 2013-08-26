<?PHP
class usuarios {
	var $Usuario;
	var $password;
	var $Nombre;
	var $Nivel;
	var $Activo;
	var $conectas;

	function __construct() {
		$this->conectas = new ClaseConexion();
		$this->conectas->Conectar(); 
	}
	public function Lista() {
		$sql = "select * from usuarios";
		$res = $this->conectas->EjecutaConsulta($sql);
		while($row=mysql_fetch_array($res)) {
			$c = new usuarios();
			$c->Usuario= $row["Usuario"];
			$c->password= $row["password"];
			$c->Nombre= $row["Nombre"];
			$c->Nivel= $row["Nivel"];
			$c->Activo= $row["Activo"];
			$array[] = $c;
		}
		return $array;
	}

	public function ListaJSON() {
		$data = $this->Lista();
		return json_encode($data);
	}

	public function ListarUsuario($UsuarioId) {
		$this->Usuario = $UsuarioId;
		$sql = "select * from usuarios where Usuario=$UsuarioId";
		$res = $this->conectas->EjecutaConsulta($sql);
		while($row=mysql_fetch_array($res)) {
			$this->Usuario= $row["Usuario"];
			$this->password= $row["password"];
			$this->Nombre= $row["Nombre"];
			$this->Nivel= $row["Nivel"];
			$this->Activo= $row["Activo"];
		}
	}

	public function ListarUsuarioJSON($UsuarioId) {
		$data = $this->Lista($UsuarioId);
		return json_encode($data);
	}
	public function Where($vars) {
		$sql = "select * from usuarios where $vars";
		$res = $this->conectas->EjecutaConsulta($sql);
		while($row=mysql_fetch_array($res)) {
			$c = new usuarios();
			$c->Usuario= $row["Usuario"];
			$c->password= $row["password"];
			$c->Nombre= $row["Nombre"];
			$c->Nivel= $row["Nivel"];
			$c->Activo= $row["Activo"];
			$array[] = $c;
		}
		return $array;
	}

	public function WhereJSON($vars) {
		$data = $this->Where($vars);
		return json_encode($data);
	}

	public function Add() {
		$sql = "INSERT INTO usuarios (Usuario,password,Nombre,Nivel,Activo)"; 
		$sql.= "VALUES('".$this->Usuario."','".$this->password."','".$this->Nombre."','".$this->Nivel."','".$this->Activo."')";
		$res = $this->conectas->EjecutaConsulta($sql);
		return "OK";
	}

	public function Update() {
		$sql = "Update  usuarios set Usuario='".$this->Usuario."',password='".$this->password."',Nombre='".$this->Nombre."',Nivel='".$this->Nivel."',Activo='".$this->Activo."' where Usuario='".$this->Usuario."' "; 
		$res = $this->conectas->EjecutaConsulta($sql);
		return "OK";
	}

	public function delete() {
		$sql= "delete from  usuarios where Usuario='".$this->Usuario."' ";
		$res = $this->conectas->EjecutaConsulta($sql);
		return "OK";
	}
}
?>
