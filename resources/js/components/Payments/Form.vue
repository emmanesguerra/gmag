<template>
    <fieldset class="container">
        <div class="form-group row field">
            <label class="col-sm-3 col-form-label">Select a package:</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm "  name="package" id='package' onchange="updateTotalAmount(this)">
                    <option >test</option>
                </select>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Quantity: </label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm "  name="quantity" id='quantity' value="" onchange="updateTotalAmount(this)">
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Total Amount: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm" id='total_amount_s'></span>
                <input type="hidden" class="form-control form-control-sm "  name="total_amount" id='total_amount' value="">
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Select a Payment Method:</label>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="ewallet" style='cursor: pointer'>
                    <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio1" style='cursor: pointer'><small>Via E-Wallet</small></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" value="paynamics" style='cursor: pointer'>
                    <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio2" style='cursor: pointer'><small>Via Paynamics</small></label>
                </div>
            </div>
        </div>
        <div class="form-group row field" id="wallter-cont" style="">
            <label  class="col-sm-3 col-form-label">Select a Wallet:</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm "  name="source" onchange="updatesource(this)">
                    <option value='direct_referral'>Direct Referral</option>
                    <option value='encoding_bonus'>Encoding Bonus</option>
                    <option value='matching_pairs'>Matching Pair</option>
                </select>
            </div>
        </div>
        <div class="form-group row field" id="wallter-cont2" style="">
            <label  class="col-sm-3 col-form-label">Source Amount: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm" id='source_amount_s'></span>
                <input type="hidden" class="form-control form-control-sm "  name="source_amount" id='source_amount' value=''>
            </div>
        </div>

        <div class="form-group row text-center">
            <div class="col-12 p-3">
                <button type="submit" class="btn btn-success">
                    SUBMIT REQUEST
                </button>
            </div>
        </div>
    </fieldset>
</template>

<script>
    export default {
        props: ['model'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>