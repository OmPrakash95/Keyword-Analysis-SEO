<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class link extends Eloquent{
    protected $timestamp = [];
	protected $fillable=['id','content','word_count','data'];
	protected $table = 'link';
	//protected $table = 'trial';
}
?>