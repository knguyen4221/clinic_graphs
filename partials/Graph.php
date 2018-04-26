<?php


abstract class Graph {
	private $graphTitle;
	private $fontSize;
	private $height;
	private $width;
	private $email;
	private $hash;

	function __construct($title, $fontsize, $width, $height, $email) {
		$this->graphTitle = $title;
		$this->fontSize = $fontsize;
		$this->height = $height;
		$this->width = $width;
		$this->email = $email;
		$this->hash = NULL;
	}

	abstract protected function queryData();
	//args refer to specific columns being queried
	abstract protected function createGraph($data);

	public function getWidth(){return $this->width;}
	public function getHeight(){return $this->height;}
	public function getEmail(){return $this->email;}
	public function getHash(){return $this->hash;}
	public function getTitle(){return $this->graphTitle;}
	public function getFontSize(){return $this->fontSize;}

	public function constructGraph(){
		$data = $this->queryData();
		$content = $this->createGraph($data);
		$post_link = $this->create_wp_post($content);
		if($this->hash == NULL){
			wp_die("Hash couldn't be created");
		}
		return json_encode(array($this->hash, $post_link));
	}

	protected function create_wp_post($content){
		$my_post = array(
			'post_title' => $this->graphTitle,
			'post_content' => $content,
			'post_status' => 'publish',
			'post_author' => 1,
		);
		$post_id = wp_insert_post($my_post);
		if($post_id == 0){
			wp_die("Couldn't insert the post");
		}else{
			return get_permalink($post_id);
		}
	}

	protected function create_wp_page($html){
		$this->hash = hash('ripemd160',$html.$this->email);
		$newFileName = $this->hash.".html";
		$newFile = fopen( get_stylesheet_directory()."/partials/graphs/".$newFileName, 'w');
		if(!$newFile){
			wp_die("Couldn't make file try checking the permissions for the folder");
		}
		fwrite($newFile, $html);
		fclose($newFile);
		return "<iframe src=\"".site_url('/wp-content/themes/vantage-child/partials/graphs/'.$newFileName)."\" border='0' style='border-style: none; width: 100%; height: ".(int)$this->height*1.50."px;' seamless/>";
	}
}

?>