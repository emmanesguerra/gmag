@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Edit Profile</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  ACCOUNT INFORMATION
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Edit Profile
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('profile.update', $member->id) }}" class='p-2' autocomplete="off"  enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('common.serverresponse')
            
            <h4>Member Details</h4>
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Referral Link:</label>
                <div class="col-sm-4">
                    <input type="text" id="copylink" class="form-control form-control-sm text-primary" value="{{ route('register', ['ref' => $member->referral_code]) }}" />
                </div>
                <div class="col-sm-4 ml-0 pl-0">
                    <button type="button" class="btn btn-dark btn-sm" onclick="Copy()">Copy Link</button>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Full Name *: </label>
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm col-4" name="firstname" id='firstname' value="{{ old('firstname', $member->firstname) }}" placeholder="First Name">
                    <input type="text" class="form-control form-control-sm col-4" name="middlename" id='middlename' value="{{ old('middlename', $member->middlename) }}" placeholder="Middle Name">
                    <input type="text" class="form-control form-control-sm col-4" name="lastname" id='lastname' value="{{ old('lastname', $member->lastname) }}" placeholder="Last Name">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Date Joined:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->updated_at }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Entry Type:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->placement->product->code }} | {{ $member->placement->product->price }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Birth Date *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm " name="birthdate" id='birthdate' value="{{ old('birthdate', $member->birthdate) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email" id='email' value="{{ old('email', $member->email) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile Number *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" id='mobile' value="{{ old('mobile', $member->mobile) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 1 *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address1" id='address1' value="{{ old('address1', $member->address1) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 2:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address2" id='address2' value="{{ old('address2', $member->address2) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 3:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address3" id='address3' value="{{ old('address3', $member->address3) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">City*/ State/ Country*/ Zip:</label>
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm "  name="city" id='city' value="{{ old('city', $member->city) }}" placeholder="City">
                    <input type="text" class="form-control form-control-sm "  name="state" id='state' value="{{ old('state', $member->state) }}" placeholder="State">
                    <select class="form-control form-control-sm "  name="country" id='country'>
                        <option value="">Select a country</option>
                        <option value="PH" {{ old('country', $member->country) == 'PH' ? "selected": "" }}>Philipines</option>
                        <option value="US" {{ old('country', $member->country) == 'US' ? "selected": "" }}>United States America</option>
                    </select>
                    <input type="text" class="form-control form-control-sm col-2"  name="zip" id='zip' value="{{ old('zip', $member->zip) }}" placeholder="Zip">
                </div>
            </div>
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Nationality *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="nationality" value="{{ old('nationality', $member->nationality) }}" />
                </div>
            </div>
            <div class="form-group row field border-0">
                <label class="col-sm-3 col-form-label">Nature Of Work *:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="nature_of_work" value="{{ old('nature_of_work', $member->nature_of_work) }}" />
                </div>
            </div>
            
            <h4 class="mt-4">Transaction Requirements <small><small>(For Product Purchase)</small></small></h4>
            
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
                                        <option value="{{ $docs->code }}" {{ old("document.0.doc", ($member->primaryDocument) ? $member->primaryDocument->doc_type: '') == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document ID/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[0][idnum]" value="{{ old("document.0.idnum", ($member->primaryDocument) ? $member->primaryDocument->doc_id: '') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="primary_kyc_expiry"  name="document[0][exp]" value="{{ old("document.0.exp", ($member->primaryDocument) ? $member->primaryDocument->expiry_date: '') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_0" />
                                </div>
                            </div>
                            @if(($member->primaryDocument) && ($member->primaryDocument->proof))
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label" style="font-size: 14px;">Current File: <a href="{{ asset('public/storage/members/proof/'.$member->id.'/'.$member->primaryDocument->proof) }}">{{ $member->primaryDocument->proof }}</a></label>
                                <input type="hidden" name="document[0][proof]" value="{{ $member->primaryDocument->proof }}" />
                            </div>
                            @endif
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
                                        <option value="{{ $docs->code }}" {{ old("document.1.doc", ($member->secondaryDocument1) ? $member->secondaryDocument1->doc_type: '') == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">ID Number/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[1][idnum]" value="{{ old("document.1.idnum", ($member->secondaryDocument1) ? $member->secondaryDocument1->doc_id: '') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="secondary_kyc_expiry1"  name="document[1][exp]" value="{{ old("document.1.exp", ($member->secondaryDocument1) ? $member->secondaryDocument1->expiry_date: '') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_1" />
                                </div>
                            </div>
                            @if(($member->secondaryDocument1) && ($member->secondaryDocument1->proof))
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label" style="font-size: 14px;">Current File: <a href="{{ asset('public/storage/members/proof/'.$member->id.'/'.$member->secondaryDocument1->proof) }}">{{ $member->secondaryDocument1->proof }}</a></label>
                                <input type="hidden" name="document[1][proof]" value="{{ $member->secondaryDocument1->proof }}" />
                            </div>
                            @endif
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
                                        <option value="{{ $docs->code }}" {{ old("document.2.doc", ($member->secondaryDocument2) ? $member->secondaryDocument2->doc_type: '') == $docs->code ? "selected": "" }}>{{ $docs->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Document ID/ Expiry Date:</label>
                                <div class="input-group col-sm-12">
                                    <input type="text" class="form-control form-control-sm "  name="document[2][idnum]" value="{{ old("document.2.idnum", ($member->secondaryDocument2) ? $member->secondaryDocument2->doc_id: '') }}" placeholder="Document ID">
                                    <input type="text" class="form-control form-control-sm col-5" id="secondary_kyc_expiry2"  name="document[2][exp]" value="{{ old("document.2.exp", ($member->secondaryDocument2) ? $member->secondaryDocument2->expiry_date: '') }}" placeholder="Expiry Date">
                                </div>
                            </div>
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label">Proof of document:</label>
                                <div class="input-group col-sm-12">
                                    <input type="file" class=""  name="doc_proof_2" />
                                </div>
                            </div>
                            @if(($member->secondaryDocument2) && ($member->secondaryDocument2->proof))
                            <div class="form-group row border-0">
                                <label class="col-sm-12 col-form-label" style="font-size: 14px;">Current File: <a href="{{ asset('public/storage/members/proof/'.$member->id.'/'.$member->secondaryDocument2->proof) }}">{{ $member->secondaryDocument2->proof }}</a></label>
                                <input type="hidden" name="document[2][proof]" value="{{ $member->secondaryDocument2->proof }}" />
                            </div>
                            @endif
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
        
        function Copy() {
            var copyText = document.getElementById("copylink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Link copied to clipboard");
        }
    </script>
@endsection