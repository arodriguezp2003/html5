<?php
/**
 * Clase que realiza la conexion con la bese de datos.
 *
 * @category		Base de Datos
 * @version 		1.0
 */
Class ClaseConexion
{
    /* Variables Globales para la Conexión*/
    var $_Base;
    var $_Servidor;
    var $_Usuario;
    var $_Clave;
    var $_Booleano;
    var $_PuertoNumero;
    var $_ConexionId=0;
    var $_ConsultaId=0;
    var $_Errno=0;
    var $_Error=0;
	/**
     * Función contructor que incializa las Variables
     *
     * @param  $bd     Nombre de base de datos
     * @param  $host   Direccion IP o nombre del servidor de base de datos
     * @param  $user   Usuario de la base de datos
     * @param  $pass   Password de la base de datos
     * @param  $bol    Valor booleano que especifica nuevo link
     * @param  $flag   Flag de cliente
     * @return integer Identificador de conexion
     */
//	function ClaseConexion($bd="TURISTIK_desa",$host="localhost",$user="carola",$pass="123carola",$bol="false",$flag="131074")
//	function ClaseConexion($bd="turistik",$host="localhost",$user="root",$pass="carola",$bol="false",$flag="131074")
	function ClaseConexion($bd="dash",$host="localhost",$user="root",$pass="")
    {
 	    $this->_Base=$bd;
        $this->_Servidor=$host;
		$this->_Usuario=$user;
        $this->_Clave=$pass;

    }
	/**
     * Función que conecta con la Base de Datos
     *
     * @param  null
     * @return integer Conexion ID
     */
    function Conectar()
    {
        $this->_ConexionId = mysql_connect($this->_Servidor,$this->_Usuario,$this->_Clave);
        if (!$this->_ConexionId)
        {
            $mensaje  = 'Error al conectar el servidor: '.$this->_Servidor."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);

        }
        if (!mysql_select_db($this->_Base,$this->_ConexionId))
        {
            $mensaje  = 'Error al seleccionar la base de datos: '.$this->_Base."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
		return $this->_ConexionId;
    }
	/**
     * Funcion que ejecuta una consulta
     *
     * @param  string  $sql         Consulta SQL
     * @return integer $_ConsultaId Conjunto de registros en caso de select
     */
    function EjecutaConsulta($sql="")
    {
        $this->_ConsultaId= mysql_query($sql,$this->_ConexionId);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Fallo al ejecutar consulta SQL: '.$sql."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }
    /**
     * Funcion que ejecuta un procedimiento almacenado.
     *
     * @param  string $nombre      Nombre del procedimiento almcenado
	 * @param  string $parametros  Lista de parametros de entrada y salida
     * @return string $_ConsultaId Conjunto de registros en caso de select
     */
	function EjecutaPL($nombre)
    {
        $query=$nombre;
		//echo "<br>".$procedimiento;
		$this->ExecuteConsulta($query);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Fallo al ejecutar procedimiento: '.$nombre."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }

    function EjecutaSP($nombre,$parametros)
    {
        $procedimiento="call ".$nombre."(".$parametros.");";
		//echo "<br>".$procedimiento;
		$this->ExecuteConsulta($procedimiento);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Fallo al ejecutar procedimiento: '.$nombre."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }
	function EjecutaSP1($nombre,$parametros)
    {
        $procedimiento="call ".$nombre."(".$parametros.");";
		echo "<br>".$procedimiento;
		$this->ExecuteConsulta($procedimiento);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Fallo al ejecutar procedimiento: '.$nombre."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }
	/**
     * Funcion que ejecuta un procedimiento almacenado sin parametros de entrada.
     *
     * @param  string $nombre      Nombre del procedimiento almcenado
	 * @param  string $parametros  Lista de parametros de entrada
     * @return string $_ConsultaId Conjunto de registros en caso de select
     */
	 function EjecutaSPsin($nombre)
    {
        $procedimiento="call ".$nombre."();";
		$this->ExecuteConsulta($procedimiento);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Fallo al ejecutar procedimiento: '.$nombre."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }
	/**
     * Funcion que rescata los parametros retornados por un procedimiento almacenado.
     *
     * @param  string $parametrosSP Lista de parametros devueltos por el procedimiento almacenado
	 *                              especificados en la ejecucion del mismo.
     * @return string $_ConsultaId  Parametros de salida especificados en la ejecucion del
	 *                              procedimiento almacenado.
     */
    function ObtenerResultadoSP($parametrosSP)
    {
        $sql="SELECT ".$parametrosSP.";";
        $this->ExecuteConsulta($sql);
        if (!$this->_ConsultaId)
        {
            $mensaje  = 'Error al obtener parametros: '.$parametrosSP."<BR>";
            $mensaje .= 'MySql Error: ' .mysql_error();
            die($mensaje);
        }
        return $this->_ConsultaId;
    }
	/**
     * Funcion que devuelve el Numero de Campos de la consulta
     *
     * @param  null
     * @return integer Numero de campos
     */
    function NumCampos()
    {
        return mysql_num_fields($this->_ConsultaId);
    }
	/**
     * Funcion que devuelve el numero de registros de una consulta
     *
     * @param  null
     * @return integer Numero de registros
     */
    function NumRegistros()
    {
        return mysql_num_rows($this->_ConsultaId);
    }
    /**
     * Funcion que devuelve el nombre del campo
     *
     * @param  integer $numCampo indice del campo
     * @return string
     */
    function NombreCampo($numCampo)
    {
        return mysql_field_name($this->_ConsultaId, $numCampo);
    }

	/* Por Regularizar */
	function ExecuteConsulta($sql="")
    {
        if ($sql=="")
        {
            $this->_Error="no consulta";
            return 0;
        }
        $this->_ConsultaId= mysql_query($sql,$this->_ConexionId);
        return $this->_ConsultaId;

    }

    function ExecuteConsulta_Parametros($nombre,$parametros)
    {
        $procedimiento="call ".$nombre."(".$parametros.")";
        $this->ExecuteConsulta($procedimiento);
        $sql="select ".$parametros. "";
        $this->ExecuteConsulta($sql);
        if (!$this->_ConsultaId)
        {
            $message  = 'Consulta Invalida: ' . mysql_error() . "\n";
            $message .= 'Consulta: ' . $this->_ConsultaId;
            die($message);
        }
        return $this->_ConsultaId;
    }

    function ExecuteConsulta_ParametrosIN_OUT($nombre,$parametros,$parametrosOUT)
    {
        $procedimiento="call ".$nombre."(".$parametros.",".$parametrosOUT.")";
        $this->ExecuteConsulta($procedimiento);
        $sql="select ".$parametrosOUT. "";
        $this->ExecuteConsulta($sql);
        if (!$this->_ConsultaId)
        {
            $message  = 'Consulta Invalida: ' . mysql_error() . "\n";
            $message .= 'Consulta: ' . $this->_ConsultaId;
            die($message);
        }
        return $this->_ConsultaId;
    }

}
?>
