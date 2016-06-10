<?php
class seoco extends controller{
	protected $seo;
	protected $key;
	public function process(){
		if($this->isloggedin()){
			if(isset($_POST['data'])){
				$data = json_decode($_POST['data'],true);
				$seo = $this->model('seo');

				$seo->name = $data['project_name'];
				$seo->real_content = $data['content_data'];
				$seo->mk = $data['meta_keywords'];
				$seo->md = $data['meta_description'];
				$seo->pt = $data['page_title'];
				$seo->public = $data['ispublic'];
				$seo->mile = $data['min_length'];
				$seo->mifr = $data['min_freq'];
				$seo->swords = $data['stop_words'];
				$seo->type = $data['content_type'];
				$seo->userid = $data['userid'];
				$seo->fire();				
			}
			else{
				echo json_encode(['message'=>'Parameters Missing']);
			}
		}else{
			echo json_encode(['message'=>'Authentication failed.']);
		}
	}


	public function getids($uid=""){
				if($this->isloggedin()){
			if(isset($uid)&&!empty($uid)){
				$key = $this->model('seo');
				$result = $key->where('byuser',$uid)->get();

				$id = array();
				$arr = $result->toArray();					
					foreach ($arr as $key => $value) {
						$id [] = $value['aid'];

					}

					echo json_encode(['id'=>$id]);

			}			
			else{
				echo json_encode(['message'=>'Parameters Missing']);
			}
		}else{
			echo json_encode(['message'=>'Authentication failed.']);
		}
	}

	public function retrieve($type="",$id=""){
		if($this->isloggedin()){
			if(isset($type)&&isset($id)&&!empty($type)&&!empty($id)){
				if(strcmp($type, "id")==0){
					$this->fetch('aid',$id);		
				}
				else
					echo json_encode(['message'=>'Invalid Parameter passed']);
			}
			else{
				echo json_encode(['message'=>'Parameters Missing']);
			}
		}else{
			echo json_encode(['message'=>'Authentication failed. :D']);
		}
	}

	public function fetch($col,$id){
		try{
					$flag = $ht_exists = $bd_exists = $hd_exists = $im_exists = $li_exists = false;
					$seo = $this->model('seo');
					$ht = $this->model('ht');
					$head = $this->model('head');
					$body = $this->model('body');
					$img = $this->model('img');
					$link = $this->model('link');
					$name="";$type="";$created_at="";$public="";
					$url='';$word_count="";$data="";
							$bwc="";$bdata="";
							$hwc="";$hdata="";
							$iwc="";$idata="";
							$lwc="";$ldata="";
					$seo = seo::where($col,$id)->firstOrFail();
					$record = $seo->getAttributes();
					$name=$record['name'];
					$idofrecord=$record['aid'];
					if($record['type']==0)$type="URL";
					else if($record['type']==1)$type="HTML";
					else $type="Plain Text";
					$created_at = $record['created_at'];
					$public = $record['ispublic'];
					//-----------End of Phase 1
					if($ht = ht::where('id',$idofrecord)->first()){
					$flag = $ht_exists = true;
					$htrecord = $ht->getAttributes();
					if(!empty($htrecord['url']))$url = $htrecord['url'];
					$word_count = $htrecord['word_count'];
					$data = $htrecord['data'];
					//print_r($htrecord);
					}
					//------------End of phase 2
					if($body = body::where('id',$idofrecord)->first()){
						$flag = $bd_exists = true;
						$bdrecord = $body->getAttributes();
						$bwc = $bdrecord['word_count'];$bdata=$bdrecord['data'];
						//echo $bwc.' '.$bdata.'<br>';
					}
					//end of phase 3
					if($head = head::where('id',$idofrecord)->first()){
						$flag = $hd_exists = true;
						$hdrecord = $head->getAttributes();
						$hwc = $hdrecord['word_count'];$hdata=$hdrecord['data'];
						//echo $hwc.' '.$hdata.'<br>';
					}
					//end of phase 4
					if($img = img::where('id',$idofrecord)->first()){
						$flag = $im_exists = true;
						$imrecord = $img->getAttributes();
						$iwc = $imrecord['word_count'];$idata = $imrecord['data'];
						//echo $iwc.' '.$idata;
					}
					//end of phase 5
					if($link= link::where('id',$idofrecord)->first()){
						$flag = $li_exists = true;
						$lirecord = $link->getAttributes();
						$lwc = $lirecord['word_count'];$ldata = $lirecord['data'];
						//echo $lwc.' '.$ldata.'<br>';
					}
					if($flag){
						$this->jsonify($name,$type,$created_at,$url,$public,
										$word_count,$data,
										$bwc,$bdata,
										$hwc,$hdata,
										$iwc,$idata,
										$lwc,$ldata,
										$ht_exists,$bd_exists,$hd_exists,$im_exists,$li_exists);
					}
					else{
						echo json_encode(['type'=>'error','message'=>'No Analysis data found']);
					}

					}catch(Exception $e){
						echo $e->getMessage();
						
					}
			}
	public function getdata($json_data,$index){

		$data;$oneword;$onewordc;$onewordd;$oneword_arr;$onewordc_arr;$onewordd_arr;

		if(isset($data))unset($data);
		if(isset($oneword))unset($oneword);
		if(isset($onewordc))unset($onewordc);
		if(isset($onewordd))unset($onewordd);
		if(isset($oneword_arr))unset($oneword_arr);
		if(isset($onewordc_arr))unset($onewordc_arr);
		if(isset($onewordd_arr))unset($onewordd_arr);

		$data = array(array(),array(),array());
		$oneword_arr = array();
		$onewordc_arr = array();
		$onewordd_arr = array();
		if(strcmp($index, "oneword")==0){
			if(!empty($json_data->oneword)){
				$oneword_arr = explode('-',$json_data->oneword);
				$onewordc_arr = explode('-', $json_data->onewordc);
				$onewordd_arr = explode('-', $json_data->onewordd);
			}
		}
		else if(strcmp($index, "twoword")==0){
			if(!empty($json_data->twoword)){
				 $oneword_arr = explode('-',$json_data->twoword);
				 $onewordc_arr = explode('-', $json_data->twowordc);
				 $onewordd_arr = explode('-', $json_data->twowordd);
			}
		}
		else{
				if(!empty($json_data->threeword)){ 
					$oneword_arr = explode('-',$json_data->threeword);
				    $onewordc_arr = explode('-', $json_data->threewordc);
					$onewordd_arr = explode('-', $json_data->threewordd);
				}
		}

		$data[0] = $oneword_arr;
		$data[1] = $onewordc_arr;
		$data[2] = $onewordd_arr;

		//echo '<br>hello<br>';
		//print_r($data);
		array_multisort($data[1],SORT_DESC,$data[0],$data[2]);
		//print_r($data);
		return $data;
	}

	public function jsonify($name,$type,$created_at,$url,$public,
							$word_count,$data,
							$bwc,$bdata,
							$hwc,$hdata,
							$iwc,$idata,
							$lwc,$ldata,
							$ht_exists,$bd_exists,$hd_exists,$im_exists,$li_exists){
		$analysis_list = array('name'=>$name,'type'=>$type,'created_at'=>$created_at);
		//$url-----------------------------then add the url------------------
		//print_r(json_encode([$analysis_list,'url'=>$url,'html'=>$allhtml,'body'=>$allbody,'heading'=>$allhead,'image'=>$allimg,'link'=>$alllink],JSON_PRETTY_PRINT));
		if($ht_exists){
			$json_data = json_decode($data);
			//print_r($json_data);
			//$oneowrd  = getdata($json_data,"oneword")
			//twoword - getdata($,"twoword")
			//threeword = getdata($json_data,"threeword");
			$oneword = $this->getdata($json_data,'oneword');
			$twoword = $this->getdata($json_data,'twoword');
			$threeword = $this->getdata($json_data,'threeword');
			//print_r($threeword);
			$allhtml = array('word_count'=>$word_count,'oneword'=>$oneword[0],'onewordc'=>$oneword[1],'onewordd'=>$oneword[2],
													   'twoword'=>$twoword[0],'twowordc'=>$twoword[1],'twowordd'=>$twoword[2],
													   'threeword'=>$threeword[0],'threewordc'=>$threeword[1],'threewordd'=>$threeword[2]);
			//print_r($allhtml);
			
		}else
			$allhtml= array();

		if($bd_exists){
			$json_data = json_decode($bdata);
			$oneword = $this->getdata($json_data,'oneword');
			$twoword = $this->getdata($json_data,'twoword');
			$threeword = $this->getdata($json_data,'threeword');
			$allbody = array('word_count'=>$bwc,'oneword'=>$oneword[0],'onewordc'=>$oneword[1],'onewordd'=>$oneword[2],
												'twoword'=>$twoword[0],'twowordc'=>$twoword[1],'twowordd'=>$twoword[2],
												'threeword'=>$threeword[0],'threewordc'=>$threeword[1],'threewordd'=>$threeword[2]);

		}else
			$allbody = array();

		if($hd_exists){
			$json_data = json_decode($hdata);
			$oneword = $this->getdata($json_data,'oneword');
			$twoword = $this->getdata($json_data,'twoword');
			$threeword = $this->getdata($json_data,'threeword');		
			$allhead = array('word_count'=>$hwc,'oneword'=>$oneword[0],'onewordc'=>$oneword[1],'onewordd'=>$oneword[2],
												'twoword'=>$twoword[0],'twowordc'=>$twoword[1],'twowordd'=>$twoword[2],
												'threeword'=>$threeword[0],'threewordc'=>$threeword[1],'threewordd'=>$threeword[2]);
		}else
			$allhead = array();
		
		if($im_exists){
			$json_data = json_decode($idata);
			$oneword = $this->getdata($json_data,'oneword');
			$twoword = $this->getdata($json_data,'twoword');
			$threeword = $this->getdata($json_data,'threeword');
			$allimg = array('word_count'=>$iwc, 'oneword'=>$oneword[0],'onewordc'=>$oneword[1],'onewordd'=>$oneword[2],
												'twoword'=>$twoword[0],'twowordc'=>$twoword[1],'twowordd'=>$twoword[2],
												'threeword'=>$threeword[0],'threewordc'=>$threeword[1],'threewordd'=>$threeword[2]);
		}else
			$allimg = array();

		if($li_exists){
			$json_data = json_decode($ldata);
			$oneword = $this->getdata($json_data,'oneword');
			$twoword = $this->getdata($json_data,'twoword');
			$threeword = $this->getdata($json_data,'threeword');
			$alllink = array('word_count'=>$lwc,'oneword'=>$oneword[0],'onewordc'=>$oneword[1],'onewordd'=>$oneword[2],
												'twoword'=>$twoword[0],'twowordc'=>$twoword[1],'twowordd'=>$twoword[2],
												'threeword'=>$threeword[0],'threewordc'=>$threeword[1],'threewordd'=>$threeword[2]);

		}else
			$alllink = array();

		print_r(json_encode(['basic'=>$analysis_list,'url'=>$url,'public'=>$public,'html'=>$allhtml,'body'=>$allbody,'heading'=>$allhead,'image'=>$allimg,'link'=>$alllink],JSON_PRETTY_PRINT));

	    }

	public function logout(){

		session_destroy();
		header('Location:'.URL.'/home/index/');
	}
}
?>