@extends('layouts.admin.dashboard')

@section('module-content')
<div class="container">
    <div class="row">
        <div class="col-12 form-container my-3">
            <form class="">
                <div class="form-group row pt-0">
                    <div class="col-12 form-header">
                        <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">CONTROL PANEL</h2>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 head">
                        Encashment Settings
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Encashment Status</label>
                    <div class="col-sm-9">
                        <select class="form-control form-control-sm col-2 ">
                            <option>ACTIVE</option>
                            <option>INACTIVE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Admin Fee</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                    <label for="inputPassword" class="col-sm-6 col-form-label">percentage 0.1 = 10%</label>
                </div>
                <div class="form-group row">
                    <div class="col-12 head">
                        Product UNILEVEL Settings
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Personal Unilevel</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 1</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 2</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 3</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 4</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 5</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 6</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 7</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 8</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 9</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 10</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 head">
                        InDirenct Settings
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 1</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 2</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 3</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 4</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 5</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 6</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                <div class="form-group row field">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 7</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="inputPassword">
                    </div>
                </div>
                
                <div class="form-group row text-center">
                    <div class="col-12 p-3">
                        <button type="submit" class="btn btn-success">
                            {{ __('Save Settings') }}
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection