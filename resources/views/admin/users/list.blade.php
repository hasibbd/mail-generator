@extends('admin.layout')
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
                        <button class="btn btn-sm btn-primary" id="call_modal">Add New</button>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table smalls table-bordered " id="table2">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr >
                            <td>{{$user->name}}</td>
                            <td>{{$user->user_id}}</td>
                            <td>{{$user->email}}</td>
                            <td>@if($user->type == 1) <button class="btn btn-sm btn-primary">Admin</button> @else <button class="btn btn-sm btn-warning">User</button> @endif</td>
                            <td>@if($user->status == 1) <button class="btn btn-sm btn-success">Enabled</button> @else <button class="btn btn-sm btn-danger">Disabled</button> @endif</td>
                            <td>
                             <button class="btn btn-sm btn-primary">Status</button>
                                <button class="btn btn-sm btn-warning">Edit</button>
                             <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form4submit" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="name">Name</label>
                               <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="email">Email</label>
                               <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="password">Password</label>
                               <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="type">Type</label>
                               <select class="form-control" name="type" id="type">
                                   <option value="1">Admin</option>
                                   <option value="2" selected>User</option>
                               </select>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
