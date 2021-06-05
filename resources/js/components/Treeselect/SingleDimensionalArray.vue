<template>
    <treeselect v-bind:class="haserror ? 'ae-input-field is-invalid' : 'ae-input-field'" 
                v-model="modelvalue"
                :name="fieldname"
                :multiple="multiple"
                :options="options" />
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    export default {
        props: ['value', 'selectoptions', 'haserror', 'fieldname', 'multiple'],
        data: function () {
            return {
                modelvalue: this.value,
                options: this.selectoptions.map(i => ({
                        id: i,
                        label: `${i}`
                    }))
            }
        },
        mounted() {
        },
        components: {
            Treeselect
        },
        methods: {
        }
    }
</script>