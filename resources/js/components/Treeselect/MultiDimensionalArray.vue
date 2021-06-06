<template>
    <treeselect v-model="modelvalue"
                :name="fieldname"
                :multiple="true"
                :options="options" 
                :disable-branch-nodes="true"
                :show-count="true"
                :limit="3"
                :beforeClearAll="clear"
                @close="emitchanges"/> 
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    export default {
        props: ['value', 'selectoptions', 'fieldname'],
        data: function () {
            return {
                modelvalue: this.value,
                options: this.selectoptions
            }
        },
        mounted() {
        },
        components: {
            Treeselect
        },
        methods: {
            emitchanges () {
                this.$emit('updatepayin', this.modelvalue);
            },
            clear () {
                this.$emit('updatepayin', []);
                return true;
            }
        }
    }
</script>