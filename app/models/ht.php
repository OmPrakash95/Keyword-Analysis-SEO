<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class ht extends Eloquent{
    protected $timestamp = [];
	protected $fillable=['id','content','url','stopwords','word_count','data'];
	protected $table = 'analysis_reports';
}
?>