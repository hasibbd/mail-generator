@extends('user.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Generated Mail List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Generated Mail List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generated Mail List</h3>
                    <div class="text-right">
                        <a href="{{url('export')}}" class="btn btn-sm btn-primary">Export to Excel</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered example" id="testData">
                        <thead>
                        <tr>
                            <th>Main Mail</th>
                            <th>Generated Mail</th>
                            <th>Last Posted</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                      {{--  <tbody>
                        @foreach($gen as $g)
                        <tr >
                            <td>{{$g->target_mail.'@'.$g->target_provider}}</td>
                            <td>{{$g->gen_mail."@".$g->target_provider}}</td>
                            <td>@if($g->posted_time) {{date("d-m-Y", strtotime($g->posted_time))}} @endif</td>
                            <td>
                                <a href="{{url("post/".$g->id)}}" class="btn btn-sm btn-primary">Post</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Main Mail</th>
                            <th>Generated Mail</th>
                            <th>Last Posted</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>--}}
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
