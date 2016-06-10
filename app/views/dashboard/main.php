<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Keyword Analysis Web application</title>
		<meta name="description" content="">
		<meta name="author" content="Om Prakash">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   		<script>
   		var uid = <?php echo $_SESSION['id']; ?>;
		</script>
		<link href="http://localhost/seo/public/css/simple-sidebar.css" rel="stylesheet">
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <link href="http://localhost/seo/public/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://localhost/seo/public/js/bootstrap.min.js"></script>
		<script src="http://localhost/seo/public/js/assets.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <div id="user" style="color: #736F6E;">
                        Hello <?php echo $_SESSION['name']; ?>
                    </div>
                </li>
                <li>
                    <a href="#" id="db">Dashboard</a>
                </li>
                <li><div id="maptohis">
                    <a href="#history" id="his">History</a>
                    </div>
                </li>
                <li>
                    <a href="http://localhost/seo/public/dashboard/logout/">Logout</a>
                </li>
            </ul>
        	</div>
        	<div id="page-content-wrapper">
            	<div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                       <div class="row"><div class="col-md-6"><h1>Analyse</h1></div><div class="col-md-6"><h4 id="result"></h4></div></div>
							<form name="analysis_form" id="analysis_form" >
							  <div class="form-group">
								<input class="form-control control-label" type="text" name="name" id="name" placeholder="Enter a Project name" required/>
							  </div>
							  <div class="form-group">
								<textarea class="form-control control-label"  style="width: 100%;" name="text_content" id="text_content" rows="8" placeholder="http://www.google.com or HTML or Plain texts.." required></textarea>
							  </div>
							<div class="row">
							  <div class="form-group col-md-6">	
								<input type="checkbox" name="mk" id="mk" value="1" checked>Include Meta Keywords
                              </div>
							  <div class="form-group col-md-6">
								<input type="checkbox" name="md" id="md" value="1" checked="">Include Meta Description
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6">
								<input type="checkbox" name="pt" id="pt" value="1" checked="">Include Page Title
							  </div>
							  <div class ="form-group col-md-6">
							    <input type="checkbox" name="isp" id="isp" value="1" checked=""> Public
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6">
								<input type="number" name="mile" id="mile" value="2" required>Min. Word length
							  </div>
							  <div class="form-group col-md-6">
								<input type="number" name="mifr" id="mifr" value="2" required>Min. word occurence
							  </div>
							</div>
							  <div class="form-group">
								<textarea class="form-control control-label" style="width: 100%;" name="swords" id="swords" rows="3" placeholder="Enter Stopwords seperated by ,"></textarea>
							  </div>
							  <div class="form-group">
								<select class="form-control control-label" name="type" id="type" required>
									<option value="0">URL</option>
									<option value="1">HTML</option>
									<option value="2">Plain Text</option>
								</select>
							  </div>
								<input type="submit" class="btn btn-default" id="submit" value="submit"> <button id="clear" class="btn btn-primary">Clear</button>
							</form>
	                    </div>
	                </div>
	           						<hr>
<!--ana-->     <div id="analysis_result"><!--analysis starts here
	              <div class="row" style="padding-bottom: 20px;">
	              	<div class="col-md-6"><h2><span class="text-capitalize">Zoho</span> <small>[http://google.com]</small></h2>
	              		<div class="row">
	              			<div class="col-md-12 pull-left"><h4 class="text-capitalize">HTML</h4></div>
	              		</div>
	              	</div>
	              	<div class="col-md-6"><h3 class="pull-right"><a href="#">#131212</a></h3><div class="row"><div class="col-md-12"><h4 class="pull-right">19th Monday 2016</h4></div></div>
	              	</div>
	              </div>
	              //end of Row
	              //Table contents with Tab starts here
				  <ul class="nav nav-tabs">
				    <li class="active"><a data-toggle="tab" href="#all">All</a></li>
				    <li><a data-toggle="tab" href="#body">Body</a></li>
				    <li><a data-toggle="tab" href="#heading">Heading</a></li>
				    <li><a data-toggle="tab" href="#images">Images</a></li>
				    <li><a data-toggle="tab" href="#links">Links</a></li>
				  </ul>

				  <div class="tab-content">
				    <div id="all" class="tab-pane fade in active">
				      <h3>All</h3>
				      <p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr><tr><td>Word</td><td>23</td><td>16.3%</td><td>Word and</td><td>23</td><td>1.3%</td><td>Word all is</td><td>13</td><td>6.3%</td></tr></table></p>
				    </div>
				    <div id="body" class="tab-pane fade">
				      <h3>Body</h3>
				      <p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr><tr><td>Word</td><td>23</td><td>16.3%</td><td>Word and</td><td>23</td><td>1.3%</td><td>Word all is</td><td>13</td><td>6.3%</td></tr></table></p>
				    </div>
				    <div id="heading" class="tab-pane fade">
				      <h3>Heading</h3>
				      <p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr><tr><td>Word</td><td>23</td><td>16.3%</td><td>Word and</td><td>23</td><td>1.3%</td><td>Word all is</td><td>13</td><td>6.3%</td></tr></table></p>
				    </div>
				    <div id="images" class="tab-pane fade">
				      <h3>Images</h3>
				      <p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr><tr><td>Word</td><td>23</td><td>16.3%</td><td>Word and</td><td>23</td><td>1.3%</td><td>Word all is</td><td>13</td><td>6.3%</td></tr></table></p>
				    </div>
				    <div id="links" class="tab-pane fade">
				      <h3>Links</h3>
				      <p><table class="table table-striped"><tr><th>One word</th><th>One word count</th><th>One word density</th><th>Two word</th><th>Two word count</th><th>Two word density</th><th>Three word</th><th>Three word count</th><th>Three word Density</th></tr><tr><td>Word</td><td>23</td><td>16.3%</td><td>Word and</td><td>23</td><td>1.3%</td><td>Word all is</td><td>13</td><td>6.3%</td></tr></table></p>
				    </div>
				  </div>-->
<!--Analsyisresult--></div><!--Anlysis result ends here-->
				<div id="history">
				</div>
            	</div><!--container fluid-->
        	</div><!--content wrapper-->
		</div><!--wrapper-->
	</body>
</html>