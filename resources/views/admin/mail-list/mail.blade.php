@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mail Generator</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active">Mail Generator</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mail Generator</h3>
                    @if($errors->any())
                        <input type="hidden" id="alert" value="{{$errors->first()}}">
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{url('ad-mail-gen')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="user" class="col-4 col-form-label">User</label>
                            <div class="col-8">
                                <select id="user" name="user" class="custom-select form-control">
                                    <option value="0" selected>Select...</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->user_id}}">{{$user->name}} - {{$user->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label">Email</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-at"></i>
                                        </div>
                                    </div>
                                    <input id="email" name="email" type="text" class="form-control" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Provider_Select" class="col-4 col-form-label">Email Provider</label>
                            <div class="col-8">
                                <select id="provider" name="provider" class="custom-select form-control">
                                    <option value="gmail.com">GMAIL.COM</option>
                                    <option value="googlemail.com">GOOGLEMAIL.COM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label" for="password">Password</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-asterisk"></i>
                                        </div>
                                    </div>
                                    <input id="password" name="password" type="password" class="form-control" required="required">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="eye"><i class="fas fa-eye" id="es"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recovery_email" class="col-4 col-form-label">Recovery Email</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input id="recovery_email" name="recovery_email" type="text" class="form-control" required="required">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number_dot" class="col-4 col-form-label">Number Of Dot</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-bullseye"></i>
                                        </div>
                                    </div>
                                    <input id="number_dot" name="number_dot" type="number" min="1" max="3" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-4 col-8 text-right">
                                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>

@endsection
