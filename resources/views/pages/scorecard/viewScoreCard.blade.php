@extends ('layout.default')
@section ('content')

<div class="content-area clearfix">
	

	<h3 style="text-align: center;">Scorecard: {{$user['name']}} @foreach($user->userclients as $row)| {{$row->clientname->client_name}}  @endforeach</h3>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<ul><li><h3 class="pull-left">{{$score->months->month}} {{$score['year']}}</h3></li></ul>
				
				<ul class="add-links pull-right">
					
					<li id="viewscorecard"><a href="#" onclick="openScoreCardModal(); currentSlide(1)">View</a></li>

					<li><a href="#" id="deleteimage">Delete</a>
					</li>
					<li><a href="{{ URL::to('admin/users/scorecard/'.$user['id'])}}"  id="deviceexport">Close</a></li>


				</ul>

			</div>
			<hr>
			{{ Form::open(array('url' => 'admin/users/scorecard/image/remove/'.$score['id'],'method'=>'POST','files'=>'true','id'=>'imageRemove') )}}
			<div style="display: none">{{$i = "1"}} {{$n = '0'}} {{$j = "1"}}</div>
			@foreach($scoreImage as $row)
			<div class="col-xs-3">
				<div class="img-box">
					<div style="display: none">{{$n++}}</div>

					 <input type="checkbox" name="chekImage[]" class="scorecard chk_Image" value="{{$row->id}}">
					<img src="{{URL::to('public/'.$row->scorecardImage)}}" onclick="openScoreCardModal(); currentSlide({{$i}})" class="hover-shadow">
					 <div style="display: none">{{$i++}}</div>
				</div>
			</div>

			@endforeach
			{{ Form::close() }}
		</div>
	</div>
	<div id="scorecard-modal" class="modal scorecard-modal">
		<div class="modal-content">
			@foreach($scoreImage as $row)
			

            <div class="scorecard-slides">
                <img src="{{URL::to('public/'.$row->scorecardImage)}}" class='zoom-img' id="{{$j}}" data-id="{{$j}}" >
                <div class="numbertext">
                    <span class="buttons-container">
                       <!--  <i class="fa fa-calendar calendar-icon" aria-hidden="true"></i>
                        <i class="fa fa-user user-icon" aria-hidden="true"></i>
                        --> 
                        <span class="close cursor" onclick="closeScoreCardModal()">&times;</span>
                    </span>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                  <span class="number">{{$j++}} of {{$n}}</span>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>


    <div class="bottom-count clearfix">

    </div>



</div>
<script>
jQuery(document).ready(function() {

});

var showSlides = function(n) {
    var i;
    var slides = document.getElementsByClassName("scorecard-slides");
   
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}


var bindZoom = function() {
    // $(document).ready(function() {
    setTimeout(function() {
        $(".zoom-img").imgViewer2({
            zoomStep: 0.5,
            zoomMax: undefined,
            zoomable: true,
            dragable: true,
            onDestroy: true
        });

        $('.leaflet-container').css({
            'z-index': 3,
        });
    var c = document.getElementsByClassName('viewport');

    for (i = 0; i < c.length; i++) { 
	    console.log($(c[i]).height());
	    var hei = $(c[i]).height();
	    if(hei == 100){

	    	 $(c[i]).css({
	    	 	'visibility': 'hidden'
	    	 	
	    	 });
	    }
	}
   
    }, 0);

}

var unBindZoom = function() {
    $(".zoom-img").imgViewer2('destroy');
}

var openScoreCardModal = function() {
    document.getElementById('scorecard-modal').style.display = "block";
    bindZoom();
    

    // var cssVar = $(".viewport").height(30); 
		  //  console.log(cssVar);
}

var closeScoreCardModal = function() {
    document.getElementById('scorecard-modal').style.display = "none";
    unBindZoom();
}

var slideIndex = 1;
showSlides(slideIndex);

var plusSlides = function(n) {
    showSlides(slideIndex += n);
    unBindZoom();
    bindZoom();
}

var currentSlide = function(n) {
    showSlides(slideIndex = n);
}
</script>

<script type="text/javascript">
	$(document).ready(function(){

		 // $(".modal-content").imageBox();
		 
		$("#deleteimage").click(function(){

			if($(".chk_Image:checked").length == 0)
			{

				alert("Please select scorecard image and delete");
				return false;
			}
			else
			{
				if(confirm("Are you sure you want to delete scorecard image?"))
				{
					$("#imageRemove").submit();
					return true;
				}
				else{
					return false;
				}
			}
		});
	});

</script>


@stop