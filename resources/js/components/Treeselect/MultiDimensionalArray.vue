<template>
    <treeselect v-model="value"
                :name="fieldname"
                :multiple="true"
                :options="options" 
                :disable-branch-nodes="true"
                :show-count="true"
                :limit="3"/> 
</template>

<script>
    import Treeselect from '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    export default {
        props: ['value', 'selectoptions', 'fieldname'],
        data: function () {
            return {
                options: this.selectoptions
            }
        },
        mounted() {
        },
        components: {
            Treeselect
        },
    }
</script>