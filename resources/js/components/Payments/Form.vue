<template>
    <fieldset class="container">
        <div class="form-group row field">
            <label class="col-sm-3 col-form-label">Select a package:</label>
            <div class="col-sm-4">
                <select v-model="model.product" name="product" class="form-control form-control-sm" @change="setTotalAmount">
                    <option v-for="product in products" v-bind:value="product.id" > {{ product.name }} </option>
                </select>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Quantity: </label>
            <div class="col-sm-4">
                <input type="text" v-model="model.quantity" name="quantity" class="form-control form-control-sm" @change="setTotalAmount"/>
            </div>
        </div>
        <div class="form-group row field">
            <label  class="col-sm-3 col-form-label">Total Amount: </label>
            <div class="col-sm-4">
                <span class="form-control form-control-sm">{{ model.total_amount }}</span>
                <input type="hidden" v-model="model.total_amount" name="total_amount" class="form-control form-control-sm" />
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
            <label class="col-sm-3 col-form-label">Select a Disbursement Method:</label>
            <div class="col-sm-4">
                <select v-model="model.disbursementmethods" name="disbursementmethods" class="form-control form-control-sm">
                    <option v-for="prm in disbursementmethods" v-bind:value="prm.method" >{{ prm.name }}</option>
                </select>
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
        props: ['member', 'model', 'products', 'wallettypes', 'paymentmethods', 'disbursementmethods'],
        methods: {
            setSourceAmount() {
                this.model.source_amount = this.member[this.model.source];
            },
            setTotalAmount () {
                var price = _.find(this.products, { 'id': this.model.product });
                this.model.total_amount = price.price * this.model.quantity;
            }
        }
    }
</script>