<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class pt extends Eloquent{
    protected $timestamp = [];
	protected $fillable=['id','content','word_count','data'];
	protected $table = 'pt';
}
?>