<?php
require_once 'ht.php';
require_once 'head.php';
require_once 'body.php';
require_once 'link.php';
require_once 'img.php';
use Illuminate\Database\Eloquent\Model as Eloquent;
class seo extends Eloquent{
	//comes with FD
	public $id;
	public $name;
	public $real_content;
	public $mk;
	public $md;
	public $pt;
	public $public;
	public $mile;
	public $mifr;
	public $swords;
	public $type;
	public $userid;
	//------
	public $url;
	protected $timestamp = [];
	protected $fillable=['aid','name','type','byuser','ispublic'];
	protected $table = 'analysis_list';

	public function insert_analysis($aid,$name,$type,$userid,$public){

		$result = $this->create([
			           		'aid'=>$aid,
							'name'=>$name,
							'type'=>$type,
							'byuser'=>$userid,
							'ispublic'=>$public
							]);
			if($result)
				return true;
			else 
				return false;
			
	}
	public function fire(){
		$this->id = (int)'1'.rand(1000,99000);
		$url = "";


		if($this->type<=0){
			if(preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $this->real_content)){
				$this->url = $this->real_content;
				$content = file_get_html($this->real_content);
				$this->real_content = $content;//store html
					if($this->parse($content)){
						if($this->insert_analysis($this->id,$this->name,$this->type,$this->userid,$this->public))
							echo json_encode(['type'=>'success','id'=>''.$this->id.'']);
					}

			}
			else
				echo json_encode(['type'=>'error','message'=>'[#URL]Invalid URL passed']);
		}
		else if ($this->type==1) {
			if($this->real_content != strip_tags($this->real_content)){
				$content = str_get_html($this->real_content);
				if($this->parse($content)){
					//pass this to parse()
					if($this->insert_analysis($this->id,$this->name,$this->type,$this->userid,$this->public))
						echo json_encode(['type'=>'success','id'=>''.$this->id.'']);
				}
			}
			else
				echo json_encode(['type'=>'error','message'=>'[#HTML]Invalid HTML data passed']);
		}
		else{
			if(($this->real_content == strip_tags($this->real_content))&&(substr($this->real_content, 0, 7 ) != "http://")&&(substr($this->real_content, 0, 7 ) != "https://")){
				$content = $this->real_content;
				if($this->parse(strtolower($content))){
					if($this->insert_analysis($this->id,$this->name,$this->type,$this->userid,$this->public))
						echo json_encode(['type'=>'success','id'=>''.$this->id.'']);
			}
			}
			else
				echo json_encode(['type'=>'error','message'=>'[#83-PlainText]Invalid Content passed']);
			}
	}

	public function parse($content){
		if($this->type<=1){
				if($this->process_int($content)){
					$this->process_ext($content);
					return true;
				}
				else{
					echo json_encode(['type'=>'error','message'=>'[#PlainText]No analysis report generated (Maybe Inavailability ofKeywords)']);
					return false;
				}
		}
		else{
			//echo $content;
			$content = $this->sanitizecontent($content);
			$data = $this->processtext($content,'pt',str_word_count($content));
			//print_r($data);
			if(!$this->checkemptyJSON($data)){
				$re = ht::create([
					'id'=>$this->id,
					'content'=>$this->real_content,
					'url'=>$this->url,
					'stopwords'=>$this->swords,
					'word_count'=>str_word_count($content),
					'data'=>$data
						]);
				if($re)
					return true;
				else 
					return false;
			}
			else{
				//echo "oops";
				echo json_encode(['type'=>'error','message'=>'[#114-PlainText]No analysis report generated (Maybe Inavailability ofKeywords)']);
				return false;
			}
			//return false;
		}
		
	}

	public function gettagcount($tag,$content){
		$tagcount = 0;
		foreach ($content->find($tag) as $sometag) {
			# code...
			$tagcount = $tagcount+1;
		}
		return $tagcount;
	}

	public function get_img_content($tag,$content){
		$tagcontent = "";
		foreach ($content->find($tag) as $sometag) {
			# code...
			$tagcontent = $tagcontent.' '.$sometag->alt; 
		}
		return $tagcontent;
	}

	public function gettagcontent($tag,$content){
		$tagcontent = "";
		foreach ($content->find($tag) as $sometag) {
			# code...
			$tagcontent = $tagcontent.' '.$sometag->plaintext; 
		}
		return $tagcontent;
	}

	/*public function sanitize_html_content(){
		$this->swords = str_replace(' ', '', $this->swords);
		//echo $this->swords;
		$swords_array = explode(',', $this->swords);
		foreach ($swords_array as $word) {
			# code...
			$h_content = preg_replace('/\b'.$word.'\b/', '', $h_content);
		}
		$h_content = preg_replace('/\b[a-z0-9]{0,'.preg_quote($this->mile-1).'}\b/','',$h_content);//removes min word length
		$h_content = preg_replace('/[^A-Za-z0-9\ ]/', '', $h_content);//removes special char
		$h_content = str_replace('\'', '', $h_content);
		//echo $h_content;
		return $h_content;
	}*/

	public function sanitizecontent($h_content){
		//remove swords
		//remove symbols
		//remove mile
		$search =  '!"#$%&/()=?*+\'-.,;:_’' ;
		$search = str_split($search);
		$h_content = str_replace($search, '', $h_content);
		//$h_content = str_replace('’', '', $h_content);

		$this->swords = str_replace(' ', '', $this->swords);
		//echo $this->swords;
		$swords_array = explode(',', $this->swords);
		foreach ($swords_array as $word) {
			# code...
			$h_content = preg_replace('/\b'.$word.'\b/', '', $h_content);
		}
		$h_content = preg_replace('/\b[a-z0-9]{0,'.preg_quote($this->mile-1).'}\b/','',$h_content);//removes min word length
		//$h_content = preg_replace('/[^A-Za-z0-9\ ]/', '', $h_content);//removes special char

		return $h_content;
	}

	public function comb($arr){
		//$arr = array('bill','loves','cars','at','MS');
		$len = count($arr);
		$newarray = array();
		//echo $len;
		for($i = 0;$i<$len;$i++){
			for($j = 0 ; $j<$len;$j++){
				if($i==$j)continue;
				else {
					$newarray [] = $arr[$i].' '.$arr[$j];
				}
			}
		}
		$result = array_unique($newarray);
		return $result;
	}

	public function comb3($arr){
			$len = count($arr);
			$newarray = array();
			//echo $len;
				for($i = 0;$i<$len;$i++){
					for($j = 0 ; $j<$len;$j++){
						for($k = 0 ; $k < $len ; $k++){
							if(($i==$j)&&($i==$k))continue;
							else {
								$newarray [] = $arr[$i].' '.$arr[$j].' '.$arr[$k];
							}
						}
					}
				}
		$result = array_unique($newarray);
		return $result;
	}

	public function processtext($content,$code,$globalcount){
		$one=$two=$three=0;
		if($globalcount<=1)goto label;
		//1.Find frequency for ONEWORD
		$oneword = $onewordc = $onewordd = array();
		foreach ($var = array_filter(array_count_values(str_word_count($content, 2)), function($n){return $n >= $this->mifr;})
		         as $key => $value) {
			$oneword [] = $key;
			$onewordc [] = $value;
		}
		if(empty($oneword)||empty($onewordc))
			$one=0;
		else{
			$one=1;
			foreach ($onewordc as $key) {
			$density = ($key/$globalcount)*100;
			$density = round($density,2);
			$onewordd [] = $density.'%';
			}
		}
		//--------------------for two word-----------------
		$twoword = $twowordd = $twowordc = $twoword_altered = $twoword_count = array();
		$words = str_word_count($content,1);
		$globaltwoword = $twoword = $this->comb($words);
		//print_r($twoword);
		foreach($twoword as $word){
			$twoword_count [$word] = substr_count($content, $word); 
		}

		//print_r($twoword_count);
		foreach ($variable = array_filter($twoword_count,function($n){ return $n>=$this->mifr;})
			as $key => $value) {
			# code...
			$twoword_altered [] = $key;
			$twowordc [] = $value;
		}
		//print_r($twoword_altered);
		if(empty($twoword_altered)||empty($twowordc))
			$two=0;
		else
		{	$two=1;
			foreach ($twowordc as $key ) {
				$density = ($key*2/$globalcount)*100;
				$density = round($density,2);
				$twowordd [] = $density.'%';
			}
		//print_r($twowordd);
		}
		//-----------------------for three word------------------------
		$threeword = $threewordc = $threewordd = $threeword_altered = $cout = array();
		$threeword = $this->combine($globaltwoword,$oneword);
		foreach ($threeword as $word) {

        	$cout [$word] = substr_count($content, $word); 
        }
        //print_r($cout);
        foreach ($var = array_filter($cout, function($n){return $n >= $this->mifr;})
		         as $key => $value) {
			$threeword_altered [] = $key;
			$threewordc [] = $value;
		}
		//print_r($threeword_altered);
		if(empty($threeword_altered)||empty($threewordc)){
			$three=0;

		}
		else{
			foreach ($threewordc as $key) {
				$three=1;
				# code...
				$density = ($key*3/$globalcount)*100;
				$density = round($density,2);
				$threewordd [] = $density.'%';
			}

		}
		//print_r($threeword_altered);

  label:$oneword_new="";$onewordc_new="";$onewordd_new="";
		$twoword_new="";$twowordc_new="";$twowordd_new="";
		$threeword_new="";$threewordc_new="";$threewordd_new="";
		if($one>0){
			$oneword_new = implode("-", $oneword);
			$onewordc_new = implode("-",$onewordc);
			$onewordd_new = implode("-",$onewordd);

		}
		if($two>0){
			$twoword_new = implode("-", $twoword_altered);
			$twowordc_new = implode("-",$twowordc);
			$twowordd_new = implode("-",$twowordd);

		}
		if($three>0){
			$threeword_new = implode("-", $threeword_altered);
			$threewordc_new = implode("-",$threewordc);
			$threewordd_new = implode("-",$threewordd);

		}
		$final_json = json_encode(['to'=>''.$code.'',
					  'oneword'=>''.$oneword_new.'','onewordc'=>''.$onewordc_new.'','onewordd'=>''.$onewordd_new.'',
					  'twoword'=>''.$twoword_new.'','twowordc'=>''.$twowordc_new.'','twowordd'=>''.$twowordd_new.'',
					  'threeword'=>''.$threeword_new.'','threewordc'=>''.$threewordc_new.'','threewordd'=>''.$threewordd_new.'']);
		//print_r($final_json);
		return $final_json;
	}

	public function combine($globaltwoword,$words){
		$newarray = array();
		$i=-1;
		foreach ($globaltwoword as $key => $value) {
			# code...
			foreach ($words as $aword) {
				# code...
				$newarray[$i++] = $value.' '.$aword;

			}
		}
		return array_unique($newarray);
	}

	public function remove_tag($tag,$content){
		$dom = new DOMDocument();
		$internalErrors = libxml_use_internal_errors(true);
		$dom->loadhtml($content);
		libxml_use_internal_errors($internalErrors);
		$nodes = $dom->getElementsByTagName($tag);
		for ($i = $nodes->length - 1; $i >= 0; $i--) {
    		$nodes->item($i)->parentNode->removeChild($nodes->item($i));
		}
	return $dom->saveHTML();
	}

	public function process_int($content){
		$flag=0;
		$h_count = $this->gettagcount('html',$content);
		$h_content = $this->gettagcontent('html',$content);
		if($h_count>0){
			if($this->mk<=0){
				$h_content = $this->remove_tag('meta',$h_content);
			}
			if($this->md<=0){
				$h_content = $this->remove_tag('meta',$h_content);
			}
			if($this->pt<=0){
				$h_content = $this->remove_tag('title',$h_content);
			}
			$html_content = strtolower($h_content);
			$html_content = $this->sanitizecontent($html_content);
			$data = $this->processtext($html_content,'html',str_word_count($html_content));
			if(!$this->checkemptyJSON($data)){
				$re = ht::create([
					'id'=>$this->id,
					'content'=>$this->real_content,
					'url'=>$this->url,
					'stopwords'=>$this->swords,
					'word_count'=>str_word_count($html_content),
					'data'=>$data
						]);
				if($re)$flag=1;
				else
					$flag=0;
			}
		}	
		if($flag>0)return true;
		else return false;
	}

	public function process_ext($content){
		$flag = 0;
		$h_count = $this->gettagcount('h1',$content);
		$h_count = $h_count + $this->gettagcount('h2',$content);
		$h_count = $h_count + $this->gettagcount('h3',$content);
		$h_count = $h_count + $this->gettagcount('h4',$content);
		$h_count = $h_count + $this->gettagcount('h5',$content);
		$h_content = $this->gettagcontent('h1',$content);
		$h_content = $h_content.' '.$this->gettagcontent('h2',$content);
		$h_content = $h_content.' '.$this->gettagcontent('h3',$content);
		$h_content = $h_content.' '.$this->gettagcontent('h4',$content);
		$h_content = $h_content.' '.$this->gettagcontent('h5',$content);
		$h_content = strtolower($h_content);	
		if($h_count>0){
			//sanitize and process_text;
			$h_content = $this->sanitizecontent($h_content);
			$data = $this->processtext($h_content,"h",str_word_count($h_content));
			if(!$this->checkemptyJSON($data)){
				$re = head::create([
					'id'=>$this->id,
					'content'=>$content,
					'word_count'=>str_word_count($h_content),
					'data'=>$data
						]);
				if($re)$flag=1;
				else $flag=0;
			}
		}
		//---------------start for body
		$body_count = $this->gettagcount('body',$content);
		$b_content=$this->gettagcontent('body',$content);
		$b_content=strtolower($b_content);
		if($body_count>0){
			$body_content = $this->sanitizecontent($b_content);
			$data = $this->processtext($body_content,"b",str_word_count($body_content));
			if(!$this->checkemptyJSON($data)){
					$re = body::create([
					'id'=>$this->id,
					'content'=>$content,
					'word_count'=>str_word_count($body_content),
					'data'=>$data
						]);
				if($re)$flag=1;
				else $flag=0;
			}
		}
		//------------------start for links
		$link_count = $this->gettagcount('a',$content);
		$l_content = $this->gettagcontent('a',$content);
		$l_content = strtolower($l_content);
		if($link_count>0){
			$link_content = $this->sanitizecontent($l_content);
			$data = $this->processtext($link_content,'l',str_word_count($link_content));
			if(!$this->checkemptyJSON($data)){
				$re = link::create([
					'id'=>$this->id,
					'content'=>$content,
					'word_count'=>str_word_count($link_content),
					'data'=>$data
						]);
				if($re)$flag=1;
				else $flag=0;
			}
		}
		//-----------------start for images
		$img_count = $this->gettagcount('img',$content);
		$i_content = $this->get_img_content('img',$content);
		$i_content = strtolower($i_content);
		if($img_count>0){
			$img_content = $this->sanitizecontent($i_content);
			$data = $this->processtext($img_content,'i',str_word_count($img_content));
			if(!$this->checkemptyJSON($data)){
				$re = img::create([
					'id'=>$this->id,
					'content'=>$content,
					'word_count'=>str_word_count($img_content),
					'data'=>$data
						]);
				if($re)$flag=1;
				else echo $flag=0;
			}

		}

		if($flag>0)return true;
		else return false;
	}

	public function checkemptyJSON($data){
		$data = json_decode($data);
		if(empty($data->oneword)&&empty($data->onewordc)&&empty($data->onewordd)
		 &&empty($data->twoword)&&empty($data->twowordc)&&empty($data->twowordd)
		 &&empty($data->threeword)&&empty($data->threewordc)&&empty($data->threewordd))return true;
		 else
		 	return false;
	}

}
?>