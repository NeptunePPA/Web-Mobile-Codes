@extends ('layout.default')
@section ('content')
    <div class="add_new">
        <div class="add_new_box">

            <div class="col-md-12 col-lg-12 modal-box">
                <a title="Add Device" href="{{ URL::to('admin/devices') }}" class="pull-right" data-toggle="modal">X</a>
                <h4> Device Feature Images </h4>
                <br>
                {{ Form::open(array('url' => 'admin/devices/features/image/store','files'=>'true')) }}

                <div class="input1 fileup">
                    <label>Exclusives Image:</label>
                    {{ Form::text('exclusives_image',$image['exclusiveimage'] == null ? '' : $image['exclusiveimage'],array('placeholder'=>'Exclusives Image','class'=>'file_name','data-id'=>'ex')) }}
                    {{ Form::file('exclusiveimage',array('class'=>'file-btn fp_upload','data-id'=>'ex')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'ex'))}}
                    &nbsp;
                    @if($image['exclusiveimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['exclusiveimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Longevity Image:</label>
                    {{ Form::text('longevity_image',$image['longevityimage'] == null ? '' : $image['longevityimage'],array('placeholder'=>'Longevity Image','class'=>'file_name','data-id'=>'long')) }}
                    {{ Form::file('longevityimage',array('class'=>'file-btn fp_upload','data-id'=>'long')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'long'))}}
                    &nbsp;
                    @if($image['longevityimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['longevityimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Shock Image:</label>
                    {{ Form::text('shock_image',$image['shockimage'] == null ? '' : $image['shockimage'],array('placeholder'=>'Shock Image','class'=>'file_name','data-id'=>'shock')) }}
                    {{ Form::file('shockimage',array('class'=>'file-btn fp_upload','data-id'=>'shock')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'shock'))}}
                    &nbsp;
                    @if($image['shockimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['shockimage'])}}" height="50px" width="50px">
                    @endif
                </div>


                <div class="input1 fileup">
                    <label>Size Image:</label>
                    {{ Form::text('size_image',$image['sizeimage'] == null ? '' : $image['sizeimage'],array('placeholder'=>'Size Image','class'=>'file_name','data-id'=>'size')) }}
                    {{ Form::file('sizeimage',array('class'=>'file-btn fp_upload','data-id'=>'size')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'size'))}}
                    &nbsp;
                    @if($image['sizeimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['sizeimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Research Image:</label>
                    {{ Form::text('research_image',$image['researchimage'] == null ? '' : $image['researchimage'],array('placeholder'=>'Research Image','class'=>'file_name','data-id'=>'research')) }}
                    {{ Form::file('researchimage',array('class'=>'file-btn fp_upload','data-id'=>'research')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'research'))}}
                    &nbsp;
                    @if($image['researchimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['researchimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Website Page Image:</label>
                    {{ Form::text('website_image',$image['websiteimage'] == null ? '' : $image['websiteimage'],array('placeholder'=>'Website Page Image','class'=>'file_name','data-id'=>'website')) }}
                    {{ Form::file('websiteimage',array('class'=>'file-btn fp_upload','data-id'=>'website')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'website'))}}
                    &nbsp;
                    @if($image['websiteimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['websiteimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>URL Image:</label>
                    {{ Form::text('url_image',$image['urlimage'] == null ? '' : $image['urlimage'],array('placeholder'=>'URL Image','class'=>'file_name','data-id'=>'Url')) }}
                    {{ Form::file('urlimage',array('class'=>'file-btn fp_upload','data-id'=>'Url')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'Url'))}}
                    &nbsp;
                    @if($image['urlimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['urlimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Over All Value Image:</label>
                    {{ Form::text('overall_image',$image['overallimage'] == null ? '' : $image['overallimage'],array('placeholder'=>'Over All Value Image','class'=>'file_name','data-id'=>'overall')) }}
                    {{ Form::file('overallimage',array('class'=>'file-btn fp_upload','data-id'=>'overall')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'overall'))}}
                    &nbsp;
                    @if($image['overallimage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['overallimage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div class="input1 fileup">
                    <label>Performance Url Image:</label>
                    {{ Form::text('performanceImage',$image['performanceImage'] == null ? '' : $image['performanceImage'],array('placeholder'=>'performance Url Image','class'=>'file_name','data-id'=>'performance')) }}
                    {{ Form::file('performanceImage',array('class'=>'file-btn fp_upload','data-id'=>'performance')) }}
                    {{Form::input('button','Browse','Browse' ,array('class'=>'browse','data-id'=>'performance'))}}
                    &nbsp;
                    @if($image['performanceImage'] != null)
                        <img src="{{URL::to('public/upload/devicefeature/'.$image['performanceImage'])}}" height="50px" width="50px">
                    @endif
                </div>

                <div>
                    {{ Form::submit('SAVE',array('class'=>'btn_add_new')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
<script type="application/javascript">

    $('.fp_upload').hide();
    $(".browse").click(function(){
        var id = $(this).attr("data-id");
        $('.fp_upload[data-id=' + id + ']').click();
        var file = $('.fp_upload[data-id=' + id + ']').val();
    });
    $('.fp_upload').change(function() {
        var id = $(this).attr("data-id");
        $('.file_name[data-id = '+id+']').val($(this).val());
    });
</script>
@stop       