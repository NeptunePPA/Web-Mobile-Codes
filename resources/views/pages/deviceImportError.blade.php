@extends ('layout.default')
@section ('content')

<div class="content-area clearfix">



    <div class="tab-pane" id="Survey">
        <div class="content-area clearfix" style="padding:30px 30px 30px;">
                <h1 class="" align="center">Error Data</h1>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            
                            <th>Level Name</th>
                            <th>Project Name</th>
                            <th>Category Name</th>
                            <th>Manufacturer Name</th>
                            <th>Device Name</th>
                            <th>Model Name</th>
                            <th>Status</th>
                            <th>Exclusive</th>
                            <th>Longevity</th>
                            <th>Shock</th>
                            <th>Size</th>
                            <th>Research</th>
                            <th>Website Page</th>
                            <th>Url</th>
                            <th>Overall Value</th>
                        </tr>


                    </thead>

                    @if (count($wrongdata)>0)
                    <tbody id="device_survey_result">
                        @foreach($wrongdata as $row)
                        <tr>
                            <td>{{$row['level_name']}}</td>
                            <td>{{$row['project_name']}}</td>
                            <td>{{$row['category_name']}}</td>
                            <td>{{$row['manufacturer_name']}}</td>
                            <td>{{$row['device_name']}}</td>
                            <td>{{$row['model_name']}}</td>
                            <td>{{$row['status']}}</td>
                            <td>{{$row['exclusive']}}</td>
                            <td>{{$row['longevity']}}</td>
                            <td>{{$row['shock']}}</td>
                            <td>{{$row['size']}}</td>
                            <td>{{$row['research']}}</td>
                            <td>{{$row['website_page']}}</td>
                            <td>{{$row['url']}}</td>
                            <td>{{$row['overall_value']}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    @else
                    <tr> <td colspan='10' style='text-align:center;'>No Records Found.</td> </tr>

                    @endif
                </table>
            </div>
            <div class="bottom-count clearfix">

            </div>
        </div>
    </div>

</div>




@stop