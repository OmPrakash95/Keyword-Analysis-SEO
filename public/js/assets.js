$(document).ready(function() {
  $("#clear").click(function(){
    $('#submit').prop('disabled',false);
    $('#analysis_form').trigger("reset");
    $('#result').html("");
    $('#analysis_result').html("");
  });
  $("#his").click(function(){
      $('#maptohis').replaceWith('<a href="#history">History</a>');
      $("#history").html("");
      $.ajax({
                        type: "POST",
                        url: 'http://localhost/seo/public/seoco/getids/'+uid,
                        success: function (data) {
                            putinitials("#history");
                            var report = jQuery.parseJSON(data);
                            $.each(report.id, function(index,value){
                                    $.ajax({
                                  type:"POST",
                                  url: 'http://localhost/seo/public/seoco/retrieve/id/'+value,
                                  success: function (data){
                                    var json = jQuery.parseJSON(data);
                                    puthistory('#history',json,value);
                                    //startparsing(obj);
                                  }
                                });                                                       
                            });
                            //console.log(obj);
                          }
                    });
    //("#history").html("")
  });
	$("#analysis_form").submit(function() {
          var mk,md,pt,isp_s;
          if($('#mk').is(':checked'))mk=1;
          else mk=0;
          if($('#md').is(':checked'))md=1;
          else md=0;
          if($('#pt').is(':checked'))pt=1;
          else pt=0;
          if($('#isp').is(':checked'))isp=1;
          else isp=0;
            var name = $("input#name").val();
            var text = $("textarea#text_content").val();
            var mile = $("input#mile").val();
            var mifr = $("input#mifr").val();
            var swords = $("textarea#swords").val();
            var type = $("select#type").val();  
            var post_data = JSON.stringify({project_name:name,content_data:text,
                meta_keywords:mk,meta_description:md,page_title:pt,ispublic:isp,
                min_length:mile,min_freq:mifr,stop_words:swords,content_type:type,
                userid:uid});
                $("#result").html("<span class=\"bg-info\">Analysis in progress...</span>");
                $("#submit").prop('disabled',true);
                $("#clear").prop('disabled',true);
                    $.ajax({
                        type: "POST",
                        url: 'http://localhost/seo/public/seoco/process/',
                        data: {data:post_data},
                        success: function (data) {
                            var obj = jQuery.parseJSON(data);
                          if(obj.type=="success"){           
                          $("#clear").prop('disabled',false);                
                            $.ajax({
                              type:"POST",
                              url: 'http://localhost/seo/public/seoco/retrieve/id/'+obj.id,
                              success: function (data){
                                var json = jQuery.parseJSON(data);
                                putabstract('analysis_result',json,obj.id);
                                //startparsing(obj);
                              }
                            });
                            $('#result').html("<span class=\"bg-success\">Success!!</span>");
                          }
                          if(obj.type=="error"){
                            $('#result').html("<span class=\"bg-danger\">Error:"+obj.message+"</span>");
                            $("#submit").prop('disabled',false);
                            $("#clear").prop('disabled',false);
                          }

                          }
                    });
    return false;
	});

});

function putinitials(div,inner_div){
  $(div).append('<div class="row" style="padding-bottom: 20px;"><div class="col-md-12"><h2>History</h2></div></div>');
  console.log("Done");
}

function puthistory(div,obj,id){
  var url=" ";
  var name = obj.basic.name;
  var report_id = id;
  var type = obj.basic.type;
  var creation = obj.basic.created_at;
  if(obj.public>=1)lockspan = '<span class="glyphicon glyphicon-lock" style="color: #5DA521"></span>';
  else lockspan = '<span class="glyphicon glyphicon-lock" style="color: rgba(199, 36, 36, 0.83);"></span>';
  if((obj.url)&& (0!==obj.url.length)){ url = obj.url; }
  console.log(name+" "+report_id+" "+type+" "+creation+" "+url);
  str1 = '<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#all-'+report_id+'">All</a></li><li><a data-toggle="tab" href="#body-'+report_id+'">Body</a></li><li><a data-toggle="tab" href="#heading-'+report_id+'">Heading</a></li><li><a data-toggle="tab" href="#images-'+report_id+'">Images</a></li><li><a data-toggle="tab" href="#links-'+report_id+'">Links</a></li></ul><div class="tab-content"><div id="all-'+report_id+'" class="tab-pane fade in active"><h3>All</h3><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.html)+'</table></p></div><div id="body-'+report_id+'" class="tab-pane fade"><h3>Body</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.body)+'</table></p></div><div id="heading-'+report_id+'" class="tab-pane fade"><h3>Heading</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.heading)+'</table></p></div><div id="images-'+report_id+'" class="tab-pane fade"><h3>Images</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.image)+'</table></p></div><div id="links-'+report_id+'" class="tab-pane fade"><h3>Links</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.link)+'</table></p></div></div>';
  str='<div class="panel-group" id="parent'+report_id+'"><div class="panel panel-default"><div class="panel-heading col-md-6"><h4><span class="text-capitalize"><a href="#'+report_id+'" data-toggle="collapse" data-parent="#parent'+report_id+'" class="collapsed" aria-expanded="false">'+name+'</a></span><small> ['+url+'] '+lockspan+'</small></h4></div><div class="panel-heading col-md-6"><h4 class="pull-right">'+creation+'</h4></div><div class="panel-collapse collapse-in collapse" id="'+report_id+'" aria-expanded="true"><div class="panel-body"><div class="row"><div class="col-md-6"><h4 class="pull-left">'+type+'</h4></div><div class="col-md-6"><a href="#"><h4 class="pull-right">#'+report_id+'</h4></a></div></div>'+str1+'</div>';
  $(div).append(str);
      $('html, body').animate({
        scrollTop: $("#history").offset().top
    }, 500);
}
function putabstract(div,obj,id){
  var url=" ";
  var name = obj.basic.name;
  var report_id = id;
  var type = obj.basic.type;
  var creation = obj.basic.created_at;
  if(obj.public>=1)lockspan = '<span class="glyphicon glyphicon-lock" style="color: #5DA521"></span>';
  else lockspan = '<span class="glyphicon glyphicon-lock" style="color: rgba(199, 36, 36, 0.83);"></span>';
  if(obj.url!=null){ url = obj.url; }
  console.log(name+" "+report_id+" "+type+" "+creation+" "+url);
  str='<div class="row" style="padding-bottom: 20px;"><div class="col-md-6"><h2><span class="text-capitalize">'+name+'</span> <small>['+url+'] '+lockspan+'</small></h2><div class="row"><div class="col-md-12 pull-left"><h4 class="text-capitalize">'+type+'</h4></div></div></div><div class="col-md-6"><h3 class="pull-right"><a href="#">#'+report_id+'</a></h3><div class="row"><div class="col-md-12"><h4 class="pull-right">'+creation+'</h4></div></div></div></div>';
   $('#analysis_result').append(str);
  str1 = '<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#all">All</a></li><li><a data-toggle="tab" href="#body">Body</a></li><li><a data-toggle="tab" href="#heading">Heading</a></li><li><a data-toggle="tab" href="#images">Images</a></li><li><a data-toggle="tab" href="#links">Links</a></li></ul><div class="tab-content"><div id="all" class="tab-pane fade in active"><h3>All</h3><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.html)+'</table></p></div><div id="body" class="tab-pane fade"><h3>Body</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.body)+'</table></p></div><div id="heading" class="tab-pane fade"><h3>Heading</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.heading)+'</table></p></div><div id="images" class="tab-pane fade"><h3>Images</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.image)+'</table></p></div><div id="links" class="tab-pane fade"><h3>Links</h3><p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr>'+parse(obj.link)+'</table></p></div></div>';
  $('#analysis_result').append(str1);
      $('html, body').animate({
        scrollTop: $("#analysis_result").offset().top
    }, 500);
}

function parse(obj){//check if undefined of object - else get the object.oneword length
  var empty = '<tr><td colspan="9"><div class="text-danger">No Analysis data for this content found.</div></td></tr>';
  var count;
  if(obj == null || obj.oneword == null)return empty;
  else{
    count = Object.keys(obj.oneword).length;
    console.log("Count:"+count);
  }
  var result = "";
  //console.log("type:"+typeof(obj)+" Length:"+Object.keys(obj.oneword).length);
  for(var i=0; i < count ; i++){
  str = '<tr><td>'+getdata(obj.oneword[i])+'</td><td>'+getdata(obj.onewordc[i])+'</td><td>'+getdata(obj.onewordd[i])+'</td><td>'+getdata(obj.twoword[i])+'</td><td>'+getdata(obj.twowordc[i])+'</td><td>'+getdata(obj.twowordd[i])+'</td><td>'+getdata(obj.threeword[i])+'</td><td>'+getdata(obj.threewordc[i])+'</td><td>'+getdata(obj.threewordd[i])+'</td></tr>';
  result = result + str;
  }
  return result;
}

function getdata(variable){
  if(variable == undefined)return "-";
  else return variable;
}