<template>
    <fieldset class="container">
        <div class="form-group row field">
            <label class="col-sm-3 col-form-label">Select E-Wallet:</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm " v-model="datamodel.source"  name="source" @change="setSourceAmount" required>
                    <option value='direct_referral'>Direct Referral</option>
                    <option value='encoding_bonus'>Encoding Bonus</option>
                    <option value='matching_pairs'>Matching Pair</option>
                </select>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Minimum Request: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-lg border-0"><strong>{{ model.minimum_req }}</strong> PHP</span>
                <input type="hidden" name="minimum_req" v-model="datamodel.minimum_req" />
                <input type="hidden" name="source_amount" v-model="datamodel.source_amount" />
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Amount: </label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm " name="amount" v-model="datamodel.amount"  required/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Disbursement Method</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm "  name="disbursement_method" v-model="datamodel.disbursement_method" >
                    <option value="">Select a disbursement method</option>
                    <option v-for="dm in disbursementmethods" :value="dm.method" >{{ dm.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='GCASH'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">GCASH Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="gcash_no" v-model="datamodel.gcash_no" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='PXP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Wallet ID</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="pxp_wallet_id" v-model="datamodel.pxp_wallet_id" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='PXP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Wallet Account Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="pxp_wallet_account_no" v-model="datamodel.pxp_wallet_account_no" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='IBRTPP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Bank Name</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="ibrtpp_bank_code" v-model="datamodel.ibrtpp_bank_code">
                    <option value="">Select a bank</option>
                    <option v-for="dm in ibttpbanks" :value="dm.code" >{{ dm.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='IBRTPP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Account Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="ibrtpp_bank_number" v-model="datamodel.ibrtpp_bank_number" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='UBP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Bank Name</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="ubp_bank_code" v-model="datamodel.ubp_bank_code">
                    <option value="">Select a bank</option>
                    <option v-for="dm in ubpbanks" :value="dm.code" >{{ dm.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='UBP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Account Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="ubp_bank_number" v-model="datamodel.ubp_bank_number" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='IBBT'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Bank Name</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="ibbt_bank_code" v-model="datamodel.ibbt_bank_code">
                    <option value="">Select a bank</option>
                    <option v-for="dm in ibbtbanks" :value="dm.code" >{{ dm.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='IBBT'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Account Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="ibbt_bank_number" v-model="datamodel.ibbt_bank_number" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='SBINSTAPAY'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Bank Name</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="insta_bank_code" v-model="datamodel.insta_bank_code">
                    <option value="">Select a bank</option>
                    <option v-for="dm in instabanks" :value="dm.code" >{{ dm.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='SBINSTAPAY'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Account Number</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm " name="insta_bank_number" v-model="datamodel.insta_bank_number" />
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='GHCP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Pickup Center</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="ghcp_pickupcenter" v-model="datamodel.ghcp_pickupcenter">
                    <option value="">Select a pickup center</option>
                    <option v-for="dm in ghcppicksenters" :value="dm.code" >{{ dm.description }}</option>
                </select>
            </div>
        </div>
        <div v-if="datamodel.disbursement_method=='AUCP'" class="form-group row field">
            <label  class="col-sm-3 col-form-label"><span class="ml-4">Pickup Center</span></label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm "  name="aucp_pickupcenter" v-model="datamodel.aucp_pickupcenter">
                    <option value="">Select a pickup center</option>
                    <option v-for="dm in aucppicksenters" :value="dm.code" >{{ dm.description }}</option>
                </select>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Full Name:</label>
            <div class="input-group col-sm-9">
                <input type="text" class="form-control form-control-sm "  name="firstname" v-model="datamodel.firstname" required/>
                <input type="text" class="form-control form-control-sm "  name="middlename" v-model="datamodel.middlename" />
                <input type="text" class="form-control form-control-sm "  name="lastname" v-model="datamodel.lastname" required/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Address 1:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm "  name="address1" v-model="datamodel.address1" required/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Address 2:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm "  name="address2" v-model="datamodel.address2" />
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">City*/ State/ Country*/ Zip:</label>
            <div class="input-group col-sm-9">
                <input type="text" class="form-control form-control-sm "  name="city" v-model="datamodel.city" required/>
                <input type="text" class="form-control form-control-sm "  name="state" v-model="datamodel.state" />
                <select class="form-control form-control-sm "  name="country" v-model="datamodel.country" required>
                    <option value="">Select a country</option>
                    <option value="PH">Philipines</option>
                    <option value="US">United States America</option>
                </select>
                <input type="text" class="form-control form-control-sm "  name="zip" v-model="datamodel.zip" />
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Email:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm "  name="email" v-model="datamodel.email" required/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Mobile:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm "  name="mobile" v-model="datamodel.mobile" required/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control form-control-sm "  name="password" required>
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
        props: ['member', 'model', 'disbursementmethods', 'ibttpbanks', 'ubpbanks', 'ibbtbanks', 'instabanks', 'ghcppicksenters', 'aucppicksenters'],
        data () {
            return {
                datamodel: this.model,
                disbursements: [],
                payinmethodname: 'payinmethod_name[]'
            }
        },
        methods: {
            setSourceAmount() {
                this.datamodel.source_amount = this.member[this.datamodel.source];
            }
        }
    }
</script>