<!--/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 2/20/2018
 * Time: 5:45 PM
 */-->

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

                            <th>Category Name</th>
                            <th>Project Name</th>
                            <th>Category Avg APP</th>
                            <th>Client Name</th>
                            <th>Device Level</th>

                        </tr>

                        </thead>

                        @if (count($wrongdata)>0)
                            <tbody id="device_survey_result">
                            @foreach($wrongdata as $row)
                                <tr>
                                    <td>{{$row['category_name']}}</td>
                                    <td>{{$row['project_name']}}</td>
                                    <td>{{$row['category_avg_app']}}</td>
                                    <td>{{$row['client_name']}}</td>
                                    <td>{{$row['device_level']}}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        @else
                            <tr>
                                <td colspan='5' style='text-align:center;'>No Records Found.</td>
                            </tr>

                        @endif
                    </table>
                </div>
                <div class="bottom-count clearfix">

                </div>
            </div>
        </div>

    </div>




@stop