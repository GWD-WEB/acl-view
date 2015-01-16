<?php
App::uses('AclView.AclViewAppController', 'Controller');


class PermissoesController extends AclViewAppController{
	
	public function index(){
		$aro = $this->Acl->Aro;
		$aco = $this->Acl->Aco;
		$perm = $this->Acl->Permission;
		
		$aro->recursive = -1;
		$grupos = ($aro->find('all'));
		$aco->recursive = -1;
		$aco->displayField = 'alias';
		$reqs = ($aco->generateTreeList(null, null, null, '@'));
		
		$new_reqs = array();
		foreach($reqs as $key=>$item){
			$nivel[substr_count($item, '@')] = $item;
			$path = '';
			for($i=0;$i<substr_count($item, '@');$i++)
				$path.= $nivel[$i].'/';
			$new_reqs[$key] = str_replace('@', '', $path.$item);
		}
		
		$reqs = $new_reqs;
		foreach($grupos as $grupo){
			foreach($reqs as $action){
				$permissions[$grupo['Aro']['id']][$action] = 
				$this->Acl->check($grupo['Aro']['alias'], $action);
			}
		}
		$this->set(compact(array('grupos', 'reqs', 'permissions')));
	}
	
	public function alterar($grupo, $action_key){
		$action_path = $this->Acl->Aco->getPath($action_key, 'alias');
		$action = '';
		foreach($action_path as $item){
			$action .= $item['Aco']['alias'].'/';
		}
		$action = substr($action, 0, -1);
		if($this->Acl->check($grupo, $action)){
			$this->Acl->deny($grupo, $action);
		}
		else{
			$this->Acl->allow($grupo, $action);
		}
		$this->redirect('index');
	}
	
}
	