<?php
namespace Core;
use Core\Database;
use Intcs\Model as IntModel;

class Model extends Database implements IntModel{
	public function __call($name, $arguments){
		$array = preg_split('/([A-Z][^A-Z]*)/', $name, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		$array = array_map("strtolower", $array);

		$table = $array[0];

		if($table == "save"){
			$validate = $this->BeforeSave($arguments[0]);
			if($validate === true) return $this->Insert($array[1],$arguments[0]);
			else return $validate;
		}else if($table == "modify"){
			$validate = $this->BeforeSave($arguments[0]);
			if($validate === true)  return $this->Update($array[1], $arguments[0], $arguments[1]);
			else return $validate;
		}else if($table == "del"){
			return $this->Delete($array[1], $arguments[0]);
		}else{
			$conditions = array();

			if(count($array) > 1){
				unset($array[0], $array[1]);

				$field = array();
				$type = "and";

				foreach ($array as $value){
					if(stristr("and, or", $value)){
						$conditions[] = array("type"=>$type, join("_",$field) => $arguments[count($conditions)]);
						$field = array();
						$type = $value;
					}else $field[] = $value;
				}

				$conditions[] = array("type"=>$type, join("_",$field) => $arguments[count($conditions)]);
			}

			if($table == "find") return $this->find('all', ["conditions"=>$conditions], false);
			else{
				if(count($conditions)){
					return $this->GetData($table, "*", ["conditions"=>$conditions], false);
				}else{
					return $this->GetData($table, $arguments[0], isset($arguments[1])?$arguments[1]:null, isset($arguments[2])?$arguments[2]:false);
				}
			}
		}
	}

	public function find($fields = 'all', $options = [], $index = true){
		$fields = $fields=="all"?"*":$fields;
		return $this->GetData(strtolower($this->name), $fields, $options, $index);
	}


	public function query($query,$indice=true,$recuperar=false){
		return $this->Execute($query,$recuperar,$indice);
	}


	public function save($data){
		$validate = $this->BeforeSave($data);

		if($validate === true) return $this->Insert(strtolower($this->name),$data);
		else return $validate;
	}

	public function modify($data, $options = []){
		$validate = $this->BeforeSave($data);
		if($validate === true) return $this->Update(strtolower($this->name), $data, $options);
		else return $validate;
	}

	public function del($options = []){
		return $this->Delete(strtolower($this->name), $options);
	}

	private function BeforeSave(&$data){
		$msg = array();

		if(isset($this->validate)){
			foreach($this->validate as $field => $validate){
				switch ($validate["type"]) {
					case 'float':
						$temp =  filter_var($data[$field], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

						if(!filter_var($temp, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION))
						    $msg[] = _t("FIELDFLOAT", $field);

						break;
					case 'int':
						$temp =  filter_var($data[$field], FILTER_SANITIZE_NUMBER_INT);

						if(!filter_var($temp, FILTER_VALIDATE_INT))
						    $msg[] = _t("FIELDINT", $field);

						break;
					case 'email':
						$temp =  filter_var($data[$field], FILTER_SANITIZE_EMAIL);

						if(!filter_var($temp, FILTER_VALIDATE_EMAIL))
						    $msg[] = _t("FIELDEMAIL", $field);

						break;
					case 'url':
						$temp =  filter_var($data[$field], FILTER_SANITIZE_URL);

						if(!filter_var($temp, FILTER_VALIDATE_URL))
						    $msg[] = _t("FIELDURL", $field);

						break;
					case 'html':
						$temp =  filter_var($data[$field], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
						break;
					default:
						$temp =  filter_var($data[$field], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP);
						break;
				}

				$data[$field] = $temp;

			}
		}
		
		return count($msg)?$msg:true;
	}
}
?>
