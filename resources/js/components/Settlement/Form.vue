<template>
    <fieldset class="container">
        <input type="hidden" class="form-control form-control-sm" name="honorary_id" v-bind:value='member.honorary.id'>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Current E-Wallet: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm border-0">PHP {{ totalamount }}</span>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Credit Balance:</label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm border-0">PHP {{ creditamount }}</span>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Select a Payment Method:</label>
            <div class="col-sm-4">
                <div class="form-check form-check-inline" v-for="pm in paymentmethods" >
                    <input type="radio" v-model="model.payment_method" name="payment_method" v-bind:id="pm.method" v-bind:value="pm.method" class="form-check-input" role="button">
                    <label v-bind:for="pm.method" class="form-control form-control-sm form-check-label border-0" role="button"><small>Via {{ pm.name }}</small></label>
                </div>
            </div>
        </div>
        <div v-if="model.payment_method=='ewallet'" class="form-group row field">
            <label class="col-sm-3 col-form-label">Select a Wallet:</label>
            <div class="col-sm-4">
                <select v-model="model.source" name="source" class="form-control form-control-sm" @change="setSourceAmount">
                    <option v-for="wt in wallettypes" v-bind:value="wt.method" >{{ wt.name }}</option>
                </select>
            </div>
        </div>
        <div v-if="model.payment_method=='ewallet'" class="form-group row field">
            <label  class="col-sm-3 col-form-label">Source Amount: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm">{{ model.source_amount }}</span>
                <input type="hidden" v-model="model.source_amount" name="source_amount" class="form-control form-control-sm"/>
            </div>
        </div>
        <div v-if="model.payment_method=='paynamics'" class="form-group row field">
            <label  class="col-sm-3 col-form-label">Select a Pay In Methods: </label>
            <div class="col-sm-4">
                <treeselect-form-multi
                    v-bind:value="model.payinmethods"
                    v-bind:selectoptions="payinmethods"
                    v-bind:fieldname="payinmethodname"
                    v-on:updatepayin="updatepayin">
                </treeselect-form-multi>
            </div>
        </div>
        <div v-if="model.payment_method=='paynamics'" class="form-group row field">
            <label  class="col-sm-3 col-form-label">Amount to Pay: </label>
            <div class="col-sm-4">
                <input type="number" v-model="model.total_amount" name="total_amount" class="form-control form-control-sm"/>
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
        props: ['member', 'model', 'products', 'wallettypes', 'paymentmethods', 'payinmethods'],
        data () {
            return {
                disbursements: [],
                payinmethodname: 'payinmethod_name[]'
            }
        },
        computed: {
            totalamount() {
                return Number(this.member.total_amt).toLocaleString("en", {minimumFractionDigits: 2});
            },
            creditamount() {
                return Number(this.member.honorary.credit_amount).toLocaleString("en", {minimumFractionDigits: 2});
            }
        },
        methods: {
            setSourceAmount() {
                this.model.source_amount = this.member[this.model.source];
            },
            setTotalAmount () {
                var price = _.find(this.products, { 'id': this.model.product });
                this.model.total_amount = price.price * this.model.quantity;
            },
            openDisbursementForm () {
                window.open(this.disbursementformurl + '?method=' + this.model.disbursementmethods + '&member=' + this.member.id, '_blank');
            },
            updatepayin (data) {
                this.model.payinmethods = data;
            }
        }
    }
</script>