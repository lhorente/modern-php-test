<?php
namespace lhorente\Models;

class Usuario extends Dao{
	private $table = "usuarios";
	public $validationErrors = array();
	public $errorMsg = '';
	public $hasError = false;
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getByLogin($login){
		try{
			$sql = "select * from {$this->table} where login = ? limit 1";
			$stmp = $this->conn->prepare($sql);
			$stmp->bindValue(1,$login);
			$stmp->execute();
			return $stmp->fetch(\PDO::FETCH_ASSOC);
		} catch (PDOException $e){
			$this->errorMessage = "Erro ao buscar registro";
		}
	}
	
	public function insert($data){
		$login = isset($data['login']) ? $data['login'] : null;
		$password = isset($data['password']) ? $data['password'] : null;

		if (!$login){
			$this->hasError = true;
			$this->validationErrors['login'] = "Login inválido";
		}

		if (!$password){
			$this->hasError = true;
			$this->validationErrors['password'] = "Senha inválida";
		}
		
		if (!$this->hasError){
			try{
				$sql = "insert into {$this->table}(login,password) values(?,?)";
				$stmp = $this->conn->prepare($sql);
				$stmp->bindValue(1,$login);
				$stmp->bindValue(2,$password);
				$stmp->execute();
				return true;
			} catch (PDOException $e){
				$this->errorMessage = "Erro ao inserir registro";
			}
		} else {
			if ($this->validationErrors){
				$this->errorMessage = implode(", ",$this->validationErrors);
			}
		}
		return false;
	}	
}