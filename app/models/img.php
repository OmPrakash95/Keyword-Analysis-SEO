<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class img extends Eloquent{
    protected $timestamp = [];
	protected $fillable=['id','content','word_count','data'];
	protected $table = 'img';
}
?>