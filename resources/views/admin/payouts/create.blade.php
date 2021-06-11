@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Payout Account</title>
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Create Account
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('payout.accounts.store') }}" class='p-2' autocomplete="off"  enctype="multipart/form-data">
            @csrf

            @include('common.serverresponse')
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Full Name *: </label>
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm col-4" name="firstname" id='firstname' value="{{ old('firstname') }}" placeholder="First Name">
                    <input type="text" class="form-control form-control-sm col-4" name="middlename" id='middlename' value="{{ old('middlename') }}" placeholder="Middle Name">
                    <input type="text" class="form-control form-control-sm col-4" name="lastname" id='lastname' value="{{ old('lastname') }}" placeholder="Last Name">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Birth Date *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm " name="birthdate" id='birthdate' value="{{ old('birthdate') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Birth Place *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm " name="birthplace" id='birthdate' value="{{ old('birthplace') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email" id='email' value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile Number *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" id='mobile' value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 1 *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address1" id='address1' value="{{ old('address1') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 2:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address2" id='address2' value="{{ old('address2') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 3:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address3" id='address3' value="{{ old('address3') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">City*/ State/ Country*/ Zip:</label>
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm "  name="city" id='city' value="{{ old('city') }}" placeholder="City">
                    <input type="text" class="form-control form-control-sm "  name="state" id='state' value="{{ old('state') }}" placeholder="State">
                    <select class="form-control form-control-sm "  name="country" id='country'>
                        <option value="">Select a country</option>
                        <option value="PH" {{ old('country') == 'PH' ? "selected": "" }}>Philipines</option>
                        <option value="US" {{ old('country') == 'US' ? "selected": "" }}>United States America</option>
                    </select>
                    <input type="text" class="form-control form-control-sm col-2"  name="zip" id='zip' value="{{ old('zip') }}" placeholder="Zip">
                </div>
            </div>
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Nationality *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="nationality" value="{{ old('nationality') }}" />
                </div>
            </div>
            <div class="form-group row field border-0">
                <label class="col-sm-3 col-form-label">Nature Of Work *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="nature_of_work" value="{{ old('nature_of_work') }}" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-4">
                    <div class="card field mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Primary Document</h5>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document Type:</label>
                                <div class="col-sm-12">
                                    <select class="form-control form-control-sm "  name="document[0][doc]">
                                        <option value="">Select a document type</option>
                                        @foreach($pdocumentTypes as $docs) 
                                        <option value="{{ $docs->code }}" {{ old('document.0.doc') == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document ID/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[0][idnum]" value="{{ old('document.0.idnum') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="primary_kyc_expiry"  name="document[0][exp]" value="{{ old('document.0.exp') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card field mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Secondary Document 1</h5>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document Type:</label>
                                <div class="col-sm-12">
                                    <select class="form-control form-control-sm "  name="document[1][doc]">
                                        <option value="">Select a document type</option>
                                        @foreach($sdocumentTypes as $docs) 
                                        <option value="{{ $docs->code }}" {{ old("document.1.doc") == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">ID Number/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[1][idnum]" value="{{ old('document.1.idnum') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="secondary_kyc_expiry1"  name="document[1][exp]" value="{{ old('document.1.exp') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card field mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Secondary Document 2</h5>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document Type:</label>
                                <div class="col-sm-12">
                                    <select class="form-control form-control-sm "  name="document[2][doc]">
                                        <option value="">Select a document type</option>
                                        @foreach($sdocumentTypes as $docs) 
                                        <option value="{{ $docs->code }}" {{ old("document.2.doc") == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document ID/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[2][idnum]" value="{{ old('document.2.idnum') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="secondary_kyc_expiry2"  name="document[2][exp]" value="{{ old('document.2.exp') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-12 p-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('PROCEED') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script>
        $(function() {
            $("#birthdate").daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                  format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#birthdate').val(start.format('YYYY-MM-DD'));
            });
            
            $("#primary_kyc_expiry").daterangepicker({
                drops: 'up',
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                  format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#primary_kyc_expiry').val(start.format('YYYY-MM-DD'));
            });
            
            $("#secondary_kyc_expiry1").daterangepicker({
                drops: 'up',
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                  format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#secondary_kyc_expiry1').val(start.format('YYYY-MM-DD'));
            });
            
            $("#secondary_kyc_expiry2").daterangepicker({
                drops: 'up',
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                  format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#secondary_kyc_expiry2').val(start.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection