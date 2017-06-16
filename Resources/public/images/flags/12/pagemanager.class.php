<?php
/*************    PageManager    *************\
|													|
|		Version: 0.0.2							|
|		Developed by: Olivier Delbruyère			|
|		lb1x Project							|
|		Nouveauté: 0.0.2: gestion des titres et des descriptions metadata
\*************    PageManager    *************/

class PageManager extends ClassManager{
	protected $defaultLangage = 1;
	protected 	$tableName = 'pages', 
				$infos = array(
					'type'				=>		array(	'type' 		=> 		'int'	),
					'inMenu' 			=>		array(	'type' 		=> 		'int'	),
					'menuOrder' 		=>		array(	'type' 		=> 		'int'	),
					'idParent' 		=>		array(	'type' 		=> 		'id'	),
					'statut' 			=>		array(	'type' 		=> 		'int'	),
					'password' 		=>		array(	'type' 		=> 		'text'	),
				);
				
	protected $statuts = array(
									0 => array(
										'label' => 'warning',
										'text' => 'Brouillon'
									),
									1 => array(
										'label' => 'success',
										'text' => 'Publiée'
									)
								);
	
	public function __construct($db){
		parent::__construct($db);
	}
	
	public function extendMethod($object, $method){
		if($method == 'actions'){
			return '<a href="view.php?object=page&id='.$object->get('id').'" class="link-unstyled"><i class="fa fa-eye"></i> </a> <a href="update.php?object=page&id='.$object->get('id').'" class="link-unstyled"><i class="fa fa-pencil"></i> </a>';
		}
		else if($method == 'show_title'){
			$pageContentManager = new PageContentManager($this->db);
			$pageContent = $pageContentManager->get(array('idPage' => $object->get('id'), 'lang' => $this->defaultLangage));
			return $pageContent->get('title');
		}
		else if($method == 'show_statut'){
			return '<small><span class="label label-'.$this->statuts[$object->get('statut')]['label'].'">'.$this->statuts[$object->get('statut')]['text'].'</span><small>';
		}
		else if($method == 'show_category'){
			return 'A coder';
		}
		else if($method == 'show_inMenu'){
			return ($object->get('inMenu') == 1)?'<i class="fa fa-check"></i> ':'<i class="fa fa-remove"></i> ';
		}
		else if($method == 'show_maj'){
			$pageContentManager = new PageContentManager($this->db);
			$pageContent = $pageContentManager->get(array('idPage' => $object->get('id'), 'lang' => $this->defaultLangage));

			$explodedDate = explode(' ', $pageContent->get('maj'));
			$date = explode('-', $explodedDate[0]);
			$heure = explode(':', $explodedDate[1]);

			return $date[2].'/'.$date[1].'/'.$date[0].' à '.$heure[0].'h'.$heure[1];
		}
		else if($method == 'show_translate'){
			$pageContentManager = new PageContentManager($this->db);
			$list = $pageContentManager->getList(array('where' => 'idPage = '.$object->get('id')));
			$return = '';
			foreach($list as $content){
				$return .= '<a href="update.php?object=page&id='.$object->get('id').'&lang='.$content->get('id').'"><div class="row"><div class="col-md-2"><img src="../img/flags/12/'.$content->get('lang').'.png" alt="'.$content->get('lang').'" /></div><div class="col-md-6"><small><span class="label label-';
				$return .= ($content->get('statut') == 1)?'success"><i class="fa fa-check"></i> Publiée':'warning"><i class="fa fa-times"></i> Non définie';
				$return .= '</span></small></div></div></a>';
			}
			return $return;
		}
		else return 'erreur: méthode inconnue';
	}
	
	public function createObject($a){
		return new Page($a);
	}
	
	public function add(Page $p){
		$id = parent::add($p);
		return $id;
	}
	
	public function getVersions($id){
		$q = $this->_db->query('select count(*) as data from pages_versions where idSite = '.ID_SITE.' and id_page = '.$id)->fetch();
		if($q['data'] == 0) echo 'Aucune version antérieure détectée';
		else {
			echo '<table class="table table-hover">
              <thead>
              	<tr><th>Titre</th><th>Date de mise à jour</th><th>Actions</th></tr></thead><tbody><tr>';
			$q = $this->_db->query('select id, title, maj from pages_versions where idSite = '.ID_SITE.' and id_page = '.$id.' order by maj desc');
			while ($a = $q->fetch()){
				$page = new Page($a);
				echo '<td>'.$page->title().'</td><td>'.$page->maj('normal').'</td><td><a href="view.php?object=page&id='.$page->id().'" rel="tooltip" title="Voir" target="blank"><i class="icon-eye-open"></i></a> <a href="confirm.php" data-id="3" rel="tooltip" title="Retourner à cette version"><i class="icon-retweet"></i></a></tr>';
			}
			echo '</tbody></table>';
		}
	}
	
	public function update(Page $p, $oldData = false){
		parent::update($p);
	}
	
	
}
?>